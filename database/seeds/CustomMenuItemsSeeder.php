<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;

class CustomMenuItemsSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // restart 
        MenuItem::truncate();

        // delete all 
        $allMenus = Menu::all();
        if ($allMenus->count() > 0) {
            foreach ($allMenus as $menu) {
                $menu->delete();
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Menu::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // create new
        $menu = Menu::create([
            'name' => 'admin',
        ]);


        // create menu items
        $this->admin($menu);
        $this->tools($menu);
        $this->orders($menu);
        $this->transactions($menu);
        $this->compilations($menu);
        $this->shop($menu);
        $this->utilities($menu);
        $this->news($menu);
        $this->blogs($menu);
        $this->mails($menu);
        $this->seo($menu);
    }

    private function admin($menu) {
        $users = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Users',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-people',
            'color' => '#000000',
            'parent_id' => null,
            'order' => 1,
            'route' => 'voyager.users.index',
        ]);

        $roles = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Roles',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-lock',
            'color' => '#000000',
            'parent_id' => null,
            'order' => 1,
            'route' => 'voyager.roles.index',
        ]);


        $settings = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Settings',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-settings',
            'color' => '#000000',
            'parent_id' => null,
            'order' => 1,
            'route' => 'voyager.settings.index',
        ]);
        $dashboard = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Dashboard',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-dashboard',
            'color' => '#000000',
            'parent_id' => null,
            'order' => 1,
            'route' => 'voyager.dashboard',
        ]);
        $identifications = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Identifications',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-book',
            'color' => '#000000',
            'parent_id' => null,
            'order' => 1,
            'route' => 'voyager.identifications.index',
        ]);
        $accounts = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Accounts',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-folder',
            'color' => '#000000',
            'parent_id' => null,
            'order' => 1,
            'route' => 'voyager.accounts.index',
        ]);

        // $accounts = MenuItem::create([
        //     'menu_id' => $menu->id,
        //     'title' => 'Accounts',
        //     'url' => null,
        //     'target' => '_self',
        //     'icon_class' => 'voyager-wallet',
        //     'color' => '#000000',
        //     'parent_id' => null,
        //     'order' => 1,
        //     'route' => 'voyager.accounts.index',
        // ]);
        // $fedex = MenuItem::create([
        //     'menu_id' => $menu->id,
        //     'title' => 'Fedex',
        //     'url' => null,
        //     'target' => '_self',
        //     'icon_class' => '',
        //     'color' => '#000000',
        //     'parent_id' => null,
        //     'order' => 1,
        //     'route' => 'voyager.ic-fedex.index',
        // ]);

        // $homeAlerts = MenuItem::create([
        //     'menu_id' => $menu->id,
        //     'title' => 'Home Alerts',
        //     'url' => null,
        //     'target' => '_self',
        //     'icon_class' => 'voyager-news',
        //     'color' => '#000000',
        //     'parent_id' => null,
        //     'order' => 1,
        //     'route' => 'voyager.alerts.index',
        // ]);
        // $cmoCompilation = MenuItem::create([
        //     'menu_id' => $menu->id,
        //     'title' => 'CMO Compilation',
        //     'url' => null,
        //     'target' => '_self',
        //     'icon_class' => 'voyager-shop',
        //     'color' => '#000000',
        //     'parent_id' => null,
        //     'order' => 1,
        //     'route' => 'admin.daily-activity',
        // ]);
    }

    private function tools($menu) {
        $tools = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Tools',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-tools',
            'color' => '#000000',
            'parent_id' => null,
            'order' => 1,
            'route' => null,
        ]);
        $menuBuilder = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Menu Builder',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-list',
            'color' => '#000000',
            'parent_id' => $tools->id,
            'order' => 1,
            'route' => 'voyager.menus.index',
        ]);
        $database = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Database',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-data',
            'color' => '#000000',
            'parent_id' => $tools->id,
            'order' => 1,
            'route' => 'voyager.database.index',
        ]);
        $compass = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Compass',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-compass',
            'color' => '#000000',
            'parent_id' => $tools->id,
            'order' => 1,
            'route' => 'voyager.compass.index',
        ]);
        $bread = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'BREAD',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-bread',
            'color' => '#000000',
            'parent_id' => $tools->id,
            'order' => 1,
            'route' => 'voyager.bread.index',
        ]);
        // $hooks = MenuItem::create([
        //     'menu_id' => $menu->id,
        //     'title' => 'Hooks',
        //     'url' => null,
        //     'target' => '_self',
        //     'icon_class' => 'voyager-hook',
        //     'color' => '#000000',
        //     'parent_id' => $tools->id,
        //     'order' => 1,
        //     'route' => 'voyager.hooks',
        // ]);
    }

    private function  orders($menu) {
        $orders = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Orders',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-edit',
            'color' => '#000000',
            'parent_id' => null,
            'order' => 1,
            'route' => null,
        ]);
        $metalOrders = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Metal Orders',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-basket',
            'color' => '#000000',
            'parent_id' => $orders->id,
            'order' => 1,
            'route' => 'voyager.metal-orders.index',
        ]);
        $productOrders = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Product Orders',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-basket',
            'color' => '#000000',
            'parent_id' => $orders->id,
            'order' => 1,
            'route' => 'voyager.product-orders.index',
        ]);
    }

    private function transactions($menu) {
        $transactions = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Transactions',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-wallet',
            'color' => '#000000',
            'parent_id' => null,
            'order' => 1,
            'route' => null,
        ]);
        $metalDeposits = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Metal Deposits',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-star-half',
            'color' => '#000000',
            'parent_id' => $transactions->id,
            'order' => 1,
            'route' => 'voyager.metal-deposits.index',
        ]);
        $metalWithdrawals = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Metal Withdrawals',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-star',
            'color' => '#000000',
            'parent_id' => $transactions->id,
            'order' => 1,
            'route' => 'voyager.metal-withdrawals.index',
        ]);
        $cashDeposits = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Cash Deposits',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-credit-card',
            'color' => '#000000',
            'parent_id' => $transactions->id,
            'order' => 1,
            'route' => 'voyager.cash-deposits.index',
        ]);
        $cashWithdrawals = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Cash Withdrawals',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-external',
            'color' => '#000000',
            'parent_id' => $transactions->id,
            'order' => 1,
            'route' => 'voyager.cash-withdrawals.index',
        ]);
    }

    private function compilations($menu) {
        $compilations = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Compilations',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-bar-chart',
            'color' => '#000000',
            'parent_id' => null,
            'order' => 1,
            'route' => null,
        ]);
        $allOrders = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'All Orders',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-bread',
            'color' => '#000000',
            'parent_id' => $compilations->id,
            'order' => 1,
            'route' => 'voyager.pending-orders.index',
        ]);
        $usersOrdersCompilation = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Users orders compilation',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-bread',
            'color' => '#000000',
            'parent_id' => $compilations->id,
            'order' => 1,
            'route' => 'voyager.users-orders-compilation.index',
        ]);
        $usersTransactionsCompilation = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Users transactions compilation',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-bread',
            'color' => '#000000',
            'parent_id' => $compilations->id,
            'order' => 1,
            'route' => 'voyager.users-transactions-compilation.index',
        ]);
        $usersBalances = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Users balances',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-bread',
            'color' => '#000000',
            'parent_id' => $compilations->id,
            'order' => 1,
            'route' => 'voyager.users-balances.index',
        ]);
        $userBalanceCompilation = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'User balance compilation',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-bread',
            'color' => '#000000',
            'parent_id' => $compilations->id,
            'order' => 1,
            'route' => 'voyager.users-balances-compilation.index',
        ]);
    }

    private function shop($menu) {
        $shop = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Shop',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-shop',
            'color' => '#000000',
            'parent_id' => null,
            'order' => 1,
            'route' => null,
        ]);
        $pendingShippings = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Pending Shippings',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-truck',
            'color' => '#000000',
            'parent_id' => $shop->id,
            'order' => 1,
            'route' => 'voyager.shippings.index',
        ]);
        $pendingPayments = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Pending Payments',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-dollar',
            'color' => '#000000',
            'parent_id' => $shop->id,
            'order' => 1,
            'route' => 'voyager.pending.index',
        ]);
    }

    private function utilities($menu) {
        $utilities = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Utilities',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-params',
            'color' => '#000000',
            'parent_id' => null,
            'order' => 1,
            'route' => null,
        ]);
        $media = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Media',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-images',
            'color' => '#000000',
            'parent_id' => $utilities->id,
            'order' => 1,
            'route' => 'voyager.media.index',
        ]);
        $products = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Products',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-puzzle',
            'color' => '#000000',
            'parent_id' => $utilities->id,
            'order' => 1,
            'route' => 'voyager.products.index',
        ]);
        $sliderItems = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Slider Items',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-photos',
            'color' => '#000000',
            'parent_id' => $utilities->id,
            'order' => 1,
            'route' => 'voyager.slider-items.index',
        ]);
        $metals = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Metals',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-diamond',
            'color' => '#000000',
            'parent_id' => $utilities->id,
            'order' => 1,
            'route' => 'voyager.metals.index',
        ]);
        $orderProducts = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Order Products',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-gift',
            'color' => '#000000',
            'parent_id' => $utilities->id,
            'order' => 1,
            'route' => 'voyager.order-products.index',
        ]);
        $shippingOptions = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Shipping Options',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-ship',
            'color' => '#000000',
            'parent_id' => $utilities->id,
            'order' => 1,
            'route' => 'voyager.shipping-options.index',
        ]);
        $statuses = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Statuses',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-check',
            'color' => '#000000',
            'parent_id' => $utilities->id,
            'order' => 1,
            'route' => 'voyager.statuses.index',
        ]);
        $currencies = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Currencies',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-treasure-open',
            'color' => '#000000',
            'parent_id' => $utilities->id,
            'order' => 1,
            'route' => 'voyager.currencies.index',
        ]);
        $paymentMethods = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Payment Methods',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-dollar',
            'color' => '#000000',
            'parent_id' => $utilities->id,
            'order' => 1,
            'route' => 'voyager.payment-methods.index',
        ]);
        $additionalPercents = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Additional Percents',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-params',
            'color' => '#000000',
            'parent_id' => $utilities->id,
            'order' => 1,
            'route' => 'voyager.additional-percents.index',
        ]);
    }

    private function news($menu) {
        $news = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'News',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-news',
            'color' => '#000000',
            'parent_id' => null,
            'order' => 1,
            'route' => 'voyager.news.index',
        ]);
    }

    private function blogs($menu) {
        $blogs = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Blogs',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-news',
            'color' => '#000000',
            'parent_id' => null,
            'order' => 1,
            'route' => 'voyager.blogs.index',
        ]);
    }

    private function mails($menu) {
        $mails = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Mails',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-mail',
            'color' => '#000000',
            'parent_id' => null,
            'order' => 1,
            'route' => null,
        ]);
        $templates = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Templates',
            'url' => null,
            'target' => '_self',
            'icon_class' => '',
            'color' => '#000000',
            'parent_id' => $mails->id,
            'order' => 1,
            'route' => 'voyager.mail_templates.index',
        ]);
        $scheduler = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Scheduler',
            'url' => null,
            'target' => '_self',
            'icon_class' => '',
            'color' => '#000000',
            'parent_id' => $mails->id,
            'order' => 1,
            'route' => 'voyager.scheduler.index',
        ]);
        $list = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'List',
            'url' => null,
            'target' => '_self',
            'icon_class' => '',
            'color' => '#000000',
            'parent_id' => $mails->id,
            'order' => 1,
            'route' => 'voyager.subscription_lists.index',
        ]);
    }

    private function seo($menu) {
        $seo = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'SEO',
            'url' => null,
            'target' => '_self',
            'icon_class' => 'voyager-list',
            'color' => '#000000',
            'parent_id' => null,
            'order' => 1,
            'route' => null,
        ]);
        $pages = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Pages',
            'url' => '/admin/seos-pages',
            'target' => '_self',
            'icon_class' => '',
            'color' => '#000000',
            'parent_id' => $seo->id,
            'order' => 1,
            'route' => null,
        ]);
        $products = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Products',
            'url' => null,
            'target' => '_self',
            'icon_class' => '',
            'color' => '#000000',
            'parent_id' => $seo->id,
            'order' => 1,
            'route' => 'voyager.seos-products.index',
        ]);
        $blogs = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'Blogs',
            'url' => null,
            'target' => '_self',
            'icon_class' => '',
            'color' => '#000000',
            'parent_id' => $seo->id,
            'order' => 1,
            'route' => 'voyager.seos-blogs.index',
        ]);
        $news = MenuItem::create([
            'menu_id' => $menu->id,
            'title' => 'News',
            'url' => null,
            'target' => '_self',
            'icon_class' => '',
            'color' => '#000000',
            'parent_id' => $seo->id,
            'order' => 1,
            'route' => 'voyager.seos-news.index',
        ]);
    }
}
