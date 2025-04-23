<?php

namespace App\Http\Controllers;

use App;

class RobotsController extends Controller {
    public function robots() {
        $isProduction = App::environment('production');

        if (!$isProduction) {
            $content = "User-agent: *\nDisallow: /";
        } else {
            $lines = [
                'User-agent: *',
                'Disallow: /admin',
                'Disallow: /account',
                'Disallow: /registration-form',
                'Disallow: /profile',
                'Disallow: /update-shiping-info',
                'Disallow: /identification',
                'Disallow: /has_google',
                'Disallow: /google_login',
                'Disallow: /second-step-email',
                'Disallow: /2faemail',
                'Disallow: /2faemail/verify',
                'Disallow: /2faemail/reset',
                'Disallow: /show2fa',
                'Disallow: /generateSecret',
                'Disallow: /enable2fa',
                'Disallow: /disable2fa',
                'Disallow: /2faVerify',
                'Disallow: /setcookie',
                'Disallow: /get-products',
                'Disallow: /get-metals-prices',
                'Disallow: /liveprices',
                'Disallow: /exchange/prices',
                'Disallow: /exchange/prices/history',
                'Disallow: /confirmprodpay',
                'Disallow: /contact',
                'Disallow: /test_middleware',
                'Disallow: /cart',
                'Disallow: /cart/quantity',
                'Disallow: /cart/timing',
                'Disallow: /cart/add',
                'Disallow: /cart/add/metal',
                'Disallow: /cart/add/cash',
                'Disallow: /cart/remove',
                'Disallow: /cart/update',
                'Disallow: /cart/cookies',
                'Disallow: /cart/fedex',
                'Disallow: /cart-clear',
                'Disallow: /order/{type}/{id}',
                'Disallow: /transaction-history',
                'Disallow: /orders',
                'Disallow: /add-product',
                '',
                'Sitemap: ' . url('/sitemap.xml'),
                'Host: ' . parse_url(config('app.url'), PHP_URL_HOST),
            ];

            $content = implode("\n", $lines);
        }

        return response($content, 200, [
            'Content-Type' => 'text/plain'
        ]);
    }
}
