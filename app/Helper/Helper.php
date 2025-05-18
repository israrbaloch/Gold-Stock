<?php

namespace App\Helper;

use Cart;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Metal;
use App\Models\Account;
use App\Models\Product;
use App\Models\PromoCode;
use App\Models\MetalOrder;
use App\Models\CashDeposit;
use App\Models\DepositOrder;
use App\Models\MetalDeposit;
use App\Models\ProductOrder;
use App\Mail\OrderShippedMail;
use App\Models\CashWithdrawal;
use App\Models\ShippingOption;
use App\Mail\OrderFeedbackMail;
use App\Models\MetalWithdrawal;
use App\Mail\OrderCancelledMail;
use App\Mail\OrderCompletedMail;
use Illuminate\Support\Facades\DB;
use App\Mail\OrderStatusChangeMail;
use App\Models\DepositOrderPayment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPendingPaymentMail;

class Helper
{
    static function getDataOrders()
    {
        $morders = DB::table('metal_orders')
            ->select(DB::raw("sum(`paid`) as Total, `metal_id` as Metal"))
            ->groupBy('metal_id')
            ->get();
        //$morders = MetalOrder::all(z);
        $data = ['morders' => $morders];
        return $data;
    }

    static function getDataMetalDeposits()
    {
        $metalDeposits = DB::table('metal_deposits')
            ->select(DB::raw("sum(`oz`) as Total"), 'metals.name as Metal')
            ->join('metals', 'metals.id', '=', 'metal_deposits.metal_id')
            ->groupBy('metal_id')
            ->get();

        $data = [
            'metalDeposits' => $metalDeposits,
        ];
        return $data;
    }
    static function getDataMetalWithdraws()
    {
        $metalWithdraws = DB::table('metal_withdrawals')
            ->select(DB::raw("sum(`oz`) as Total"), 'metals.name as Metal')
            ->join('metals', 'metals.id', '=', 'metal_withdrawals.metal_id')
            ->where('status_id', '=', 2)
            ->groupBy('metal_id')
            ->get();

        $data = [
            'metalWithdraws' => $metalWithdraws,
        ];
        return $data;
    }

    static function getUserBalances($id)
    {
        $metalDeposits = DB::select(
            'select
            u.id as idUser,
            u.name as userName,
            m.id as idMetal,
            m.name as metalName,
            sum(md.oz) as total
            from metal_deposits md
            join metals m on m.id = md.metal_id
            join users u on u.id = md.user_id
            where u.id = ' . $id . ' and md.status_id = 2
            group by m.id'
        );
        $metalWithdraws = DB::select(
            'select
            u.id as idUser,
            u.name as userName,
            m.id as idMetal,
            m.name as metalName,
            sum(mw.oz) as total
            from metal_withdrawals mw
            join metals m on m.id = mw.metal_id
            join users u on u.id = mw.user_id
            where u.id = ' . $id . '
            group by m.id'
        );
        $metalOrders = DB::select(
            'select
            u.id as idUser,
            u.name as userName,
            m.id as idMetal,
            m.name as metalName,
            sum(mo.quantity_oz) as total
            from metal_orders mo
            join metals m on m.id = mo.metal_id
            join users u on u.id = mo.user_id
            where u.id = ' . $id . '
            group by m.id'
        );

        foreach ($metalDeposits as $md) {
            foreach ($metalWithdraws as $mw) {
                if ($md->idUser == $mw->idUser && $md->idMetal == $mw->idMetal) {
                    $md->total = $md->total - $mw->total;
                }
            }
        }

        $_cashDeposits = DB::select(
            'select
            u.id as idUser,
            u.name as name,
            sum(cd.value) as total,
            cd.currency_id as idCurrency,
            c.code as currency
            from cash_deposits cd
            join users u on u.id  = cd.user_id
            join currencies c on c.id = cd.currency_id
            where u.id = ' . $id . ' and cd.status_id = 2
            group by cd.currency_id'
        );
        $_cashWithdraws = DB::select(
            'select
            u.id as idUser,
            u.name as name,
            sum(cw.value) as total,
            cw.currency_id as idCurrency,
            c.code as currency
            from cash_withdrawals cw
            join users u on u.id  = cw.user_id
            join currencies c on c.id = cw.currency_id
            where u.id = ' . $id . '
            group by cw.currency_id'
        );

        foreach ($_cashDeposits as $key => $cashDeposit) {
            foreach ($_cashWithdraws as $cashWithdraw) {
                // When the user has a deposit and a withdrawal of the same currency
                if ($cashDeposit->idUser == $cashWithdraw->idUser && $cashDeposit->idCurrency == $cashWithdraw->idCurrency) {
                    $cashDeposit->total = $cashDeposit->total - $cashWithdraw->total;
                }
            }
            $cashDeposit->total = $cashDeposit->total > 0 ? $cashDeposit->total : 0;
        }

        $metals = $metalDeposits;
        $cash = $_cashDeposits;

        $data = [
            'metals' => $metals,
            'cash' => $cash
        ];
        return $data;
    }

    static function getUsers()
    {
        $users = DB::table('users')
            ->select('id', 'name')
            ->get();

        $data = [
            'usersData' => $users,
        ];
        return $data;
    }

    static function getDataOrderProducts($id)
    {
        $orderProducts = DB::select(
            'select
            po.id as po_id,
            u.name as name,
            so.name as shipping_option,
            s.name as shipping_status,
            po.created_at as created_at
            from product_orders po
            join users u on u.id = po.user_id
            join shipping_options so on so.id = po.shipping_option_id
            join statuses s on s.id = po.shipping_status_id
            where u.id = ' . $id . ''
        );
        foreach ($orderProducts as $op) {
            $op->products = DB::select(
                'select
                op.id as id,
                p.name as name,
                op.quantity as quantity,
                op.price as price
                from order_products op
                join products p on p.id = op.product_id
                where op.order_id = ' . $op->po_id . ''
            );
            if ($op->products == null)
                $op->products = null;
        }

        // dd($orderProducts);
        $data = [
            'data' => $orderProducts,
        ];
        return $data;
    }

    static function getDataOrderMetals($id)
    {
        $orderMetals = MetalOrder::where('user_id', $id)->get();
        //        $orderMetals = MetalOrder::select(
        //            'users.id as idUser',
        //            'users.name as name',
        //            'metals.name as metal',
        //            'metal_orders.quantity_oz as quantityOz',
        //            'metal_orders.price_per_oz as pricePerOz',
        //            'metal_orders.created_at as createdAt'
        //        )
        //            ->join('users', 'users.id', 'metal_orders.user_id')
        //            ->join('metals', 'metals.id', 'metal_orders.metal_id')
        //            ->where('users.id',  $id)
        //            ->get();
        $data = [
            'data' => $orderMetals,
        ];

        return $data;
    }
    //H3llH4mm3r XD

    static function getMetalDepositUserBalance($id, $metal)
    {
        $metalDeposit = DB::table('users')
            ->select('users.name as name', 'metal_deposits.oz as total', 'metals.name as metal')
            ->join('metal_deposits', 'metal_deposits.user_id', 'users.id')
            ->join('metals', 'metals.id', 'metal_deposits.metal_id')
            ->where('users.id', $id)
            ->where('metals.name', $metal)
            ->get();

        $metalDeposit = $metalDeposit->toArray();
        // dd($metalDeposit);
        $totaldepos = 0;
        foreach ($metalDeposit as $key) {
            $totaldepos = $totaldepos + $key->total;
        }
        // dd($totaldepos);
        $metalWithdraws = DB::table('users')
            ->select('users.name as name', 'metal_withdrawals.oz as total', 'metals.name as metal')
            ->join('metal_withdrawals', 'metal_withdrawals.user_id', 'users.id')
            ->join('metals', 'metals.id', 'metal_withdrawals.metal_id')
            ->where('users.id', $id)
            ->where('metals.name', $metal)
            ->get();

        $metalWithdraws = $metalWithdraws->toArray();
        $totalwith = 0;
        foreach ($metalWithdraws as $val) {
            $totalwith = $totalwith + $val->total;
        }
        $account = Account::where('user_id', $id)->orderBy('id', 'desc')->first();
        $metalid = DB::table('metals')->where('metals.name', $metal)->first();
        // dd($metalid);
        $metalid = $metalid->id;
        $account = $account->number;
        $total = $totaldepos - $totalwith > 0.00009 ? $totaldepos - $totalwith : 0;

        $data = [
            'total' => $total,
            'metal' => $metal,
            'metalid' => $metalid,
            'number' => $account,
        ];

        return $data;
    }

    static function getCashDepositUserBalance($id, $currency)
    {

        // Get user's cash deposits
        $cashDeposits = DB::table('users')
            ->select('users.name as name', 'cash_deposits.value as total', 'currencies.code as currency')
            ->join('cash_deposits', 'cash_deposits.user_id', 'users.id')
            ->join('currencies', 'currencies.id', 'cash_deposits.currency_id')
            ->where('users.id', $id)
            ->where('cash_deposits.status_id', 2)
            ->where('currencies.code', $currency)
            ->get();

        Log::debug("Cash Deposit: " . $cashDeposits);

        $cashDeposits = $cashDeposits->toArray();
        $totalDeposit = 0;
        foreach ($cashDeposits as $val) {
            $totalDeposit = $totalDeposit + $val->total;
        }

        Log::debug("Total Deposit: " . $totalDeposit);

        $cashWithdraws = DB::table('users')
            ->select('users.name as name', 'cash_withdrawals.value as total', 'currencies.code as currency')
            ->join('cash_withdrawals', 'cash_withdrawals.user_id', 'users.id')
            ->join('currencies', 'currencies.id', 'cash_withdrawals.currency_id')
            ->where('users.id', $id)
            ->where('cash_withdrawals.status_id', 2)
            ->where('currencies.code', $currency)
            ->get();

        // Log::debug("Cash Withdraws: " . $cashWithdraws);

        $cashWithdraws = $cashWithdraws->toArray();
        $totalWithdraw = 0;
        foreach ($cashWithdraws as $val) {
            $totalWithdraw = $totalWithdraw + $val->total;
        }

        Log::debug("Total Withdraws: " . $totalWithdraw);

        $account = Account::where('user_id', $id)->orderBy('id', 'desc')->first();
        $total = $totalDeposit - $totalWithdraw > 0.009 ? $totalDeposit - $totalWithdraw : 0;

        Log::debug("Total: " . $total);

        $data = [
            'total' => $total,
            'currency' => $currency,
            'number' => $account->number,
        ];

        Log::debug("Data: " . print_r($data, true));

        return $data;
    }

    static function getDataCashDepositsUser($id)
    {
        $cashDeposits = DB::table('users')
            ->select('users.*', 'cash_deposits.*', 'currencies.code as currencycode', 'statuses.name as statusname')
            ->join('cash_deposits', 'cash_deposits.user_id', 'users.id')
            ->join('currencies', 'currencies.id', 'cash_deposits.currency_id')
            ->join('statuses', 'statuses.id', 'cash_deposits.status_id')
            ->where('users.id', $id)
            ->orderByDesc('cash_deposits.updated_at')
            ->get();

        $data = [
            'cashDeposits' => $cashDeposits,
        ];
        return $data;
    }

    static function getDataMetalDepositsUser($id)
    {
        $metalDeposits = DB::table('users')
            ->select('users.*', 'metal_deposits.*', 'metals.name as metalname', 'status.name as statusname')
            ->join('metal_deposits', 'metal_deposits.user_id', 'users.id')
            ->join('metals', 'metals.id', 'metal_deposits.metal_id')
            ->join('statuses as status', 'status.id', 'metal_deposits.status_id')
            ->where('users.id', $id)
            ->orderByDesc('metal_deposits.updated_at')
            ->get();

        $data = [
            'metalDeposits' => $metalDeposits,
        ];
        return $data;
    }

    static function getDataCashWithdrawalsUser($id)
    {
        $cashWithdrawals = DB::table('users')
            ->select('users.*', 'cash_withdrawals.*', 'currencies.code as currencycode', 'statuses.name as statusname')
            ->join('cash_withdrawals', 'cash_withdrawals.user_id', 'users.id')
            ->join('currencies', 'currencies.id', 'cash_withdrawals.currency_id')
            ->join('statuses', 'statuses.id', 'cash_withdrawals.status_id')
            ->where('users.id', $id)
            ->orderByDesc('cash_withdrawals.updated_at')
            ->get();

        $data = [
            'cashWithdrawals' => $cashWithdrawals,
        ];
        return $data;
    }

    static function getDataMetalithdrawalsUser($id)
    {
        $metalWithdrawals = DB::table('users')
            ->select('users.*', 'metal_withdrawals.*', 'metals.name as metalname', 'status.name as statusname')
            ->join('metal_withdrawals', 'metal_withdrawals.user_id', 'users.id')
            ->join('metals', 'metals.id', 'metal_withdrawals.metal_id')
            ->join('statuses as status', 'status.id', 'metal_withdrawals.status_id')
            ->where('users.id', $id)
            ->orderByDesc('metal_withdrawals.updated_at')
            ->get();

        $data = [
            'metalWithdrawals' => $metalWithdrawals,
        ];
        return $data;
    }

    static function depositUser($id)
    {

        $metalDeposits = DB::table('users')
            ->select(
                'users.name as user',
                'users.email as email',
                'metal_deposits.oz as value',
                'metal_deposits.updated_at as date',
                'metals.name as currencycode',
                'statuses.name as status',
                'payment_methods.name as payment',
                'metal_deposits.id as id'
            )
            ->join('metal_deposits', 'metal_deposits.user_id', 'users.id')
            ->join('metals', 'metals.id', 'metal_deposits.metal_id')
            ->join('statuses', 'statuses.id', 'metal_deposits.status_id')
            ->join('payment_methods', 'payment_methods.id', 'metal_deposits.method_payment_id')
            ->where('users.id', $id);

        $cashDeposits = DB::table('users')
            ->select(
                'users.name as user',
                'users.email as email',
                'cash_deposits.value as value',
                'cash_deposits.updated_at as date',
                'currencies.code as currencycode',
                'statuses.name as status',
                'payment_methods.name as payment',
                'cash_deposits.id as id'
            )
            ->join('cash_deposits', 'cash_deposits.user_id', 'users.id')
            ->join('currencies', 'currencies.id', 'cash_deposits.currency_id')
            ->join('statuses', 'statuses.id', 'cash_deposits.status_id')
            ->join('payment_methods', 'payment_methods.id', 'cash_deposits.payment_method_id')
            ->where('users.id', $id)
            ->union($metalDeposits)->orderByDesc('date')
            ->get();

        $data = $cashDeposits->toArray();

        return $data;
    }

    static function WithdrawalsUser($id)
    {

        $metalWithdrawals = DB::table('users')
            ->select(
                'users.name as user',
                'users.email as email',
                'metal_withdrawals.oz as value',
                'metal_withdrawals.updated_at as date',
                'metals.name as currencycode',
                'statuses.name as status',
                'payment_methods.name as payment',
                'metal_withdrawals.id as id',
                'products.name as product',
                'order_products.quantity as opquantity',
                'order_products.price as opundprice',
                'shipping_options.name as shipping_options',
                'deposit_order_payment.created_at as datepay',
                'deposit_order_payment.value as valuepay'
            )
            ->join('metal_withdrawals', 'metal_withdrawals.user_id', 'users.id')
            ->join('metals', 'metals.id', 'metal_withdrawals.metal_id')
            ->join('statuses', 'statuses.id', 'metal_withdrawals.status_id')
            ->join('payment_methods', 'payment_methods.id', 'metal_withdrawals.method_payment_id')
            ->leftJoin('product_orders', 'product_orders.id', 'metal_withdrawals.order_id')
            ->leftJoin('order_products', 'order_products.order_id', 'product_orders.id')
            ->leftJoin('products', 'products.id', 'order_products.product_id')
            ->leftJoin('currencies', 'currencies.id', 'order_products.currency_id')
            ->leftJoin('shipping_options', 'shipping_options.id', 'product_orders.shipping_option_id')
            ->leftJoin('deposit_order', 'deposit_order.order_id', 'metal_withdrawals.order_id')
            ->leftJoin('deposit_order_payment', 'deposit_order_payment.deposit_order_id', 'deposit_order.id')
            ->where('users.id', $id);

        $cashWithdrawals = DB::table('users')
            ->select(
                'users.name as user',
                'users.email as email',
                'cash_withdrawals.value as value',
                'cash_withdrawals.updated_at as date',
                'currencies.code as currencycode',
                'statuses.name as status',
                'payment_methods.name as payment',
                'cash_withdrawals.id as id',
                'products.name as product',
                'order_products.quantity as opquantity',
                'order_products.price as opundprice',
                'shipping_options.name as shipping_options',
                'deposit_order_payment.created_at as datepay',
                'deposit_order_payment.value as valuepay'
            )
            ->join('cash_withdrawals', 'cash_withdrawals.user_id', 'users.id')
            ->join('currencies', 'currencies.id', 'cash_withdrawals.currency_id')
            ->join('statuses', 'statuses.id', 'cash_withdrawals.status_id')
            ->join('payment_methods', 'payment_methods.id', 'cash_withdrawals.payment_method_id')
            ->leftJoin('product_orders', 'product_orders.id', 'cash_withdrawals.order_id')
            ->leftJoin('order_products', 'order_products.order_id', 'product_orders.id')
            ->leftJoin('products', 'products.id', 'order_products.product_id')
            ->leftJoin('shipping_options', 'shipping_options.id', 'product_orders.shipping_option_id')
            ->leftJoin('deposit_order', 'deposit_order.order_id', 'cash_withdrawals.order_id')
            ->leftJoin('deposit_order_payment', 'deposit_order_payment.deposit_order_id', 'deposit_order.id')
            ->where('users.id', $id)
            ->union($metalWithdrawals)->orderByDesc('date')
            ->get();

        $data = $cashWithdrawals->toArray();

        return $data;
    }

    static function OrderHistory($id)
    {
        $metalorder = DB::table('users')
            ->select(
                'users.name as nameuser',
                'users.email as email',
                'metals.name as product',
                'currencies.code as currency',
                'metal_orders.price_per_oz as priceproduct',
                'metal_orders.quantity_oz as quantity',
                'metal_orders.updated_at as date',
                'deposit_order.order_type as type',
                'statuses.name as status',
                'statuses.type as statustype',
                'payment_methods.name as payment',
                'deposit_order.id as depositorderid',
                'metal_orders.id as id'
            )
            ->join('metal_orders', 'metal_orders.user_id', 'users.id')
            ->join('currencies', 'currencies.id', 'metal_orders.currency_id')
            ->join('metals', 'metals.id', 'metal_orders.metal_id')
            ->leftjoin('statuses', 'statuses.id', 'metal_orders.status_id')
            ->leftJoin('deposit_order', function ($join) {
                $join->on('deposit_order.order_type', DB::raw("'MT'"));
                $join->on('deposit_order.order_id', 'metal_orders.id');
            })
            ->leftJoin('deposit_order_payment', 'deposit_order_payment.deposit_order_id', 'deposit_order.id')
            ->leftJoin('payment_methods', 'payment_methods.id', 'deposit_order_payment.payment_method_id')
            ->where('users.id', $id);

        $orderuser = DB::table('users')
            ->select(
                'users.name as nameuser',
                'users.email as email',
                'products.name as product',
                'currencies.code as currency',
                'order_products.price as priceproduct',
                'order_products.quantity as quantity',
                'order_products.updated_at as date',
                'deposit_order.order_type as type',
                'statuses.name as status',
                'statuses.type as statustype',
                'payment_methods.name as payment',
                'deposit_order.id as depositorderid',
                'product_orders.id as id'
            )
            ->join('product_orders', 'product_orders.user_id', 'users.id')
            ->join('order_products', 'order_products.order_id', 'product_orders.id')
            ->join('products', 'products.id', 'order_products.product_id')
            ->leftjoin('currencies', 'currencies.id', 'order_products.currency_id')
            ->leftjoin('statuses', 'statuses.id', 'product_orders.status_id')
            ->leftJoin('deposit_order', function ($join) {
                $join->on('deposit_order.order_type', DB::raw("'PR'"));
                $join->on('deposit_order.order_id', 'order_products.id');
            })
            ->leftJoin('deposit_order_payment', 'deposit_order_payment.deposit_order_id', 'deposit_order.id')
            ->leftJoin('payment_methods', 'payment_methods.id', 'deposit_order_payment.payment_method_id')
            ->leftJoin('shipping_options', 'shipping_options.id', 'product_orders.shipping_option_id')
            ->where('users.id', $id)
            ->union($metalorder)
            ->get();
        $data = $orderuser->toArray();
        $i = 0;
        foreach ($data as $d) {
            if ($d->type == 'PR') {
                $sh = ShippingOption::select('name')->where('id', ProductOrder::select('shipping_option_id')->where('id', $d->id)->first())->first();
                $data[$i]['shipping_options'] = $sh;
            }
            $i++;
        }

        return $data;
    }

    static function UsersBalancesCompilation()
    {
        $metalDeposits = DB::table('users')->select(
            DB::raw("sum(`oz`) as total"),
            'users.id as idUser',
            'users.email as useremail',
            'accounts.*',
            'metal_deposits.metal_id as idMetal',
            'metals.name as metalName'
        )
            ->join('metal_deposits', 'metal_deposits.user_id', 'users.id')
            ->join('metals', 'metals.id', 'metal_deposits.metal_id')
            ->join('accounts', 'accounts.user_id', 'users.id')
            ->groupBy('users.id', 'metals.id')
            ->where('metal_deposits.status_id', 2)->get();

        $metalWithdraws = DB::table('users')->select(
            DB::raw("sum(`oz`) as total"),
            'users.id as idUser',
            'users.email as useremail',
            'accounts.*',
            'metal_withdrawals.metal_id as idMetal',
            'metals.name as metalName'
        )
            ->join('metal_withdrawals', 'metal_withdrawals.user_id', 'users.id')
            ->join('metals', 'metals.id', 'metal_withdrawals.metal_id')
            ->join('accounts', 'accounts.user_id', 'users.id')
            ->groupBy('users.id', 'metals.id')
            ->get();

        foreach ($metalDeposits as $cd) {
            foreach ($metalWithdraws as $cw) {
                if ($cd->idUser == $cw->idUser && $cd->idMetal == $cw->idMetal) {
                    $cd->total = $cd->total - $cw->total;
                }
            }
        }
        $cashDeposit = DB::table('users')->select(
            DB::raw("sum(`value`) as total"),
            'users.id as idUser',
            'users.email as useremail',
            'accounts.*',
            'cash_deposits.currency_id as idCurrency',
            'currencies.code as currency'
        )
            ->join('cash_deposits', 'cash_deposits.user_id', 'users.id')
            ->join('currencies', 'currencies.id', 'cash_deposits.currency_id')
            ->join('accounts', 'accounts.user_id', 'users.id')
            ->groupBy('users.id', 'currencies.id')
            ->where('cash_deposits.status_id', 2)
            ->get();
        $cashWithdraws = DB::table('users')->select(
            DB::raw("sum(`value`) as total"),
            'users.id as idUser',
            'users.email as useremail',
            'accounts.*',
            'cash_withdrawals.currency_id as idCurrency',
            'currencies.code as currency'
        )
            ->join('cash_withdrawals', 'cash_withdrawals.user_id', 'users.id')
            ->join('currencies', 'currencies.id', 'cash_withdrawals.currency_id')
            ->join('accounts', 'accounts.user_id', 'users.id')
            ->groupBy('users.id', 'currencies.id')
            ->get();

        foreach ($cashDeposit as $cd) {
            foreach ($cashWithdraws as $cw) {
                if ($cd->idUser == $cw->idUser && $cd->idCurrency == $cw->idCurrency) {
                    $cd->total = $cd->total - $cw->total;
                }
            }
            $cd->total = $cd->total > 0.009 ? $cd->total : 0;
        }

        $metals = $metalDeposits;
        $cash = $cashDeposit;

        $data = [
            'metals' => $metals,
            'cash' => $cash
        ];
        return $data;
    }

    static function depositGeneral()
    {
        $metalDeposits = DB::table('users')
            ->select(
                'users.name as user',
                'users.email as email',
                'metal_deposits.oz as value',
                'metal_deposits.updated_at as date',
                'metals.name as currencycode',
                'statuses.name as status',
                'statuses.id as statusid',
                'payment_methods.name as payment',
                'metal_deposits.id as id'
            )
            ->join('metal_deposits', 'metal_deposits.user_id', 'users.id')
            ->join('metals', 'metals.id', 'metal_deposits.metal_id')
            ->join('statuses', 'statuses.id', 'metal_deposits.status_id')
            ->join('payment_methods', 'payment_methods.id', 'metal_deposits.method_payment_id');


        $cashDeposits = DB::table('users')
            ->select(
                'users.name as user',
                'users.email as email',
                'cash_deposits.value as value',
                'cash_deposits.updated_at as date',
                'currencies.code as currencycode',
                'statuses.name as status',
                'statuses.id as statusid',
                'payment_methods.name as payment',
                'cash_deposits.id as id'
            )
            ->join('cash_deposits', 'cash_deposits.user_id', 'users.id')
            ->join('currencies', 'currencies.id', 'cash_deposits.currency_id')
            ->join('statuses', 'statuses.id', 'cash_deposits.status_id')
            ->join('payment_methods', 'payment_methods.id', 'cash_deposits.payment_method_id')

            ->union($metalDeposits)->orderByDesc('date')
            ->get();


        $data = $cashDeposits->toArray();

        return $data;
    }

    static function WithdrawalsGeneral()
    {
        $metalWithdrawals = DB::table('users')
            ->select(
                'users.name as user',
                'users.email as email',
                'metal_withdrawals.oz as value',
                'metal_withdrawals.updated_at as date',
                'metals.name as currencycode',
                'statuses.name as status',
                'statuses.id as statusid',
                'payment_methods.name as payment',
                'metal_withdrawals.id as id'
            )
            ->join('metal_withdrawals', 'metal_withdrawals.user_id', 'users.id')
            ->join('metals', 'metals.id', 'metal_withdrawals.metal_id')
            ->join('statuses', 'statuses.id', 'metal_withdrawals.status_id')
            ->join('payment_methods', 'payment_methods.id', 'metal_withdrawals.method_payment_id');

        $cashWithdrawals = DB::table('users')
            ->select(
                'users.name as user',
                'users.email as email',
                'cash_withdrawals.value as value',
                'cash_withdrawals.updated_at as date',
                'currencies.code as currencycode',
                'statuses.name as status',
                'statuses.id as statusid',
                'payment_methods.name as payment',
                'cash_withdrawals.id as id'
            )
            ->join('cash_withdrawals', 'cash_withdrawals.user_id', 'users.id')
            ->join('currencies', 'currencies.id', 'cash_withdrawals.currency_id')
            ->join('statuses', 'statuses.id', 'cash_withdrawals.status_id')
            ->join('payment_methods', 'payment_methods.id', 'cash_withdrawals.payment_method_id')

            ->union($metalWithdrawals)->orderByDesc('date')
            ->get();

        $data = $cashWithdrawals->toArray();

        return $data;
    }

    static function OrderHistoryGeneral()
    {
        $orderMetals = MetalOrder::get()->toArray();
        $orderuser = ProductOrder::get()->toArray();

        $data = array_merge($orderMetals, $orderuser);
        usort($data, function ($x, $y) {
            return $y['created_at'] <=> $x['created_at'];
        });

        return $data;
    }

    static function ProductOrderHistory()
    {
        $orderProducts = ProductOrder::get()->toArray();

        return $orderProducts;
    }

    static function MetalOrderHistory()
    {
        $orderMetals = MetalOrder::get()->toArray();

        return $orderMetals;
    }

    static function getMetalOrderDetail($depositorderid)
    {
        $metalorder = DB::table('users')
            ->select(
                'users.name as nameuser',
                'users.email as email',
                'metals.name as product',
                'currencies.code as currency',
                'metal_orders.price_per_oz as priceproduct',
                'metal_orders.quantity_oz as quantity',
                'metal_orders.updated_at as date',
                'deposit_order.order_type as type',
                'statuses.name as status',
                'statuses.type as statustype',
                'statuses.id as statusid',
                'payment_methods.name as payment'
            )
            ->join('metal_orders', 'metal_orders.user_id', 'users.id')
            ->join('currencies', 'currencies.id', 'metal_orders.currency_id')
            ->join('metals', 'metals.id', 'metal_orders.metal_id')
            ->leftjoin('statuses', 'statuses.id', 'metal_orders.status_id')
            ->leftJoin('deposit_order', function ($join) {
                $join->on('deposit_order.order_type', DB::raw("'metal_orders'"));
                $join->on('deposit_order.order_id', 'metal_orders.id');
            })
            ->leftJoin('deposit_order_payment', 'deposit_order_payment.deposit_order_id', 'deposit_order.id')
            ->leftJoin('payment_methods', 'payment_methods.id', 'deposit_order_payment.payment_method_id')
            ->where('deposit_order.id', $depositorderid)
            ->first();
        $data = $metalorder->toArray();

        return $data;
    }

    static function getProductOrderDetail($depositorderid)
    {
        $productorder = DB::table('users')
            ->select(
                'users.name as nameuser',
                'users.email as email',
                'products.name as product',
                'currencies.code as currency',
                'order_products.price as priceproduct',
                'order_products.quantity as quantity',
                'order_products.updated_at as date',
                'deposit_order.order_type as type',
                'statuses.name as status',
                'statuses.type as statustype',
                'statuses.id as statusid',
                'payment_methods.name as payment'
            )
            ->join('product_orders', 'product_orders.user_id', 'users.id')
            ->join('order_products', 'order_products.order_id', 'product_orders.id')
            ->join('products', 'products.id', 'order_products.product_id')
            ->leftjoin('currencies', 'currencies.id', 'order_products.currency_id')
            ->leftjoin('statuses', 'statuses.id', 'product_orders.status_id')
            ->leftJoin('deposit_order', function ($join) {
                $join->on('deposit_order.order_type', DB::raw("'product_orders'"));
                $join->on('deposit_order.order_id', 'order_products.id');
            })
            ->leftJoin('deposit_order_payment', 'deposit_order_payment.deposit_order_id', 'deposit_order.id')
            ->leftJoin('payment_methods', 'payment_methods.id', 'deposit_order_payment.payment_method_id')
            ->where('deposit_order.id', $depositorderid)
            ->first();

        $data = $productorder->toArray();

        return $data;
    }

    static function MetalDeposit($id)
    {
        $metalDeposits = DB::table('users')
            ->select(
                'users.name as user',
                'users.email as email',
                'metal_deposits.oz as value',
                'metal_deposits.updated_at as date',
                'metals.name as currencycode',
                'statuses.name as status',
                'payment_methods.name as payment',
                'metal_deposits.id as id'
            )
            ->join('metal_deposits', 'metal_deposits.user_id', 'users.id')
            ->join('metals', 'metals.id', 'metal_deposits.metal_id')
            ->join('statuses', 'statuses.id', 'metal_deposits.status_id')
            ->join('payment_methods', 'payment_methods.id', 'metal_deposits.method_payment_id')
            ->where('metal_deposits.id', $id)
            ->firts();

        $data = $metalDeposits->toArray();

        return $data;
    }

    static function CashDeposit($id)
    {
        $cashDeposits = DB::table('users')
            ->select(
                'users.name as user',
                'users.email as email',
                'cash_deposits.value as value',
                'cash_deposits.updated_at as date',
                'currencies.code as currencycode',
                'statuses.name as status',
                'payment_methods.name as payment',
                'cash_deposits.id as id'
            )
            ->join('cash_deposits', 'cash_deposits.user_id', 'users.id')
            ->join('currencies', 'currencies.id', 'cash_deposits.currency_id')
            ->join('statuses', 'statuses.id', 'cash_deposits.status_id')
            ->join('payment_methods', 'payment_methods.id', 'cash_deposits.payment_method_id')
            ->where('cash_deposits.id', $id)
            ->firts();


        $data = $cashDeposits->toArray();

        return $data;
    }

    static function WithdrawalMetal($id)
    {
        $metalWithdrawals = DB::table('users')
            ->select(
                'users.name as user',
                'users.email as email',
                'metal_withdrawals.oz as value',
                'metal_withdrawals.updated_at as date',
                'metals.name as currencycode',
                'statuses.name as status',
                'payment_methods.name as payment',
                'metal_withdrawals.id as id'
            )
            ->join('metal_withdrawals', 'metal_withdrawals.user_id', 'users.id')
            ->join('metals', 'metals.id', 'metal_withdrawals.metal_id')
            ->join('statuses', 'statuses.id', 'metal_withdrawals.status_id')
            ->join('payment_methods', 'payment_methods.id', 'metal_withdrawals.method_payment_id')
            ->where('metal_withdrawals.id', $id)
            ->firts();

        $data = $metalWithdrawals->toArray();

        return $data;
    }

    static function WithdrawalCash($id)
    {
        $cashWithdrawals = DB::table('users')
            ->select(
                'users.name as user',
                'users.email as email',
                'cash_withdrawals.value as value',
                'cash_withdrawals.updated_at as date',
                'currencies.code as currencycode',
                'statuses.name as status',
                'payment_methods.name as payment',
                'cash_withdrawals.id as id'
            )
            ->join('cash_withdrawals', 'cash_withdrawals.user_id', 'users.id')
            ->join('currencies', 'currencies.id', 'cash_withdrawals.currency_id')
            ->join('statuses', 'statuses.id', 'cash_withdrawals.status_id')
            ->join('payment_methods', 'payment_methods.id', 'cash_withdrawals.payment_method_id')
            ->where('cash_withdrawals.id', $id)
            ->firts();

        $data = $cashWithdrawals->toArray();

        return $data;
    }

    static function getMetalBalances($id, $metal)
    {

        $metalDeposits = MetalDeposit::where('user_id', $id)->where('metal_id', $metal)->where('status_id', "2")->get();
        $metalWithdraws = MetalWithdrawal::where('user_id', $id)->where('metal_id', $metal)->where('status_id', "2")->get();

        $metal_balance = 0;
        foreach ($metalDeposits as $md) {
            $metal_balance += $md->oz;
        }
        foreach ($metalWithdraws as $mw) {
            $metal_balance -= $mw->oz;
        }

        return $metal_balance;
    }

    static function updatePayments($depo, $payPendings, $type, $currency)
    {
        foreach ($payPendings as $payPending) {
            $depositorder = DepositOrder::where('order_id', $payPending->id)->where('table_name', $type)->first();
            $paid = 0;
            if ($depo > 0) {

                $pendingValue = $payPending->subtotal - $payPending->paid;
                if ($pendingValue > 0) {
                    if ($pendingValue <= $depo) {
                        try {
                            $depositorderpay = new DepositOrderPayment();
                            $depositorderpay->deposit_order_id = $depositorder->id;
                            $depositorderpay->currency_id = $currency;
                            $paid = $pendingValue;
                            $depositorderpay->value = $paid;
                            $depositorderpay->payment_method_id = 5;
                            $depositorderpay->save();
                            if ($type == 'metal_orders') {
                                $metalDepo = \App\Models\MetalDeposit::find($payPending->id);
                                $metalDepo->status_id = 2;
                                $metalDepo->save();
                            }

                            $payPending->status_id = 2;
                            $payPending->save();
                            $depo -= $paid;
                        } catch (Exception $e) {
                            var_dump($e);
                        }
                    } else {
                        try {
                            $depositorderpay = new DepositOrderPayment();
                            $depositorderpay->deposit_order_id = $depositorder->id;
                            $depositorderpay->currency_id = $currency;
                            $paid = $depo;
                            $depositorderpay->value = $paid;
                            $depositorderpay->payment_method_id = 5;
                            $depositorderpay->save();
                            $depo = 0;
                        } catch (Exception $e) {
                            var_dump($e);
                        }
                    }
                }
                if ($paid > 0) {
                    try {
                        $cashwhitdrawal = new CashWithdrawal();
                        $cashwhitdrawal->user_id = $payPending->user_id;
                        $cashwhitdrawal->currency_id = $payPending->currency_id;
                        $cashwhitdrawal->value = $paid;
                        $cashwhitdrawal->payment_method_id = 5;
                        $cashwhitdrawal->status_id = 2;
                        if ($type == 'product_orders') {
                            $cashwhitdrawal->order_id = $payPending->id;
                        } else {
                            $cashwhitdrawal->metal_order_id = $payPending->id;
                        }
                        $cashwhitdrawal->save();
                    } catch (Exception $e) {
                        var_dump($e);
                    }
                }
            }
        }
        return $depo;
    }

    static function getRecentOrders($start = NULL, $stop = NULL)
    {
        $ini = is_null($start) ? Carbon::now()->sub('3 days') : $start;
        $end = is_null($stop) ? Carbon::now() : $stop;
        $pOrders = ProductOrder::where('created_at', '>', $ini)->where('created_at', '<', $end)->get()->toArray();
        $mOrders = MetalOrder::where('created_at', '>', $ini)->where('created_at', '<', $end)->get()->toArray();

        return array_merge($pOrders, $mOrders);
    }

    static function getTotalWeight()
    {
        $totalWeight = 0;
        foreach (Cart::getContent() as $item) {
            $totalWeight += ($item->attributes->weight * $item->quantity) / 16;
        }
        return $totalWeight;
    }

    // getPromoCodeDiscount
    static function getPromoCodeDiscount($code, $total)
    {
        $promoCode = PromoCode::where('code', $code)->first();
        if ($promoCode && $promoCode->isValid()) {
            $discount = $promoCode->getDiscountAmount($total);
            return $discount;
        } else {
            return 0;
        }
    }

    // send Product Status Email
    static function sendProductStatusEmail($productOrder, $oldStatusId)
    {
        if ($oldStatusId != $productOrder->status_id) {
            try {
                switch ($productOrder->status_id) {
                    case 2:
                        Mail::to($productOrder->user->email)->send(new OrderStatusChangeMail($productOrder));
                        break;
                    case 4:
                        Mail::to($productOrder->user->email)->send(new OrderCompletedMail($productOrder));
                        Mail::to($productOrder->user->email)->send(new OrderFeedbackMail($productOrder));
                        break;
                    case 5:
                        Mail::to($productOrder->user->email)->send(new OrderShippedMail($productOrder));
                        break;
                    case 7:
                        Mail::to($productOrder->user->email)->send(new OrderCancelledMail($productOrder));
                        break;
                    case 13:
                        // Mail::to($productOrder->user->email)->send(new OrderPendingPaymentMail($productOrder));
                        break;
                }
            } catch (\Throwable $th) {
                \Log::error($th); // Log the error
                // throw $th;
            }
        }
    }

    // Select percent interval fot 1-9, 10-24, 25-49, 50+
    static function getPercentInterval($percent)
    {
        if ($percent >= 1 && $percent <= 9) {
            return '1';
        } elseif ($percent >= 10 && $percent <= 24) {
            return '2';
        } elseif ($percent >= 25 && $percent <= 49) {
            return '3';
        } elseif ($percent >= 50) {
            return '4';
        }
    }

    // Get Product data by id
    static function getProductData($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        if ($product) {
            return $product;
        } else {
            return null;
        }
    }

    // Get Card Type 
    function getCardType($number) {
    $number = preg_replace('/\D/', '', $number); // Remove non-digits

    if (preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/', $number)) {
        return 'Visa';
    } elseif (preg_match('/^5[1-5][0-9]{14}$/', $number)) {
        return 'MasterCard';
    } elseif (preg_match('/^3[47][0-9]{13}$/', $number)) {
        return 'American Express';
    } elseif (preg_match('/^6(?:011|5[0-9]{2})[0-9]{12}$/', $number)) {
        return 'Discover';
    }

    return 'Unknown';
}


}
