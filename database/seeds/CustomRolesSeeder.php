<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Log;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;

class CustomRolesSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $adminRole = Role::create([
            'name' => 'Admin',
            'display_name' => 'Admin',
        ]);

        $userRole  = Role::create([
            'name' => 'User',
            'display_name' => 'Normal User',
        ]);

        // check user role id is 2 or force id 2
        if ($userRole->id !== 2) {
            $userRole->id = 2;
            $userRole->save();

            // update auto increment id
            DB::statement('ALTER TABLE roles AUTO_INCREMENT = 3');
        }


        $orderRole  = Role::create([
            'name' => 'Order Manager',
            'display_name' => 'Order Manager',
        ]);

        $contentRole  = Role::create([
            'name' => 'Content Manager',
            'display_name' => 'Content Manager',
        ]);

        $mailRole  = Role::create([
            'name' => 'Mail Manager',
            'display_name' => 'Mail Manager',
        ]);

        $seoRole  = Role::create([
            'name' => 'SEO Manager',
            'display_name' => 'SEO Manager',
        ]);

        DB::table('permission_role')->truncate();

        // admin
        $this->setAdminPermission($adminRole);

        $this->setPermissions($adminRole, 'menus', 'read');
        $this->setPermissions($adminRole, 'roles', 'read');
        $this->setPermissions($adminRole, 'users', 'read');
        $this->setPermissions($adminRole, 'settings', 'read');
        $this->setPermissions($adminRole, 'categories', 'read');
        $this->setPermissions($adminRole, 'posts', 'read');
        $this->setPermissions($adminRole, 'pages', 'read');
        $this->setPermissions($adminRole, 'identifications', 'read');
        $this->setPermissions($adminRole, 'accounts', 'read');
        $this->setPermissions($adminRole, 'products', 'read');
        $this->setPermissions($adminRole, 'slider_items', 'read');
        $this->setPermissions($adminRole, 'metals', 'read');
        $this->setPermissions($adminRole, 'metal_deposits', 'read');
        $this->setPermissions($adminRole, 'metal_orders', 'read');
        $this->setPermissions($adminRole, 'metal_withdrawals', 'read');
        $this->setPermissions($adminRole, 'news_bar', 'read');
        $this->setPermissions($adminRole, 'product_orders', 'read');
        $this->setPermissions($adminRole, 'shippings', 'read');
        $this->setPermissions($adminRole, 'payments', 'read');
        $this->setPermissions($adminRole, 'order_products', 'read');
        $this->setPermissions($adminRole, 'cash_deposits', 'read');
        $this->setPermissions($adminRole, 'cash_withdrawals', 'read');
        $this->setPermissions($adminRole, 'shipping_options', 'read');
        $this->setPermissions($adminRole, 'statuses', 'read');
        $this->setPermissions($adminRole, 'currencies', 'read');
        $this->setPermissions($adminRole, 'payment_methods', 'read');
        $this->setPermissions($adminRole, 'ic_fedex', 'read');
        $this->setPermissions($adminRole, 'home_news', 'read');
        $this->setPermissions($adminRole, 'alerts', 'read');
        $this->setPermissions($adminRole, 'additional_percents', 'read');
        $this->setPermissions($adminRole, 'pending-orders', 'read');
        $this->setPermissions($adminRole, 'users-orders-compilation', 'read');
        $this->setPermissions($adminRole, 'users-balances', 'read');
        $this->setPermissions($adminRole, 'users-balances-compilation', 'read');
        $this->setPermissions($adminRole, 'blogs', 'read');
        $this->setPermissions($adminRole, 'news', 'read');
        $this->setPermissions($adminRole, 'subscription_lists', 'read');
        $this->setPermissions($adminRole, 'subscription_list_users', 'read');
        $this->setPermissions($adminRole, 'scheduler', 'read');
        $this->setPermissions($adminRole, 'scheduler_users', 'read');
        $this->setPermissions($adminRole, 'scheduler_selected_users', 'read');
        $this->setPermissions($adminRole, 'mail_templates', 'read');
        $this->setPermissions($adminRole, 'mail_template_properties', 'read');
        $this->setPermissions($adminRole, 'seos', 'read');
        $this->setPermissions($adminRole, 'seos-products', 'read');
        $this->setPermissions($adminRole, 'seos-blogs', 'read');
        $this->setPermissions($adminRole, 'seos-news', 'read');

        // order
        $this->setBrowseAdminPermission($orderRole);
        $this->setPermissions($orderRole, 'order_products', 'r');
        $this->setPermissions($orderRole, 'product_orders', 'r');
        $this->setPermissions($orderRole, 'cash_deposits', 'r');
        $this->setPermissions($orderRole, 'cash_withdrawals', 'r');
        $this->setPermissions($orderRole, 'shipping_options', 'r');
        $this->setPermissions($orderRole, 'statuses', 'r');
        $this->setPermissions($orderRole, 'shippings', 'r');
        $this->setPermissions($orderRole, 'payments', 'r');

        // content
        $this->setBrowseAdminPermission($contentRole);
        $this->setPermissions($contentRole, 'blogs', 'rea');
        $this->setPermissions($contentRole, 'news', 'rea');
        $this->setPermissions($contentRole, 'home_news', 'rea');

        // mail
        $this->setBrowseAdminPermission($mailRole);
        $this->setPermissions($mailRole, 'subscription_lists', 'rea');
        $this->setPermissions($mailRole, 'subscription_list_users', 'rea');
        $this->setPermissions($mailRole, 'scheduler', 'rea');
        $this->setPermissions($mailRole, 'scheduler_users', 'rea');
        $this->setPermissions($mailRole, 'scheduler_selected_users', 'rea');
        $this->setPermissions($mailRole, 'mail_templates', 'rea');
        $this->setPermissions($mailRole, 'mail_template_properties', 'rea');

        // seo
        $this->setBrowseAdminPermission($seoRole);
        $this->setPermissions($seoRole, 'seos', 'rea');
        $this->setPermissions($seoRole, 'seos-products', 'rea');
        $this->setPermissions($seoRole, 'seos-blogs', 'rea');
        $this->setPermissions($seoRole, 'seos-news', 'rea');
    }

    private function setAdminPermission(Role $role) {
        $permissions = Permission::where(function ($query) {
            $query->where('key', 'browse_admin');
            $query->orWhere('key', 'browse_bread');
            $query->orWhere('key', 'browse_database');
            $query->orWhere('key', 'browse_media');
            $query->orWhere('key', 'browse_compass');
        })->get();
        foreach ($permissions as $permission) {
            $role->permissions()->attach($permission);
        }
    }
    private function setBrowseAdminPermission(Role $role) {
        $permissions = Permission::where(function ($query) {
            $query->where('key', 'browse_admin');
        })->get();
        foreach ($permissions as $permission) {
            $role->permissions()->attach($permission);
        }
    }

    private function setPermissions(Role $role, $key, $type = 'read') {
        $permissions = $this->getPermissions($key, $type);
        foreach ($permissions as $permission) {
            $role->permissions()->attach($permission);
        }
    }

    private function getPermissions($key, $type = 'read') {
        $permissions = Permission::where(function ($query) use ($key, $type) {
            $atLeastOne = false;

            if (strpos($type, 'r') !== false) {
                $query->orWhere('key', 'like', 'read_' . $key);
                $atLeastOne = true;
            }

            if (strpos($type, 'e') !== false) {
                $query->orWhere('key', 'like', 'edit_' . $key);
                $atLeastOne = true;
            }

            if (strpos($type, 'a') !== false) {
                $query->orWhere('key', 'like', 'add_' . $key);
                $atLeastOne = true;
            }

            if (strpos($type, 'd') !== false) {
                $query->orWhere('key', 'like', 'delete_' . $key);
                $atLeastOne = true;
            }

            if ($atLeastOne) {
                $query->orWhere('key', 'like', 'browse_' . $key);
            }
        })->get();
        return $permissions;
    }
}
