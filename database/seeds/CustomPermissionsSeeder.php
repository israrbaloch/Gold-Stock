<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Permission;

class CustomPermissionsSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        Permission::truncate();

        // admin
        Permission::create([
            'key' => 'browse_admin',
            'table_name' => null,
        ]);
        Permission::create([
            'key' => 'browse_bread',
            'table_name' => null,
        ]);
        Permission::create([
            'key' => 'browse_database',
            'table_name' => null,
        ]);
        Permission::create([
            'key' => 'browse_media',
            'table_name' => null,
        ]);
        Permission::create([
            'key' => 'browse_compass',
            'table_name' => null,
        ]);

        $this->createPermissions('menus', 'menus');
        $this->createPermissions('roles', 'roles');
        $this->createPermissions('users', 'users');
        $this->createPermissions('settings', 'settings');
        $this->createPermissions('categories', 'categories');
        $this->createPermissions('posts', 'posts');
        $this->createPermissions('pages', 'pages');
        $this->createPermissions('hooks');
        $this->createPermissions('identifications', 'identifications');
        $this->createPermissions('accounts', 'accounts');
        $this->createPermissions('products', 'products');
        $this->createPermissions('slider_items', 'slider_items');
        $this->createPermissions('metals', 'metals');
        $this->createPermissions('metal_deposits', 'metal_deposits');
        $this->createPermissions('metal_orders', 'metal_orders');
        $this->createPermissions('metal_withdrawals', 'metal_withdrawals');
        $this->createPermissions('news_bar', 'news_bar');
        $this->createPermissions('product_orders', 'product_orders');
        $this->createPermissions('shippings');
        $this->createPermissions('payments');
        $this->createPermissions('order_products', 'order_products');
        $this->createPermissions('cash_deposits', 'cash_deposits');
        $this->createPermissions('cash_withdrawals', 'cash_withdrawals');
        $this->createPermissions('shipping_options', 'shipping_options');
        $this->createPermissions('statuses', 'statuses');
        $this->createPermissions('currencies', 'currencies');
        $this->createPermissions('payment_methods', 'payment_methods');
        $this->createPermissions('ic_fedex', 'ic_fedex');
        $this->createPermissions('home_news', 'home_news');
        $this->createPermissions('alerts', 'alerts');
        $this->createPermissions('additional_percents', 'additional_percents');
        $this->createPermissions('pending-orders');
        $this->createPermissions('users-orders-compilation');
        $this->createPermissions('users-transactions-compilation');
        $this->createPermissions('users-balances');
        $this->createPermissions('users-balances-compilation');
        $this->createPermissions('blogs', 'blogs');
        $this->createPermissions('news', 'news');
        $this->createPermissions('subscription_lists', 'subscription_lists');
        $this->createPermissions('subscription_list_users', 'subscription_list_users');
        $this->createPermissions('scheduler', 'scheduler');
        $this->createPermissions('scheduler_users', 'scheduler_users');
        $this->createPermissions('scheduler_selected_users', 'scheduler_selected_users');
        $this->createPermissions('mail_templates', 'mail_templates');
        $this->createPermissions('mail_template_properties', 'mail_template_properties');
        $this->createPermissions('seos', 'seos');
        $this->createPermissions('seos-products');
        $this->createPermissions('seos-blogs');
        $this->createPermissions('seos-news');
    }

    private function createPermissions($key, $table_name = null) {
        Permission::create([
            'key' => 'browse_' . $key,
            'table_name' => $table_name,
        ]);
        Permission::create([
            'key' => 'read_' . $key,
            'table_name' => $table_name,
        ]);
        Permission::create([
            'key' => 'edit_' . $key,
            'table_name' => $table_name,
        ]);
        Permission::create([
            'key' => 'add_' . $key,
            'table_name' => $table_name,
        ]);
        Permission::create([
            'key' => 'delete_' . $key,
            'table_name' => $table_name,
        ]);
    }
}
