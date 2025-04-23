<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Log;
use Str;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Permission;

class CustomVoyagerData extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DataType::truncate();
        DataRow::truncate();

        $users = $this->process('users', DataType::firstOrCreate(
            ['name' => 'users'],
            [
                'name' => 'users',
                'slug' => 'users',
                'display_name_singular' => ucfirst('User'),
                'display_name_plural' => Str::plural('User'),
                'icon' => 'voyager-people',
                'model_name' => 'TCG\Voyager\Models\User',
                'policy_name' => 'TCG\Voyager\Policies\UserPolicy',
                'controller' => 'TCG\Voyager\Http\Controllers\VoyagerUserController',
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 1,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->setDataRowBread($users, 'subscribed', '');
        $this->setDataRowBread($users, 'news_subscribed', '');
        $this->setDataRowBread($users, 'blogs_subscribed', '');
        $this->setDataRowBread($users, 'promo_subscribed', '');
        $dataRow = $this->dataRow($users, 'user_belongsto_role_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'relationship',
                'display_name' => __('voyager::seeders.data_rows.role'),
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 0,
                'details'      => [
                    'model'       => 'TCG\\Voyager\\Models\\Role',
                    'table'       => 'roles',
                    'type'        => 'belongsTo',
                    'column'      => 'role_id',
                    'key'         => 'id',
                    'label'       => 'display_name',
                    'pivot_table' => 'roles',
                    'pivot'       => 0,
                ],
                'order'        => 10,
            ])->save();
        }

        $dataRow = $this->dataRow($users, 'user_belongstomany_role_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'relationship',
                'display_name' => 'Roles',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 0,
                'details'      => [
                    'model'       => 'TCG\\Voyager\\Models\\Role',
                    'table'       => 'roles',
                    'type'        => 'belongsToMany',
                    'column'      => 'id',
                    'key'         => 'id',
                    'label'       => 'display_name',
                    'pivot_table' => 'user_roles',
                    'pivot'       => '1',
                    'taggable'    => '0',
                ],
                'order'        => 11,
            ])->save();
        }
        $this->process('menus', DataType::firstOrCreate(
            ['name' => 'menus'],
            [
                'name' => 'menus',
                'slug' => 'menus',
                'display_name_singular' => ucfirst('Menu'),
                'display_name_plural' => Str::plural('Menu'),
                'icon' => 'voyager-list',
                'model_name' => 'TCG\Voyager\Models\Menu',
                'policy_name' => null,
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('roles', DataType::firstOrCreate(
            ['name' => 'roles'],
            [
                'name' => 'roles',
                'slug' => 'roles',
                'display_name_singular' => ucfirst('Role'),
                'display_name_plural' => Str::plural('Role'),
                'icon' => 'voyager-lock',
                'model_name' => 'TCG\Voyager\Models\Role',
                'policy_name' => null,
                'controller' => 'TCG\Voyager\Http\Controllers\VoyagerRoleController',
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('categories', DataType::firstOrCreate(
            ['name' => 'categories'],
            [
                'name' => 'categories',
                'slug' => 'categories',
                'display_name_singular' => ucfirst('Category'),
                'display_name_plural' => Str::plural('Category'),
                'icon' => 'voyager-categories',
                'model_name' => 'TCG\Voyager\Models\Category',
                'policy_name' => null,
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('posts', DataType::firstOrCreate(
            ['name' => 'posts'],
            [
                'name' => 'posts',
                'slug' => 'posts',
                'display_name_singular' => ucfirst('Post'),
                'display_name_plural' => Str::plural('Post'),
                'icon' => 'voyager-news',
                'model_name' => 'TCG\Voyager\Models\Post',
                'policy_name' => 'TCG\Voyager\Policies\PostPolicy',
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('pages', DataType::firstOrCreate(
            ['name' => 'pages'],
            [
                'name' => 'pages',
                'slug' => 'pages',
                'display_name_singular' => ucfirst('Page'),
                'display_name_plural' => Str::plural('Page'),
                'icon' => 'voyager-file-text',
                'model_name' => 'TCG\Voyager\Models\Page',
                'policy_name' => null,
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('identifications', DataType::firstOrCreate(
            ['name' => 'identifications'],
            [
                'name' => 'identifications',
                'slug' => 'identifications',
                'display_name_singular' => ucfirst('Identification'),
                'display_name_plural' => Str::plural('Identification'),
                'icon' => 'voyager-book',
                'model_name' => 'App\Models\Identification',
                'policy_name' => null,
                'controller' => 'App\Http\Controllers\ChildController',
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('accounts', DataType::firstOrCreate(
            ['name' => 'accounts'],
            [
                'name' => 'accounts',
                'slug' => 'accounts',
                'display_name_singular' => ucfirst('Account'),
                'display_name_plural' => Str::plural('Account'),
                'icon' => 'voyager-group',
                'model_name' => 'App\Models\Account',
                'policy_name' => null,
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => 'number',
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => 'unique',
                ],
            ]
        ));
        $this->process('products', DataType::firstOrCreate(
            ['name' => 'products'],
            [
                'name' => 'products',
                'slug' => 'products',
                'display_name_singular' => ucfirst('Product'),
                'display_name_plural' => Str::plural('Product'),
                'icon' => 'voyager-puzzle',
                'model_name' => 'App\Models\Product',
                'policy_name' => null,
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => 'id',
                    'order_display_column' => 'name',
                    'order_direction' => 'asc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('slider_items', DataType::firstOrCreate(
            ['name' => 'slider_items'],
            [
                'name' => 'slider_items',
                'slug' => 'slider-items',
                'display_name_singular' => ucfirst('Slider Item'),
                'display_name_plural' => Str::plural('Slider Item'),
                'icon' => null,
                'model_name' => 'App\Models\SliderItems',
                'policy_name' => null,
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('metals', DataType::firstOrCreate(
            ['name' => 'metals'],
            [
                'name' => 'metals',
                'slug' => 'metals',
                'display_name_singular' => ucfirst('Metal'),
                'display_name_plural' => Str::plural('Metal'),
                'icon' => null,
                'model_name' => 'App\Models\Metal',
                'policy_name' => null,
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('metal_deposits', DataType::firstOrCreate(
            ['name' => 'metal_deposits'],
            [
                'name' => 'metal_deposits',
                'slug' => 'metal-deposits',
                'display_name_singular' => ucfirst('Metal Deposit'),
                'display_name_plural' => Str::plural('Metal Deposit'),
                'icon' => null,
                'model_name' => 'App\Models\MetalDeposit',
                'policy_name' => null,
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('metal_orders', DataType::firstOrCreate(
            ['name' => 'metal_orders'],
            [
                'name' => 'metal_orders',
                'slug' => 'metal-orders',
                'display_name_singular' => ucfirst('Metal Order'),
                'display_name_plural' => Str::plural('Metal Order'),
                'icon' => null,
                'model_name' => 'App\Models\MetalOrder',
                'policy_name' => null,
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => 'id',
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('metal_withdrawals', DataType::firstOrCreate(
            ['name' => 'metal_withdrawals'],
            [
                'name' => 'metal_withdrawals',
                'slug' => 'metal-withdrawals',
                'display_name_singular' => ucfirst('Metal Withdrawal'),
                'display_name_plural' => Str::plural('Metal Withdrawal'),
                'icon' => null,
                'model_name' => 'App\Models\MetalWithdrawal',
                'policy_name' => null,
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('news_bar', DataType::firstOrCreate(
            ['name' => 'news_bar'],
            [
                'name' => 'news_bar',
                'slug' => 'news-bar',
                'display_name_singular' => ucfirst('News Bar'),
                'display_name_plural' => Str::plural('News Bar'),
                'icon' => null,
                'model_name' => 'App\Models\NewsBar',
                'policy_name' => null,
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('product_orders', DataType::firstOrCreate(
            ['name' => 'product_orders'],
            [
                'name' => 'product_orders',
                'slug' => 'product-orders',
                'display_name_singular' => ucfirst('Product Order'),
                'display_name_plural' => Str::plural('Product Order'),
                'icon' => null,
                'model_name' => 'App\Models\ProductOrder',
                'policy_name' => null,
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => 'id',
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('order_products', DataType::firstOrCreate(
            ['name' => 'order_products'],
            [
                'name' => 'order_products',
                'slug' => 'order-products',
                'display_name_singular' => ucfirst('Order Product'),
                'display_name_plural' => Str::plural('Order Product'),
                'icon' => null,
                'model_name' => 'App\Models\OrderProduct',
                'policy_name' => null,
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $cash_deposits = $this->process('cash_deposits', DataType::firstOrCreate(
            ['name' => 'cash_deposits'],
            [
                'name' => 'cash_deposits',
                'slug' => 'cash-deposits',
                'display_name_singular' => ucfirst('Cash Deposit'),
                'display_name_plural' => Str::plural('Cash Deposit'),
                'icon' => null,
                'model_name' => 'App\Models\CashDeposit',
                'policy_name' => null,
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->setDataRowBread($cash_deposits, 'deleted_at', 'br');
        $this->process('cash_withdrawals', DataType::firstOrCreate(
            ['name' => 'cash_withdrawals'],
            [
                'name' => 'cash_withdrawals',
                'slug' => 'cash-withdrawals',
                'display_name_singular' => ucfirst('Cash Withdrawal'),
                'display_name_plural' => Str::plural('Cash Withdrawal'),
                'icon' => null,
                'model_name' => 'App\Models\CashWithdrawal',
                'policy_name' => null,
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('shipping_options', DataType::firstOrCreate(
            ['name' => 'shipping_options'],
            [
                'name' => 'shipping_options',
                'slug' => 'shipping-options',
                'display_name_singular' => ucfirst('Shipping Option'),
                'display_name_plural' => Str::plural('Shipping Option'),
                'icon' => null,
                'model_name' => 'App\Models\ShippingOption',
                'policy_name' => null,
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('statuses', DataType::firstOrCreate(
            ['name' => 'statuses'],
            [
                'name' => 'statuses',
                'slug' => 'statuses',
                'display_name_singular' => ucfirst('Status'),
                'display_name_plural' => Str::plural('Status'),
                'icon' => 'voyager-check',
                'model_name' => 'App\Models\Status',
                'policy_name' => null,
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('currencies', DataType::firstOrCreate(
            ['name' => 'currencies'],
            [
                'name' => 'currencies',
                'slug' => 'currencies',
                'display_name_singular' => ucfirst('Currency'),
                'display_name_plural' => Str::plural('Currency'),
                'icon' => null,
                'model_name' => 'App\Models\Currency',
                'policy_name' => null,
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('payment_methods', DataType::firstOrCreate(
            ['name' => 'payment_methods'],
            [
                'name' => 'payment_methods',
                'slug' => 'payment-methods',
                'display_name_singular' => ucfirst('Payment Method'),
                'display_name_plural' => Str::plural('Payment Method'),
                'icon' => 'voyager-dollar',
                'model_name' => 'App\Models\PaymentMethod',
                'policy_name' => null,
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('provinces', DataType::firstOrCreate(
            ['name' => 'provinces'],
            [
                'name' => 'provinces',
                'slug' => 'provinces',
                'display_name_singular' => ucfirst('Province'),
                'display_name_plural' => Str::plural('Province'),
                'icon' => null,
                'model_name' => 'App\Models\Province',
                'policy_name' => null,
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => 'id',
                    'order_display_column' => 'name',
                    'order_direction' => 'asc',
                    'default_search_key' => 'name',
                    'scope' => null,
                ],
            ]
        ));
        $this->process('ic_fedex', DataType::firstOrCreate(
            ['name' => 'ic_fedex'],
            [
                'name' => 'ic_fedex',
                'slug' => 'ic-fedex',
                'display_name_singular' => ucfirst('Fedex'),
                'display_name_plural' => Str::plural('Fedex'),
                'icon' => null,
                'model_name' => 'App\Models\Fedex',
                'policy_name' => null,
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('home_news', DataType::firstOrCreate(
            ['name' => 'home_news'],
            [
                'name' => 'home_news',
                'slug' => 'home-news',
                'display_name_singular' => ucfirst('Home News'),
                'display_name_plural' => Str::plural('Home News'),
                'icon' => null,
                'model_name' => 'App\Models\HomeNew',
                'policy_name' => null,
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('alerts', DataType::firstOrCreate(
            ['name' => 'alerts'],
            [
                'name' => 'alerts',
                'slug' => 'alerts',
                'display_name_singular' => ucfirst('Alert'),
                'display_name_plural' => Str::plural('Alert'),
                'icon' => 'voyager-news',
                'model_name' => 'App\Models\Alert',
                'policy_name' => null,
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('additional_percents', DataType::firstOrCreate(
            ['name' => 'additional_percents'],
            [
                'name' => 'additional_percents',
                'slug' => 'additional-percents',
                'display_name_singular' => ucfirst('Additional Percent'),
                'display_name_plural' => Str::plural('Additional Percent'),
                'icon' => 'voyager-params',
                'model_name' => 'App\Models\AdditionalPercent',
                'policy_name' => null,
                'controller' => null,
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('blogs', DataType::updateOrCreate(
            ['name' => 'blogs'],
            [
                'name' => 'blogs',
                'slug' => 'blogs',
                'display_name_singular' => ucfirst('Blog'),
                'display_name_plural' => Str::plural('Blog'),
                'icon' => null,
                'model_name' => 'App\Models\Blog',
                'policy_name' => null,
                'controller' => 'App\Http\Controllers\AdminBlogsController',
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('news', DataType::updateOrCreate(
            ['name' => 'news'],
            [
                'name' => 'news',
                'slug' => 'news',
                'display_name_singular' => ucfirst('News'),
                'display_name_plural' => Str::plural('News'),
                'icon' => null,
                'model_name' => 'App\Models\HomeNew',
                'policy_name' => null,
                'controller' => 'App\Http\Controllers\AdminNewsController',
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('subscription_lists', DataType::updateOrCreate(
            ['name' => 'subscription_lists'],
            [
                'name' => 'subscription_lists',
                'slug' => 'subscription_lists',
                'display_name_singular' => ucfirst('Subscription List'),
                'display_name_plural' => Str::plural('Subscription List'),
                'icon' => null,
                'model_name' => 'App\Models\SubscriptionList',
                'policy_name' => null,
                'controller' => 'App\Http\Controllers\SubscriptionListController',
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('subscription_list_users', DataType::updateOrCreate(
            ['name' => 'subscription_list_users'],
            [
                'name' => 'subscription_list_users',
                'slug' => 'subscription_list_users',
                'display_name_singular' => ucfirst('Subscription List User'),
                'display_name_plural' => Str::plural('Subscription List User'),
                'icon' => null,
                'model_name' => 'App\Models\SubscriptionListUser',
                'policy_name' => null,
                'controller' => 'App\Http\Controllers\SubscriptionListController',
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('scheduler', DataType::updateOrCreate(
            ['name' => 'scheduler'],
            [
                'name' => 'scheduler',
                'slug' => 'scheduler',
                'display_name_singular' => ucfirst('Scheduler'),
                'display_name_plural' => Str::plural('Scheduler'),
                'icon' => null,
                'model_name' => 'App\Models\Scheduler',
                'policy_name' => null,
                'controller' => 'App\Http\Controllers\SchedulerController',
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('scheduler_users', DataType::updateOrCreate(
            ['name' => 'scheduler_users'],
            [
                'name' => 'scheduler_users',
                'slug' => 'scheduler_users',
                'display_name_singular' => ucfirst('Scheduler User'),
                'display_name_plural' => Str::plural('Scheduler User'),
                'icon' => null,
                'model_name' => 'App\Models\SchedulerUser',
                'policy_name' => null,
                'controller' => 'App\Http\Controllers\SchedulerController',
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('scheduler_selected_users', DataType::updateOrCreate(
            ['name' => 'scheduler_selected_users'],
            [
                'name' => 'scheduler_selected_users',
                'slug' => 'scheduler_selected_users',
                'display_name_singular' => ucfirst('Scheduler Selected User'),
                'display_name_plural' => Str::plural('Scheduler Selected User'),
                'icon' => null,
                'model_name' => 'App\Models\SchedulerSelectedUser',
                'policy_name' => null,
                'controller' => 'App\Http\Controllers\SchedulerController',
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('mail_templates', DataType::updateOrCreate(
            ['name' => 'mail_templates'],
            [
                'name' => 'mail_templates',
                'slug' => 'mail_templates',
                'display_name_singular' => ucfirst('Mail Template'),
                'display_name_plural' => Str::plural('Mail Template'),
                'icon' => null,
                'model_name' => 'App\Models\MailTemplate',
                'policy_name' => null,
                'controller' => 'App\Http\Controllers\MailTemplateController',
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('mail_template_properties', DataType::updateOrCreate(
            ['name' => 'mail_template_properties'],
            [
                'name' => 'mail_template_properties',
                'slug' => 'mail_template_properties',
                'display_name_singular' => ucfirst('Mail Template Property'),
                'display_name_plural' => Str::plural('Mail Template Property'),
                'icon' => null,
                'model_name' => 'App\Models\MailTemplateProperty',
                'policy_name' => null,
                'controller' => 'App\Http\Controllers\MailTemplateController',
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
        $this->process('seos', DataType::updateOrCreate(
            ['name' => 'seos'],
            [
                'name' => 'seos',
                'slug' => 'seos',
                'display_name_singular' => ucfirst('SEO'),
                'display_name_plural' => Str::plural('SEO'),
                'icon' => null,
                'model_name' => 'App\Models\SEO',
                'policy_name' => null,
                'controller' => 'App\Http\Controllers\SEOController',
                'description' => null,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => [
                    'order_column' => null,
                    'order_display_column' => null,
                    'order_direction' => 'desc',
                    'default_search_key' => null,
                    'scope' => null,
                ],
            ]
        ));
    }

    public function process($table, DataType $dataType) {
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => $table,
                'display_name_singular' => ucfirst($table),
                'display_name_plural'   => Str::plural(ucfirst($table)),
                'icon'                  => '',
                'model_name'            => 'App\\Models\\' . ucfirst($table),
                'controller'            => '',
                'generate_permissions'  => 1,
                'description'           => ''
            ])->save();

            // Log::info('DataType created for ' . $table);
        } else {
            // Log::info('DataType already exists for ' . $table);
        }

        $dataRowOrder = 0;
        try {
            $fieldsInfo = DB::select("SHOW COLUMNS FROM {$table}");
        } catch (\Exception $e) {
            Log::error('Table ' . $table . ' does not exist');
            return;
        }

        foreach ($fieldsInfo as $field) {
            $dataRow = DataRow::firstOrNew([
                'data_type_id' => $dataType->id,
                'field'        => $field->Field
            ]);

            if (!$dataRow->exists) {
                if ($field->Field === 'id') {
                    $dataRow->fill([
                        'type'         => 'number',
                        'display_name' => ucfirst($field->Field),
                        'required'     => 1,
                        'browse'       => 0,
                        'read'         => 0,
                        'edit'         => 0,
                        'add'          => 0,
                        'delete'       => 0,
                        'details'      => '{}',
                        'order'        => $dataRowOrder++
                    ])->save();
                    continue;
                }

                if ($field->Default === null) {
                    $required = 1;
                } else {
                    $required = 0;
                }

                $type = null;
                $numbers = [
                    'int',
                    'smallint',
                    'mediumint',
                    'bigint',
                    'decimal',
                    'float',
                    'double',
                    'real',
                    'bit',
                ];
                if (preg_match('/' . implode('|', $numbers) . '/', $field->Type)) {
                    $type = 'number';
                }

                if ($field->Type === 'tinyint(1)') {
                    $type = 'boolean';
                }

                $date = [
                    'date',
                    'datetime',
                    'timestamp',
                    'time',
                    'year',
                ];
                if (preg_match('/' . implode('|', $date) . '/', $field->Type)) {
                    $type = 'timestamp';
                }

                $browse = 1;
                $read = 1;
                $edit = 1;
                $add = 1;
                $delete = 1;

                if ($field->Field === 'password' || $field->Field === 'remember_token') {
                    $type = 'password';
                    $browse = 0;
                    $read = 0;
                }

                if ($type === null) {
                    $type = 'text';
                }

                // Log::info('Field ' . $field->Field . ' -  with type ' . $type . ' - required ' . $required . ' - ft ' . $field->Type);
                $dataRow->fill([
                    'type'         => $type,
                    'display_name' => ucfirst($field->Field),
                    'required'     => $required,
                    'browse'       => $browse,
                    'read'         => $read,
                    'edit'         => $edit,
                    'add'          => $add,
                    'delete'       => $delete,
                    'details'      => '{}',
                    'order'        => $dataRowOrder++
                ])->save();
            }
        }

        Permission::generateFor($table);
        return $dataType;
    }

    protected function dataRow(DataType $dataType, $field) {
        return DataRow::firstOrNew([
            'data_type_id' => $dataType->id,
            'field'        => $field,
        ]);
    }

    protected function setDataRowBread(DataType $dataType, $dataRowField, $bread = 'bread') {
        $dataRow = $this->dataRow($dataType, $dataRowField);
        if (!$dataRow->exists) {
            return;
        }

        $browse = strpos($bread, 'b') !== false;
        $read = strpos($bread, 'r') !== false;
        $edit = strpos($bread, 'e') !== false;
        $add = strpos($bread, 'a') !== false;
        $delete = strpos($bread, 'd') !== false;

        $dataRow->fill([
            'browse' => $browse,
            'read' => $read,
            'edit' => $edit,
            'add' => $add,
            'delete' => $delete,
        ])->save();
    }
}
