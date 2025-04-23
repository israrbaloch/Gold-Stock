<?php

namespace App\Providers;

use App\Helper\BalanceHelper;
use App\Helper\HistoricalHelper;
use App\Models\SEO;
use Cache;
use Cookie;
use DB;
use Illuminate\Support\ServiceProvider;
use Sentry\State\HubInterface;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(HubInterface $sentry)
    {
        Voyager::addAction(\App\Actions\IdentificationAction::class);
        Voyager::addAction(\App\Actions\IdentificationMailAction::class);

        Paginator::defaultView('pagination::default');
        Paginator::useBootstrap();
        \Illuminate\Pagination\Paginator::defaultSimpleView('pagination::simple-default');

        // config(['voyager.paginate' => 10]);

        if ($this->app->environment('local') || $this->app->environment('staging')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
        }

        DB::listen(function ($query) use ($sentry) {
            $sentry->addBreadcrumb(new \Sentry\Breadcrumb(
                \Sentry\Breadcrumb::LEVEL_INFO,
                \Sentry\Breadcrumb::TYPE_DEFAULT,
                'sql.query',
                $query->sql,
                [
                    'bindings' => $query->bindings,
                    'time' => $query->time,
                ]
            ));
        });

        view()->composer('*', function ($view) {

            // SEO
            $this->setSEO($view);

            // Historical
            $this->setHistorical($view);

            // Balance
            $this->setBalance($view);
        });
    }

    private function setSEO($view)
    {
        $metaTitle = null;
        $metaDescription = null;
        $metaKeywords = null;

        // is get request
        if (request()->isMethod('get')) {
            // get uri
            $uri = request()->path();
            // get keywords
            $seo = Cache::remember('site_meta_seo_' . $uri, 60 * 24, function () {
                $uri = request()->path();
                return SEO::where('uri', $uri)->first();
            });
            // join keywords
            if ($seo) {

                // set title
                if ($seo->title) {
                    $metaTitle = $seo->title;
                }

                // set meta description
                if ($seo->description) {
                    $metaDescription = $seo->description;
                }

                // set meta keywords
                if ($seo->keywords && $seo->keywords->count() > 0) {
                    $metaKeywords = $seo->keywords->map(function ($keyword) {
                        return $keyword->value;
                    })->join(', ');
                }
            }
        }
        $view
            ->with('metaTitle', $metaTitle)
            ->with('metaDescription', $metaDescription)
            ->with('metaKeywords', $metaKeywords);
    }

    private function setHistorical($view)
    {
        $_currency = Cookie::get('currency') ?: 'CAD';
        $_metals = HistoricalHelper::getCurrentMetalPrices();
        $_oldMetals = HistoricalHelper::getOldMetalPrices();
        $_currencies = HistoricalHelper::getCurrentCurrencyPrices();

        switch ($_currency) {
            case 'USD':
                $_currencyRate = $_currencies['usd']->value;
                break;
            case 'CAD':
            default:
                $_currencyRate = $_currencies['cad']->value;
                break;
            case 'EUR':
                $_currencyRate = $_currencies['eur']->value;
                break;
        }

        $view
            ->with('_metals', $_metals)
            ->with('_currencies', $_currencies)
            ->with('_currencyRate', $_currencyRate)
            ->with('_oldMetals', $_oldMetals)
            ->with('_currency', strtolower($_currency));
    }

    private function setBalance($view)
    {
        $userBalances = BalanceHelper::getUserBalances();
        $view->with('_userBalances', $userBalances);
    }
}
