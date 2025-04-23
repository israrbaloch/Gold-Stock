<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware {
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/metal/buy',
        '/shop/products',
        '/savedeposit',
        '/cart-timing',
        '/exchange/prices/history',
        '/cart/cookies',
        '/cart/add',
        '/exchange/prices',
        '/payment/preload',
        '/payment/check'
    ];
}
