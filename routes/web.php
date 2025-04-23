<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\PromoCodeController;
use App\Http\Controllers\Admin\ScrapCommissionController;
use App\Http\Controllers\PriceAlertController;
use App\Http\Controllers\ScarpCalculatorContoller;
use App\Http\Controllers\TranslationController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/send-email', function () {
//     try {
//         $details = [
//             'subject' => 'Test Email',
//             'body' => 'This is a test email sent directly from web.php using Laravel.',
//         ];

//         \Mail::raw($details['body'], function ($message) use ($details) {
//             $message->to('muhammadrehanj@gmail.com') // Replace with the recipient's email
//                     ->subject($details['subject']);
//         });

//         return 'Email sent successfully!';
//     } catch (\Exception $e) {
//         return 'Failed to send email: ' . $e->getMessage();
//     }
// });

// test
// Route::get('/test', function () {
//     $user = App\Models\User::first(); // Get the first user
//     $order = App\Models\ProductOrder::find(6350); // Get the first product order
//     // $user->sendEmailVerificationNotification();

//     $url = URL::temporarySignedRoute('reviews.create', now()->addDays(7), ['order_id' => $order->id]);

//     // \Mail::to($user->email)->queue(new App\Mail\UserWelcomeMail($user->name));
//     // \Mail::to('muhammadrehanj@gmail.com')->send(new App\Mail\OrderConfirmMail($order));


//     $url = '';
//     $name = 'Rehan';

//     $oldTotal = 100;
//     $oldProducts = $order->products;
//     // $user = 'Rehan';
//     $promoCode = App\Models\PromoCode::find(4);
//     return view('emails.user.order-modified', compact('url', 'order', 'name', 'user', 'promoCode', 'oldTotal', 'oldProducts'));
// });

Route::middleware(['signed'])->group(function () {
    Route::get('/reviews/create', 'App\Http\Controllers\ReviewController@create')->name('reviews.create');

    Route::get('/orders/approve/{order}', 'App\Http\Controllers\AdminProductOrderController@approveOrder')
        ->name('orders.approve');
});



Route::post('/reviews/store', 'App\Http\Controllers\ReviewController@store')->name('reviews.store');
Route::get('/product/{productId}/reviews', 'App\Http\Controllers\ReviewController@fetchReviews')->name('product.reviews.fetch');

Route::get('/robots.txt', 'App\Http\Controllers\RobotsController@robots');

Auth::routes(['verify' => true]);

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');
// Route::post('/translate', [TranslationController::class, 'translate'])->name('translate');
// Route::get('/get-language', [TranslationController::class, 'getLanguage'])->name('get-language');

// about-us
Route::get('/about-us', 'App\Http\Controllers\HomeController@aboutus')->name('about-us');

// search
Route::get('/search', 'App\Http\Controllers\HomeController@search')->name('search');

Route::get('/home', function () {
    return redirect('/');
});

// payment-types
Route::get('/payment-types', 'App\Http\Controllers\PaymentTypesController@index')->name('payment-types');

// Exchange
Route::get('/exchange/{metal}', 'App\Http\Controllers\ExchangeController@index');
Route::post('/metal/sell', 'App\Http\Controllers\ExchangeController@sellMetal')->name('sellmetal');
Route::post('/metal/buy', 'App\Http\Controllers\ExchangeController@buyMetal')->name('buymetal');
Route::post('/exchange/prices/history', 'App\Http\Controllers\AjaxPricesController@getPricesHistoryAjax')->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/exchange/prices', 'App\Http\Controllers\AjaxPricesController@getExchangePrices');
Route::get('/exchange', function () {
    return redirect('/exchange/gold', 301);
})->name('exchange');

Route::post('/liveprices', 'App\Http\Controllers\AjaxPricesController@getLivePricesAjax')->name('liveprices')->withoutMiddleware([VerifyCsrfToken::class]);
Route::get('/live-prices', 'App\Http\Controllers\LivePricesController@getView')->name('getliveprices');

Route::get('/refining', 'App\Http\Controllers\RefiningController@getView')->name('refining');

Route::get('/contact', 'App\Http\Controllers\ContactController@getView')->name('contact');
Route::post('/contact', 'App\Http\Controllers\ContactController@store')->middleware('turnstile')->name('contact.store');
// Route::post('/contact', 'App\Http\Controllers\ContactController@store')->name('contact.store');

Route::get('/faq', 'App\Http\Controllers\FaqController@getView')->name('faq');

Route::get('/protect/{token}', 'App\Http\Controllers\HomeController@protectSite')->name('protect');


Route::post('/setcookie', 'App\Http\Controllers\AjaxController@setCookie')->name('setcookie');

Route::post('/get-products', 'App\Http\Controllers\AjaxController@getProducts')->name('getproducts');

Route::post('/get-metals-prices', 'App\Http\Controllers\ExchangeController@getMetalPrices')->name('getmetalsprices');

Route::get('/transaction-history', 'App\Http\Controllers\TransactionHistoryController@getView');

Route::get('/orders', 'App\Http\Controllers\OrderHistoryController@getView')->name('orderHistory');

// Funds
Route::get('/funds', 'App\Http\Controllers\FundsController@getView');

Route::match(array('GET', 'POST'), '/account', 'App\Http\Controllers\MyAccountController@getView')->name('account');

Route::post('/update-shiping-info', 'App\Http\Controllers\MyAccountController@saveShippingInfo')->name('updateShipingInfo');

Route::post('/has_google', 'App\Http\Controllers\Auth\LoginController@hasGoogleLogin')->name('has_google');

Route::post('/google_login', 'App\Http\Controllers\Auth\LoginController@verify2fa')->name('googleLogin');

Route::get('/registration-form', 'App\Http\Controllers\MyAccountController@setProfile')->name('profile');

Route::post('/account', 'App\Http\Controllers\MyAccountController@saveLoginData');

Route::post('/save-profile', 'App\Http\Controllers\MyAccountController@saveProfile')->name('saveprofile');

Route::post('/identification', 'App\Http\Controllers\MyAccountController@saveIdentification')->name('identification');


Route::get('/whitdrawal-cash', 'App\Http\Controllers\CashWhitdrawalController@getView');

Route::post('/savewhitdrawal', 'App\Http\Controllers\CashWhitdrawalController@saveWhitdrawal')->name('savewhitdrawal');

Route::get('/deposit', 'App\Http\Controllers\CashDepositController@deposit');

Route::get('/whitdraw', 'App\Http\Controllers\CashWhitdrawalController@whitdraw');

Route::get('/deposit-coin', 'App\Http\Controllers\CashDepositController@depositCoin');

Route::get('/convert-to-physical', 'App\Http\Controllers\ConvertPhysicalController@getView');

Route::get('/convert', 'App\Http\Controllers\ConvertPhysicalController@convert');

Route::post('/saveconvertion', 'App\Http\Controllers\ConvertPhysicalController@saveConvertion')->name('saveconvertion');

Route::get('/holding', 'App\Http\Controllers\HoldingsController@getView');


Route::post('/get-metals', 'App\Http\Controllers\ExchangeController@getMetals')->name('getmetals');

// Route::post('/confirmprodpay', 'App\Http\Controllers\ShopController@confirmCCPayment')->name('buyproduct');



Route::get('/product/{id}/{name?}', 'App\Http\Controllers\ProductsController@getSingleProduct');
Route::get('/alerts', [PriceAlertController::class, 'index'])->name('alerts.index');
Route::post('/alerts', [PriceAlertController::class, 'store'])->name('alerts.store');
Route::delete('/alerts/{id}', [PriceAlertController::class, 'destroy'])->name('alerts.destroy');
// alert.markAsRead
Route::post('/alerts/markAsRead', [PriceAlertController::class, 'markAsRead'])->name('alert.markAsRead');
Route::get('/notifications/mark-all-read', [PriceAlertController::class, 'markAllRead'])->name('notifications.mark-all-read');


Route::post('/add-product', 'App\Http\Controllers\ProductsController@addProduct')->name('addproduct');

// Cart
Route::get('/cart', 'App\Http\Controllers\CartController@index')->name('cart');
Route::group(['prefix' => 'cart'], function () {
    Route::get('/quantity', 'App\Http\Controllers\CartController@quantity');
    Route::post('/timing', 'App\Http\Controllers\CartController@checkCartTiming')->name('cart.review');
    Route::post('/add', 'App\Http\Controllers\CartController@add')->name('cart.add');
    Route::post('/add/metal', 'App\Http\Controllers\CartController@addMetal')->name('cart.addmetal');
    Route::post('/add/cash', 'App\Http\Controllers\CartController@addCash')->name('cart.addcash');
    Route::post('/remove', 'App\Http\Controllers\CartController@remove')->name('cart.remove');
    Route::post('/update', 'App\Http\Controllers\CartController@update')->name('cart.update');
    Route::post('/cookies', 'App\Http\Controllers\CartController@setCartCookies')->name('set-cart-cookie');
    Route::post('/fedex', 'App\Http\Controllers\CartController@getFedex')->name('cart.fedex');
});
Route::post('/cart-clear', 'App\Http\Controllers\CartController@clear')->name('cart.clear');

Route::get('/order/{type}/{id}', 'App\Http\Controllers\OrdersController@index')->name('order');



Route::get('/second-step-email', [App\Http\Controllers\TwoFAController::class, 'index'])->name('2faemail.index');

Route::post('/2faemail', [App\Http\Controllers\TwoFAController::class, 'store'])->name('2faemail.post');

Route::post('/2faemail/verify', [App\Http\Controllers\TwoFAController::class, 'verify'])->name('2faemail.enable');

Route::post('/2faemail/reset', [App\Http\Controllers\TwoFAController::class, 'resend'])->name('2faemail.resend');

// Route::get('/scrapcalculator', 'App\Http\Controllers\CalculatorController@getView')->name('scrapcalculator');

// scrap-calculator
Route::get('/scrapcalculator', [ScarpCalculatorContoller::class, 'index'])->name('scrapcalculator');

Route::group(['prefix' => '2fa'], function () {
    Route::post('/show2fa', 'App\Http\Controllers\LoginSecurityController@show2faForm')->name('show2faForm');
    Route::post('/generateSecret', 'App\Http\Controllers\LoginSecurityController@generate2faSecret')->name('generate2faSecret');
    Route::post('/enable2fa', 'App\Http\Controllers\LoginSecurityController@enable2fa')->name('enable2fa');
    Route::post('/disable2fa', 'App\Http\Controllers\LoginSecurityController@disable2fa')->name('disable2fa');

    // 2fa middleware
    Route::post('/2faVerify', function () {
        return redirect(URL()->previous());
    })->name('2faVerify')->middleware('2fa');
});

// Policies
Route::get('/policy/sales', 'App\Http\Controllers\PolicyController@getSalesPolicyView');
Route::get('/policy/cookies', 'App\Http\Controllers\PolicyController@getCookiesPolicyView');
Route::get('/policy/ecommerce', 'App\Http\Controllers\PolicyController@getECommercePolicyView');
Route::get('/policy/disclaimer', 'App\Http\Controllers\PolicyController@getDisclaimerPolicyView');
Route::get('/policy/privacy', 'App\Http\Controllers\PolicyController@getPrivacyPolicyView');
Route::get('/policy/terms', 'App\Http\Controllers\PolicyController@getTermsPolicyView');
Route::get('/policy/use', 'App\Http\Controllers\PolicyController@getUsePolicyView');

// News
Route::get('/news', 'App\Http\Controllers\NewsController@index');
Route::get('/news/{slug}', 'App\Http\Controllers\NewsController@getNewView');

// Blog
Route::get('/blog', 'App\Http\Controllers\BlogController@index')->name('blog');
Route::get('/blog/{slug}', 'App\Http\Controllers\BlogController@getBlogView');

// Test Mail
if (config('app.env') == 'local' || config('app.env') == 'staging') {
    Route::group(['prefix' => 'test'], function () {
        Route::group(['prefix' => 'mail'], function () {
            Route::get('/sendAll/{pass}/{email}', 'App\Http\Controllers\TestMailController@sendAll');

            Route::get('/verifyEmail', 'App\Http\Controllers\TestMailController@verifyEmail');
            Route::get('/welcome', 'App\Http\Controllers\TestMailController@welcome');
            Route::get('/productTransactionCompleted', 'App\Http\Controllers\TestMailController@productTransactionCompleted');
            Route::get('/adminProductTransactionCompleted', 'App\Http\Controllers\TestMailController@adminProductTransactionCompleted');
            Route::get('/metalTransactionCompleted', 'App\Http\Controllers\TestMailController@metalTransactionCompleted');
            Route::get('/adminMetalTransactionCompleted', 'App\Http\Controllers\TestMailController@adminMetalTransactionCompleted');
            Route::get('/depositConfirmation', 'App\Http\Controllers\TestMailController@depositConfirmation');
            Route::get('/depositCompleted', 'App\Http\Controllers\TestMailController@depositCompleted');
            Route::get('/withdrawalConfirmation', 'App\Http\Controllers\TestMailController@withdrawalConfirmation');
            Route::get('/physicalConversion', 'App\Http\Controllers\TestMailController@physicalConversion');
            Route::get('/adminPhysicalConversion', 'App\Http\Controllers\TestMailController@adminPhysicalConversion');
            Route::get('/supportMail', 'App\Http\Controllers\TestMailController@supportMail');
            Route::get('/passwordChange', 'App\Http\Controllers\TestMailController@passwordChange');
            Route::get('/verification', 'App\Http\Controllers\TestMailController@verification');
        });
    });
}

// Payment
Route::group(['prefix' => 'payment'], function () {
    Route::post('/preload', 'App\Http\Controllers\PaymentController@preload');
    Route::post('/check', 'App\Http\Controllers\PaymentController@check');
});

// test middleware
Route::get('/test_middleware', function () {
    return "2FA middleware work!";
})->middleware(['auth', '2fa']);

// Email Verification
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Subscription as resource
Route::resource('subscription', 'App\Http\Controllers\SubscriptionController');
Route::post('user/subscribe', 'App\Http\Controllers\SubscriptionController@subscribe');
Route::post('user/unsubscribe', 'App\Http\Controllers\SubscriptionController@unsubscribe');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
// Admin
// Route::group(['prefix' => 'admin', 'middleware' => 'is_admin'], function () {
Route::group(['prefix' => 'admin'], function () {

    Route::resource('banners', BannerController::class)->names('admin.banners');
    // scrap metals commission
    Route::get('/scrap-metals-commission', [ScrapCommissionController::class, 'index'])->name('admin.scrap-metals-commission');
    // update
    Route::post('/scrap-metals-commission', [ScrapCommissionController::class, 'update'])->name('admin.scrap-metals-commission.update');

    // Route::resource('accounts', 'App\Http\Controllers\Admin\AccountController')->names('admin.accounts');
    Route::get('/user-identifications', 'App\Http\Controllers\Admin\IdentificationController@index')->name('admin.identifications.user');
    Route::post('/user-identifications/approve/{identification}', 'App\Http\Controllers\Admin\IdentificationController@approve')->name('admin.identifications.approve');
    Route::post('/user-identifications/reject/{identification}', 'App\Http\Controllers\Admin\IdentificationController@reject')->name('admin.identifications.reject');
    Route::get('/send-identification-mail', 'App\Http\Controllers\Admin\IdentificationController@sendIdentificationMail')->name('admin.send.identification.mail');
    // Blog
    Route::get('/blogs', 'App\Http\Controllers\AdminBlogsController@index')->name('voyager.blogs.index');
    Route::get('/blogs/create', 'App\Http\Controllers\AdminBlogsController@getCreateView')->name('admin.blogs.create.view');
    Route::post('/blogs/create', 'App\Http\Controllers\AdminBlogsController@create')->name('admin.blogs.create');
    Route::get('/blogs/{id}', 'App\Http\Controllers\AdminBlogsController@getUpdateView')->name('admin.blogs.update.view');
    Route::put('/blogs/{id}', 'App\Http\Controllers\AdminBlogsController@update')->name('admin.blogs.update');

    // News
    Route::get('/news', 'App\Http\Controllers\AdminNewsController@index')->name('voyager.news.index');
    Route::get('/news/create', 'App\Http\Controllers\AdminNewsController@getCreateView')->name('admin.news.create.view');
    Route::post('/news/create', 'App\Http\Controllers\AdminNewsController@create')->name('admin.news.create');
    Route::get('/news/{id}', 'App\Http\Controllers\AdminNewsController@getUpdateView')->name('admin.news.update.view');
    Route::put('/news/{id}', 'App\Http\Controllers\AdminNewsController@update')->name('admin.news.update');

    // Subscription list
    Route::get('/mails/list', 'App\Http\Controllers\SubscriptionListController@index');
    Route::get('/mails/list/create', 'App\Http\Controllers\SubscriptionListController@create')->name('admin.mails.subscription.create.view');
    Route::post('/mails/list/create', 'App\Http\Controllers\SubscriptionListController@store')->name('admin.mails.subscription.create');
    Route::get('/mails/list/{id}', 'App\Http\Controllers\SubscriptionListController@edit')->name('admin.mails.subscription.update.view');
    Route::put('/mails/list/{id}', 'App\Http\Controllers\SubscriptionListController@update')->name('admin.mails.subscription.update');

    // Scheduler
    Route::get('/mails/scheduler', 'App\Http\Controllers\SchedulerController@index');
    Route::get('/mails/scheduler/create', 'App\Http\Controllers\SchedulerController@getCreateView')->name('admin.mails.scheduler.create.view');
    Route::post('/mails/scheduler/create', 'App\Http\Controllers\SchedulerController@create')->name('admin.mails.scheduler.create');
    Route::get('/mails/scheduler/{id}', 'App\Http\Controllers\SchedulerController@getUpdateView')->name('admin.mails.scheduler.update.view');
    Route::put('/mails/scheduler/{id}', 'App\Http\Controllers\SchedulerController@update')->name('admin.mails.scheduler.update');
    Route::get('/mails/scheduler/{templateId}/{type}/{listId}/users', 'App\Http\Controllers\SchedulerController@users');

    // Templates
    Route::get('/mails', 'App\Http\Controllers\MailTemplateController@index');
    Route::get('/mails/create', 'App\Http\Controllers\MailTemplateController@getCreateView')->name('admin.mails.create.view');
    Route::post('/mails/create', 'App\Http\Controllers\MailTemplateController@create')->name('admin.mails.create');
    Route::get('/mails/template/{id}', 'App\Http\Controllers\MailTemplateController@getMailTemplateView');
    Route::get('/mails/view/{view}', 'App\Http\Controllers\MailTemplateController@getMailView');
    Route::get('/mails/{id}', 'App\Http\Controllers\MailTemplateController@getUpdateView')->name('admin.mails.update.view');
    Route::put('/mails/{id}', 'App\Http\Controllers\MailTemplateController@update')->name('admin.mails.update');

    // Search
    Route::get('/search/user/{search}', 'App\Http\Controllers\AdminSearchController@users');
    Route::get('/search/product/{search}', 'App\Http\Controllers\AdminSearchController@products');
    Route::get('/search/blog/{search}', 'App\Http\Controllers\AdminSearchController@blogs');
    Route::get('/search/news/{search}', 'App\Http\Controllers\AdminSearchController@news');

    // SEO
    Route::get('/seos-pages', 'App\Http\Controllers\SEOController@index');
    Route::get('/seos-products', 'App\Http\Controllers\SEOController@indexProducts')->name('voyager.seos-products.index');
    Route::get('/seos-blogs', 'App\Http\Controllers\SEOController@indexBlogs')->name('voyager.seos-blogs.index');
    Route::get('/seos-news', 'App\Http\Controllers\SEOController@indexNews')->name('voyager.seos-news.index');
    Route::get('/seos-uri', 'App\Http\Controllers\SEOController@editURI')->name('voyager.seos.edit.uri');
    Route::delete('/keywords/all', 'App\Http\Controllers\KeywordController@destroyAll');
    Route::resource('seos', 'App\Http\Controllers\SEOController')->names([
        'create' => 'voyager.seos.create',
        'store' => 'voyager.seos.store',
    ]);
    Route::resource('keywords', 'App\Http\Controllers\KeywordController');

    // Orders
    Route::get('/orders/metals', 'App\Http\Controllers\AdminMetalOrderController@index')->name('admin.orders.metals');
    Route::get('/orders/metals/{id}', 'App\Http\Controllers\AdminMetalOrderController@edit')->name('admin.orders.metals.view');
    Route::put('/orders/metals/{id}', 'App\Http\Controllers\AdminMetalOrderController@update')->name('admin.orders.metals.update');

    // Product Orders
    Route::get('/orders/products', 'App\Http\Controllers\AdminProductOrderController@index')->name('admin.orders.products');
    Route::get('/orders/products/data', 'App\Http\Controllers\AdminProductOrderController@getProductOrdersData')->name('admin.orders.products.data');
    Route::get('/orders/products/{id}', 'App\Http\Controllers\AdminProductOrderController@show')->name('admin.orders.products.view');
    Route::get('/orders/products/edit-old/{id}', 'App\Http\Controllers\AdminProductOrderController@edit')->name('admin.orders.products.update');

    // admin.orders.products.local.create.view
    Route::get('/orders/products-order/create', 'App\Http\Controllers\AdminProductOrderController@create')->name('admin.orders.products.create');
    // store
    Route::post('/orders/products-order', 'App\Http\Controllers\AdminProductOrderController@store')->name('admin.orders.products.store');
    // order-customer-details/edit
    Route::get('/orders/products/{id}/order-customer-details/edit', 'App\Http\Controllers\AdminProductOrderController@editOrderCustomerDetails')->name('admin.orders.products.edit-order-customer-details');
    Route::post('/orders/products/{id}/order-customer-details', 'App\Http\Controllers\AdminProductOrderController@updateOrderCustomerDetails')->name('admin.orders.products.update-order-customer-details');

    // shipping-address/edit
    Route::get('/orders/products/{id}/shipping-address/edit', 'App\Http\Controllers\AdminProductOrderController@editShippingAddress')->name('admin.orders.products.edit-shipping-address');
    Route::post('/orders/products/{id}/shipping-address', 'App\Http\Controllers\AdminProductOrderController@updateShippingAddress')->name('admin.orders.products.update-shipping-address');

    // billing-address/edit
    Route::get('/orders/products/{id}/billing-address/edit', 'App\Http\Controllers\AdminProductOrderController@editBillingAddress')->name('admin.orders.products.edit-billing-address');
    Route::post('/orders/products/{id}/billing-address', 'App\Http\Controllers\AdminProductOrderController@updateBillingAddress')->name('admin.orders.products.update-billing-address');

    // edit-product-info
    Route::get('/orders/products/{id}/edit-product-info', 'App\Http\Controllers\AdminProductOrderController@editProductInfo')->name('admin.orders.products.edit-product-info');
    Route::post('/orders/products/{id}/edit-product-info', 'App\Http\Controllers\AdminProductOrderController@updateProductInfo')->name('admin.orders.products.update-product-info');

    // payment-info/edit
    Route::get('/orders/products/{id}/payment-info/edit', 'App\Http\Controllers\AdminProductOrderController@editPaymentInfo')->name('admin.orders.products.edit-payment-info');
    Route::post('/orders/products/{id}/payment-info', 'App\Http\Controllers\AdminProductOrderController@updatePaymentInfo')->name('admin.orders.products.update-payment-info');

    // order-info/edit
    Route::get('/orders/products/{id}/order-info/edit', 'App\Http\Controllers\AdminProductOrderController@editOrderInfo')->name('admin.orders.products.edit-order-info');
    Route::post('/orders/products/{id}/order-info', 'App\Http\Controllers\AdminProductOrderController@updateOrderInfo')->name('admin.orders.products.update-order-info');
    // admin.orders.products.get-product-details

    // order-products/edit
    Route::get('/orders/products/{id}/order-products/edit', 'App\Http\Controllers\AdminProductOrderController@editOrderProducts')->name('admin.orders.products.edit-order-products');
    Route::post('/orders/products/get-product-details', 'App\Http\Controllers\AdminProductOrderController@getProductDetails')->name('admin.orders.products.get-product-details');
    Route::post('/orders/products/{id}/order-products', 'App\Http\Controllers\AdminProductOrderController@updateOrderProducts')->name('admin.orders.products.update-order-products');

    // Route::put('/orders/products/{id}', 'App\Http\Controllers\AdminProductOrderController@update')->name('admin.orders.products.update');

    // Transactions
    Route::get('/transactions/metals', 'App\Http\Controllers\AdminMetalTransactionController@index')->name('admin.transactions.metals');
    Route::get('/transactions/metals/{id}/{type}', 'App\Http\Controllers\AdminMetalTransactionController@edit')->name('admin.transactions.metals.view');
    Route::put('/transactions/metals/{id}/{type}', 'App\Http\Controllers\AdminMetalTransactionController@update')->name('admin.transactions.metals.update');
    Route::get('/transactions/cash', 'App\Http\Controllers\AdminCashTransactionController@index')->name('admin.transactions.cash');
    Route::get('/transactions/cash/{id}/{type}', 'App\Http\Controllers\AdminCashTransactionController@edit')->name('admin.transactions.cash.view');
    Route::put('/transactions/cash/{id}/{type}', 'App\Http\Controllers\AdminCashTransactionController@update')->name('admin.transactions.cash.update');

    // Legacy
    Route::post('/update-shipping-status', 'App\Http\Controllers\PendingShippingsController@updateShippingStatus')->name('admin.update-shipping-status');
    Route::get('/shippings', 'App\Http\Controllers\PendingShippingsController@getView')->name('voyager.shippings.index');
    Route::get('/payments', 'App\Http\Controllers\PendingPaymentsController@getView')->name('voyager.pending.index');
    Route::get('/users-orders-compilation-data-products/{id}', 'App\Http\Controllers\UsersOrdersCompilationController@getDataOrderProducts')->name('admin.users-orders-compilation-data-producs');
    Route::get('/users-orders-compilation-data-metals/{id}', 'App\Http\Controllers\UsersOrdersCompilationController@getDataOrderMetals')->name('admin.users-orders-compilation-data-metals');

    Route::get('/users-balances-data/{id?}', 'App\Http\Controllers\UsersBalancesController@getData')->name('admin.users-balances-data');

    Route::get('/daily-activity', 'App\Http\Controllers\AllCompilationController@getView')->name('admin.daily-activity');
    Route::post('/da-user-orders', 'App\Http\Controllers\AllCompilationController@getUserOrders')->name('admin.user.orders');
    Route::post('/da-user-balances', 'App\Http\Controllers\AllCompilationController@getUserBalances')->name('admin.user.balances');
    Route::post('/da-user-deposits', 'App\Http\Controllers\AllCompilationController@getUserDeposits')->name('admin.user.deposits');
    Route::post('/da-user-withdrawals', 'App\Http\Controllers\AllCompilationController@getUserWithdrawals')->name('admin.user.withdrawals');

    // Legacy Compilations
    Route::get('/pending-orders', 'App\Http\Controllers\PendingOrdersController@getView')->name('voyager.pending-orders.index');
    Route::get('/users-orders-compilation', 'App\Http\Controllers\UsersOrdersCompilationController@getView')->name('voyager.users-orders-compilation.index');
    Route::get('/users-transactions-compilation', 'App\Http\Controllers\UsersTransactionsCompilationController@getView')->name('voyager.users-transactions-compilation.index');
    Route::get('/users-balances', 'App\Http\Controllers\UsersBalancesController@getView')->name('voyager.users-balances.index');
    Route::get('/users-balances-compilation', 'App\Http\Controllers\UserBalancesCompilationController@getView')->name('voyager.users-balances-compilation.index');

    // products
    // Route::get('/products', 'App\Http\Controllers\AdminProductController@index')->name('voyager.products.index');
    Route::resource('promo-codes', 'App\Http\Controllers\Admin\PromoCodeController')->names('admin.promo-codes');
    // Send Promo code Email to users
    Route::get('/send-promo-code', 'App\Http\Controllers\Admin\PromoCodeController@sendPromoCode')->name('admin.promo-codes.send');
    // Send Promo code Email to users
    Route::post('/send-promo-code', 'App\Http\Controllers\Admin\PromoCodeController@sendPromoCodeEmail')->name('admin.promo-codes.send-email');

    // users ajax for select2
    Route::get('/ajax-users', 'App\Http\Controllers\AjaxController@getSelect2Data')->name('admin.ajax-users');
});

// voyager.seos.index
Route::get('/admin/seos', 'App\Http\Controllers\SEOController@index')->name('voyager.seos.index');

Route::get('/login', function () {
    return view('login');
})->name('login');

// Checkout
Route::get('/checkout', 'App\Http\Controllers\CheckoutController@index')->name('checkout');
// /cart/promo
Route::post('/cart/promo', 'App\Http\Controllers\CartController@applyPromo')->name('cart.promo');
// update payment method in session by function
Route::post('/cart/payment-method', 'App\Http\Controllers\CartController@updatePaymentMethod')->name('cart.payment-method');



// check-shipping-address
Route::post('/check-shipping-address', 'App\Http\Controllers\CheckoutController@checkShippingAddress')->name('check-shipping-address');
// Shop
Route::get('/shop', 'App\Http\Controllers\ProductsController@getView')->name('shop');
Route::post('/shop/products', 'App\Http\Controllers\ShopController@buyProducts')->name('buyproduct');

// get-producers
// Route::get('/get-producers', 'App\Http\Controllers\ShopController@getProducers')->name('getproducers');
Route::get('/products', function () {
    return redirect('/shop', 301);
});

// redirect /product to /shop
Route::get('/product', function () {
    return redirect('/shop');
});

// Cash Deposit
Route::post('/savedeposit', 'App\Http\Controllers\CashDepositController@saveDeposit')->name('savedeposit');
Route::get('/deposit-cash', 'App\Http\Controllers\CashDepositController@getView');

Route::post('/2fa_login', function () {
    return view('google_login');
})->name('googlelogin');

Auth::routes();
Route::get('/popups', function () {
    return view('popups');
})->name('popups');
