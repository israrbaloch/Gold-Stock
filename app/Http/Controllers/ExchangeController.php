<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Exceptions\CustomException;
use App\Helper\BalanceHelper;
use App\Helper\CurrencyHelper;
use Cookie;
use App\Helper\Helper;
use App\Helper\HistoricalHelper;
use App\Models\MetalOrder;
use App\Models\CashDeposit;
use App\Models\DepositOrder;
use App\Models\MetalDeposit;
use Illuminate\Http\Request;
use App\Models\CashWithdrawal;
use App\Models\MetalWithdrawal;
use Illuminate\Support\Facades\DB;
use App\Models\DepositOrderPayment;
use App\Http\Controllers\AjaxPricesController;
use App\Mail\AdminMetalTransactionCompletedMail;
use App\Mail\UserMetalTransactionCompletedMail;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\Currency;
use App\Models\Metal;
use App\Models\User;
use App\Services\HistoricalTimeFrameService;
use Cache;
use Illuminate\Support\Facades\Mail;
use Log;

class ExchangeController extends Controller {

    private $historicalTimeFrameService;

    public function __construct(HistoricalTimeFrameService $historicalTimeFrameService) {
        $this->historicalTimeFrameService = $historicalTimeFrameService;
    }

    public function index($metal = 'gold') {
        switch ($metal) {
            case 'gold':
                $_currentMetal = Cache::get('exchange_gold');
                break;
            case 'silver':
                $_currentMetal = Cache::get('exchange_silver');
                break;
            case 'platinum':
                $_currentMetal = Cache::get('exchange_platinum');
                break;
            case 'palladium':
                $_currentMetal = Cache::get('exchange_palladium');
                break;
            default:
                $_currentMetal = null;
                break;
        }

        $askBids = HistoricalHelper::getAskBids($metal);
        $candles = HistoricalHelper::getCandles($metal);

        $currency = Cookie::get('currency');
        $metal_id = Metal::where('code', $metal)->first()->id;

        // $changes = HistoricalHelper::getChangePercent();

        // dd($changes);

        return view('exchange.index')
            ->with('_metal', $metal)
            ->with('_currentMetal', $_currentMetal)
            ->with('_ask', $askBids['ask'])
            ->with('_bid', $askBids['bid'])
            ->with('_candles', $candles)
            ->with('metal_currency', $currency)
            ->with('metal_id', $metal_id);
    }

    public function getRate($currency) {
        if ($currency != 'USD') {
            $col = strtolower($currency)  . '_rate';
        } else {
            $col = 'us_rate';
        }
        $rates = DB::table('ic_historical_rate')->orderBy('id', 'desc')->first();
        return $rates->$col;
    }

    public function buyMetal(Request $request) {
        try {
            if (!Auth::check()) {
                throw new CustomException('Unauthorized', 401);
            }

            $request->validate([
                'metal' => 'required',
                'total' => 'required|numeric'
            ]);

            if ($request->total <= 0) {
                throw new CustomException('Invalid amount', 400);
            }

            $total = round($request->total, 4, PHP_ROUND_HALF_DOWN);
            $metal = Metal::where('name', 'like', $request->metal)->first();

            $currency = Currency::where('code', Cookie::get('currency'))->first();
            $userBalance = BalanceHelper::getUserBalances();
            try {
                $currencyRate = CurrencyHelper::getCurrency($currency->code);
                $metalValue = $this->historicalTimeFrameService->getCurrentMetal($request->metal)->value;
            } catch (\Throwable $th) {
                throw new CustomException('Failed to fetch data', 500);
            }



            $fee = 0;
            switch ($request->metal) {
                case 'gold':
                    $fee = $total * 0.01;
                    break;
                case 'silver':
                    $fee = $total * 0.02;
                    break;
                case 'platinum':
                case 'palladium':
                    $fee = $total * 0.05;
                    break;
                default:
                    throw new CustomException('Invalid metal', 400);
            }

            Log::info("User Balance: " . $userBalance['cash']);
            Log::info("Currency Rate: " . $currencyRate->value);
            Log::info("Metal Value: " . $metalValue);
            Log::info("Total: " . $total);
            Log::info("Fee: " . $fee);

            if ($userBalance['cash'] < $total) {
                throw new CustomException('Insufficient funds', 402);
            }
            $totalAfterFee = $total - $fee;
            $amount = round($totalAfterFee / ($metalValue * $currencyRate->value), 4, PHP_ROUND_HALF_DOWN);
            Log::info("Amount: " . $amount);

            if ($amount <= 0) {
                throw new CustomException('Invalid amount', 400);
            }

            $metalOrder = new MetalOrder();
            $metalOrder->user_id = Auth::user()->id;
            $metalOrder->metal_id = $metal->id;
            $metalOrder->quantity_oz = $amount;
            $metalOrder->price_per_oz = $metalValue * $currencyRate->value;
            $metalOrder->currency_id = $currency->id;
            $metalOrder->status_id = OrderStatus::PAID;
            $metalOrder->by_admin = 0;
            $metalOrder->fee = $fee;
            $metalOrder->save();

            $cashWithdrawal = new CashWithdrawal();
            $cashWithdrawal->user_id = Auth::user()->id;
            $cashWithdrawal->currency_id = $currency->id;
            $cashWithdrawal->value = $total;
            $cashWithdrawal->metal_order_id = $metalOrder->id;
            $cashWithdrawal->payment_method_id = 5;
            $cashWithdrawal->status_id = OrderStatus::PAID;
            $cashWithdrawal->save();

            $metalDeposit = new MetalDeposit();
            $metalDeposit->id = $metalOrder->id;
            $metalDeposit->user_id = Auth::user()->id;
            $metalDeposit->metal_id = $metal->id;
            $metalDeposit->oz = $amount;
            $metalDeposit->method_payment_id = 1;
            $metalDeposit->status_id = OrderStatus::PAID;
            $metalDeposit->save();

            $depositOrder = new DepositOrder();
            $depositOrder->order_type = 'Buy';
            $depositOrder->order_id = $metalOrder->id;
            $depositOrder->table_name = 'metal_orders';
            $depositOrder->save();

            $depositOrderPay = new DepositOrderPayment();
            $depositOrderPay->deposit_order_id = $depositOrder->id;
            $depositOrderPay->currency_id = $currency->id;
            $depositOrderPay->value = $total;
            $depositOrderPay->payment_method_id = 5;
            $depositOrderPay->save();

            $account = Account::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();
            $data = array(
                'fname' => Auth::user()->name,
                'email' => Auth::user()->email,
                'account_number' => $account->number,
                'address' => $account->address_line1,
                'city' => $account->city,
                'phone' => $account->phone,
                'metal' => $metal->name,
                'currency' => $currency->code,
                'totalmetal' => $metalOrder->quantity_oz,
                'price_per_oz' => $metalOrder->price_per_oz,
                'totalprice' => $totalAfterFee,
                'ordertype' => "Buy",
                'orderid' => $metalOrder->order_id,
                'orderDate' => $metalOrder->created_at,
                'metalOrder' => $metalOrder->id,
                'due' => 0,
                'pending' => 0,
                'fee' => $fee,
            );
            Mail::to(Auth::user()->email)->queue(new UserMetalTransactionCompletedMail($data));
            $admins = User::whereIn('role_id', [1])->pluck('email');
            Mail::to($admins)->queue(new AdminMetalTransactionCompletedMail($data));
            return response()->json(
                [
                    'success' => true,
                    'data' => [
                        'total' => $userBalance['cash'] - $total,
                        'amount' => $userBalance[$request->metal] + $amount,
                    ],
                ],
                200
            );
        } catch (CustomException $th) {
            Log::error($th);
            return response()->json([
                'success' => false,
                'msg' => $th->getMessage()
            ], $th->getCode());
        } catch (\Exception $th) {
            Log::error($th);
            return response()->json([
                'success' => false,
                'msg' => 'Failed to buy metal'
            ], 500);
        }
    }

    public function sellMetal(Request $request) {
        try {
            if (!Auth::check()) {
                throw new CustomException('Unauthorized', 401);
            }

            $request->validate([
                'metal' => 'required',
                'amount' => 'required|numeric'
            ]);

            if ($request->amount <= 0) {
                throw new CustomException('Invalid amount', 400);
            }

            $amount = $request->amount;
            $metal = Metal::where('name', 'like', $request->metal)->first();

            $currency = Currency::where('code', Cookie::get('currency'))->first();
            $userBalance = BalanceHelper::getUserBalances();
            try {
                $currencyRate = CurrencyHelper::getCurrency($currency->code);
                $metalValue = $this->historicalTimeFrameService->getCurrentMetal($request->metal)->value;
            } catch (\Throwable $th) {
                throw new CustomException('Failed to fetch data', 500);
            }

            $total = round($amount * $metalValue * $currencyRate->value, 4, PHP_ROUND_HALF_DOWN);
            if ($total <= 0) {
                throw new CustomException('Invalid amount', 400);
            }

            $fee = 0;
            switch ($request->metal) {
                case 'gold':
                    $fee = $total * 0.01;
                    break;
                case 'silver':
                    $fee = $total * 0.02;
                    break;
                case 'platinum':
                case 'palladium':
                    $fee = $total * 0.05;
                    break;
                default:
                    throw new CustomException('Invalid metal', 400);
            }

            $totalAfterFee = $total - $fee;
            if ($userBalance[$request->metal] < $amount) {
                throw new CustomException('Insufficient metal', 402);
            }

            $metalOrder = new MetalOrder();
            $metalOrder->user_id = auth()->user()->id;
            $metalOrder->metal_id = $metal->id;
            $metalOrder->quantity_oz = $amount;
            $metalOrder->price_per_oz = $metalValue * $currencyRate->value;
            $metalOrder->currency_id = $currency->id;
            $metalOrder->status_id = OrderStatus::PAID;
            $metalOrder->fee = $fee;
            $metalOrder->save();

            $metalWithdrawal = new MetalWithdrawal();
            $metalWithdrawal->user_id = auth()->user()->id;
            $metalWithdrawal->metal_id = $metal->id;
            $metalWithdrawal->oz = $amount;
            $metalWithdrawal->method_payment_id = 5;
            $metalWithdrawal->status_id = OrderStatus::PAID;
            $metalWithdrawal->metal_order_id = $metalOrder->id;
            $metalWithdrawal->save();

            $depositOrder = new DepositOrder();
            $depositOrder->order_type = 'Sell';
            $depositOrder->order_id = $metalWithdrawal->id;
            $depositOrder->table_name = 'metal_withdrawals';
            $depositOrder->save();

            $cashDeposit = new CashDeposit();
            $cashDeposit->user_id = auth()->user()->id;
            $cashDeposit->currency_id = $currency->id;
            $cashDeposit->value = $totalAfterFee;
            $cashDeposit->status_id = OrderStatus::PAID;
            $cashDeposit->payment_method_id = 5;
            $cashDeposit->save();

            $account = Account::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->first();
            $data = array(
                'fname' => auth()->user()->name,
                'email' => auth()->user()->email,
                'account_number' => $account->number,
                'address' => $account->address_line1,
                'city' => $account->city,
                'phone' => $account->phone,
                'metal' => $metal->name,
                'currency' => $currency->id,
                'totalmetal' => $metalOrder->quantity_oz,
                'price_per_oz' => $metalOrder->price_per_oz,
                'totalprice' => $totalAfterFee,
                'ordertype' => "Sell",
                'orderid' => $metalOrder->order_id,
                'orderDate' => $metalOrder->created_at,
                'metalOrder' => $metalOrder->id,
                'due' => 0,
                'fee' => $fee,
                'pending' => 0
            );
            Mail::to(Auth::user()->email)->queue(new UserMetalTransactionCompletedMail($data));
            $admins = User::whereIn('role_id', [1])->pluck('email');
            Mail::to($admins)->queue(new AdminMetalTransactionCompletedMail($data));
            return response()->json(
                [
                    'success' => true,
                    'data' => [
                        'total' => $userBalance['cash'] + $total,
                        'amount' => $userBalance[$request->metal] - $amount,
                    ],
                ],
                200
            );
        } catch (CustomException $th) {
            Log::error($th);
            return response()->json([
                'success' => false,
                'msg' => $th->getMessage()
            ], $th->getCode());
        } catch (\Exception $th) {
            Log::error($th);
            return response()->json([
                'success' => false,
                'msg' => 'Failed to buy metal'
            ], 500);
        }
    }

    public function getMetalPrices(Request $request) {
        $controller = new AjaxPricesController();
        $prices = $controller->getMetalPrices($request->currency);
        return response()->json(array('success' => true, 'prices' => $prices), 200);
    }
}
