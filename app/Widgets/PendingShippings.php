<?php

namespace App\Widgets;

use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Facades\Voyager;
use Arrilot\Widgets\AbstractWidget;
use App\Models\ProductOrder;

class PendingShippings extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $allOrders = ProductOrder::where('shipping_option_id', 1)->whereIn('shipping_status_id', [3, 6])->get();
        $count = count($allOrders);
        $string = "Product orders with pending shipment";

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-news',
            'title'  => "{$count} {$string}",
            'text'   => 'You have ' . $count . ' ' . $string . ' in your database. Click the button below to view them.',
            'button' => [
                'text' => __('View Pending Shipping'),
                'link' => route('voyager.shippings.index'),
                'attr' => 'target:_blank',
            ],
            'image' => voyager_asset('images/widget-backgrounds/03.jpg'),
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return Auth::user()->can('browse', Voyager::model('User'));
    }
}
