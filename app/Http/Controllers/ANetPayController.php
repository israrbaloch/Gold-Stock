<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Account;
use App\Models\Currency;
use App\Models\ShippingOption;
use Cart;
use Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class ANetPayController extends Controller {

    function getToken() {

        try {

            $resp['success'] = false;
            $resp['token'] = '';
            $resp['error'] = '';

            // Common setup for API credentials
            $request = new AnetAPI\GetHostedPaymentPageRequest();

            // merchantAuthentication
            $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
            $merchantAuthentication->setName(config("services.authorize_net.api_login_id"));
            $merchantAuthentication->setTransactionKey(config("services.authorize_net.transaction_key"));
            $request->setMerchantAuthentication($merchantAuthentication);


            // $resp['merchantAuthentication'] = $merchantAuthentication;

            // Set the transaction's refId
            $refId = 'ref' . time();
            $request->setRefId($refId);

            Log::debug($_POST);
            $account = Account::where('user_id', Auth::user()->id)->first();
            if ($account == null) {
                Log::debug("Account not found");
                return response()->json(404);
            }


            $email = Auth::user()->email;
            if ($email == null) {
                Log::debug("Email not found");
                return response()->json(404);
            }
            $first_name = $account->fname;
            $last_name = $account->lname;
            $phone = $account->phone;

            Cart::session(Cookie::get('_cartid'));

            // ===========================================
            $shippingId = Cookie::get('shipping_id', 1);
            $shippingOption = ShippingOption::where('id', $shippingId)->first();
            $userBalances = array();
            $currencies = Currency::select('code')->get();
            $balances = Helper::getUserBalances(Auth::user()->id);
            foreach ($balances['cash'] as $cashbalance) {
                $userBalances[$cashbalance->currency] = $cashbalance->total;
            }
            foreach ($currencies as $currency) {
                if (!array_key_exists($currency->code, $userBalances)) {
                    $userBalances[$currency->code] = 0;
                }
            }

            if (Cookie::has('cart_currency')) {
                $currency = Cookie::get('cart_currency');
            } else if (Cookie::has('currency')) {
                $currency = Cookie::get('currency');
            }
            Log::debug($_COOKIE);
            Log::debug("Currency: " . $currency);
            Log::debug(json_encode($userBalances));
            $balance = $userBalances ? $userBalances[$currency] : 0;
            // ===========================================
            $firstItem = Cart::getContent()->first();
            $isCash = $firstItem && $firstItem->attributes->type == 'cash';
            $subtotal = Cart::getTotal();
            $userBalance = $balance <= 0 ? 0 : round($balance, 2);
            $shipping_price = 0;
            if ($shippingOption->name == 'Delivery' && Cart::getTotal() > 100) {
                $shipping_price = 20;
            }
            $minDeposit = $isCash ? number_format(floor($subtotal * 100) / 100, 2) : number_format(floor($subtotal * 0.1 * 100) / 100, 2);
            $fee = $isCash ? number_format(floor($subtotal * 0.0375 * 100) / 100, 2) : number_format(floor($minDeposit * 0.0375 * 100) / 100, 2);
            $dueNow = $minDeposit + $fee - $userBalance + $shipping_price;
            // ===========================================

            $amount = $dueNow;
            Log::debug("amount: " . $amount);
            Log::debug("first_name: " . $first_name);
            Log::debug("last_name: " . $last_name);
            Log::debug("email: " . $email);
            Log::debug("amount: " . $amount);
            Log::debug("phone: " . $phone);

            // Transaction Request
            $transactionRequestType = new AnetAPI\TransactionRequestType();
            $transactionRequestType->setTransactionType("authCaptureTransaction");

            $true_amount = $this->_getCadAmount($amount);
            $resp['amount'] = $true_amount;
            $transactionRequestType->setAmount($true_amount);

            $customerDataType =  new AnetAPI\CustomerDataType();
            $customerDataType->setEmail($email);
            $transactionRequestType->setCustomer($customerDataType);

            $billTo = new AnetAPI\CustomerAddressType();
            $billTo->setEmail($email);
            if ($first_name != null) {
                $billTo->setFirstName($first_name);
            }
            if ($last_name != null) {
                $billTo->setLastName($last_name);
            }
            if ($phone != null) {
                $billTo->setPhoneNumber($phone);
            }
            $transactionRequestType->setBillTo($billTo);

            $description = 'User email: ' . $email .
                ' - View Recent Orders: ' . url('/') .  '/admin/daily-activity';
            $orderType = new AnetAPI\OrderType();
            $orderType->setDescription($description);
            $transactionRequestType->setOrder($orderType);

            $request->setTransactionRequest($transactionRequestType);

            // Hosted Payment Settings
            $setting0 = new AnetAPI\SettingType();
            $setting0->setSettingName("hostedPaymentPaymentOptions");
            $setting0->setSettingValue("{\"showBankAccount\": false}");

            $setting1 = new AnetAPI\SettingType();
            $setting1->setSettingName("hostedPaymentButtonOptions");
            $setting1->setSettingValue("{\"text\": \"Pay\"}");

            $setting2 = new AnetAPI\SettingType();
            $setting2->setSettingName("hostedPaymentOrderOptions");
            $setting2->setSettingValue("{\"show\": false}");

            $setting3 = new AnetAPI\SettingType();
            $setting3->setSettingName("hostedPaymentReturnOptions");
            $setting3->setSettingValue("{\"showReceipt\" : false }");

            $setting4 = new AnetAPI\SettingType();
            $setting4->setSettingName("hostedPaymentIFrameCommunicatorUrl");

            // Retrieve the app URL from the configuration file
            $appUrl = config('app.url');

            // Construct the URL string using the app URL
            $url = "{$appUrl}/anet/iframe";
            Log::debug("URL: " . $url);

            // Set the URL value in the setting
            $setting4->setSettingValue(json_encode(['url' => $url]));

            $setting5 = new AnetAPI\SettingType();
            $setting5->setSettingName("hostedPaymentShippingAddressOptions");
            $setting5->setSettingValue("{\"show\" : false, \"required\" : false }");

            $setting6 = new AnetAPI\SettingType();
            $setting6->setSettingName("hostedPaymentBillingAddressOptions");
            $setting6->setSettingValue("{\"show\" : true, \"required\" : true }");

            $request->addToHostedPaymentSettings($setting0);
            $request->addToHostedPaymentSettings($setting1);
            $request->addToHostedPaymentSettings($setting2);
            $request->addToHostedPaymentSettings($setting3);
            $request->addToHostedPaymentSettings($setting4);
            //$request->addToHostedPaymentSettings($setting5);
            $request->addToHostedPaymentSettings($setting6);

            // Execute request
            $controller = new AnetController\GetHostedPaymentPageController($request);

            if (config('app.env') != 'production') {
                Log::debug("Request: SANDBOX");
                $anetResponse = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
            } else {
                Log::debug("Request: PRODUCTION");
                $anetResponse = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
            }

            if (($anetResponse != null) && ($anetResponse->getMessages()->getResultCode() == "Ok")) {
                Log::debug("Token: " . $anetResponse->getToken());
                $resp['success'] = true;
                $resp['token'] = $anetResponse->getToken();
            } else {
                Log::debug("ERROR :  Failed to get hosted payment page token\n");
                $errorMessages = $anetResponse->getMessages()->getMessage();
                $resp['error'] = "Server Error";
                Log::critical($errorMessages[0]->getCode() . "  " . $errorMessages[0]->getText());
            }
            return response()->json($resp, 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function handleonlinepay() {
        //        $input = $request->input();
        //        
        //        /* Create a merchantAuthenticationType object with authentication details
        //          retrieved from the constants file */
        //        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        //        $merchantAuthentication->setName(env('ANET_API_LOGIN_ID'));
        //        $merchantAuthentication->setTransactionKey(env('ANET_TRANSACTION_KEY'));
        //
        //        // Set the transaction's refId
        //        $refId = 'ref' . time();
        //        $cardNumber = preg_replace('/\s+/', '', $input['cardNumber']);
        //        
        //        // Create the payment data for a credit card
        //        $creditCard = new AnetAPI\CreditCardType();
        //        $creditCard->setCardNumber($cardNumber);
        //        $creditCard->setExpirationDate($input['expiration-year'] . "-" .$input['expiration-month']);
        //        $creditCard->setCardCode($input['cvv']);
        //
        //        // Add the payment data to a paymentType object
        //        $paymentOne = new AnetAPI\PaymentType();
        //        $paymentOne->setCreditCard($creditCard);
        //
        //        // Create a TransactionRequestType object and add the previous objects to it
        //        $transactionRequestType = new AnetAPI\TransactionRequestType();
        //        $transactionRequestType->setTransactionType("authCaptureTransaction");
        //        $transactionRequestType->setAmount($input['amount']);
        //        $transactionRequestType->setPayment($paymentOne);
        //
        //        // Assemble the complete transaction request
        //        $requests = new AnetAPI\CreateTransactionRequest();
        //        $requests->setMerchantAuthentication($merchantAuthentication);
        //        $requests->setRefId($refId);
        //        $requests->setTransactionRequest($transactionRequestType);
        //
        //        // Create the controller and get the response
        //        $controller = new AnetController\CreateTransactionController($requests);
        //        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
        //
        //        if ($response != null) {
        //            // Check to see if the API request was successfully received and acted upon
        //            if ($response->getMessages()->getResultCode() == "Ok") {
        //                // Since the API request was successful, look for a transaction response
        //                // and parse it to display the results of authorizing the card
        //                $tresponse = $response->getTransactionResponse();
        //
        //                if ($tresponse != null && $tresponse->getMessages() != null) {
        ////                    echo " Successfully created transaction with Transaction ID: " . $tresponse->getTransId();
        ////                    echo " Transaction Response Code: " . $tresponse->getResponseCode();
        ////                    echo " Message Code: " . $tresponse->getMessages()[0]->getCode();
        ////                    echo " Auth Code: " . $tresponse->getAuthCode();
        ////                    echo " Description: " . $tresponse->getMessages()[0]->getDescription();
        //                    $message_text = $tresponse->getMessages()[0]->getDescription().", Transaction ID: " . $tresponse->getTransId();
        //                    $msg_type = "success_msg";    
        //                    /*
        //                    \App\PaymentLogs::create([                                         
        //                        'amount' => $input['amount'],
        //                        'response_code' => $tresponse->getResponseCode(),
        //                        'transaction_id' => $tresponse->getTransId(),
        //                        'auth_id' => $tresponse->getAuthCode(),
        //                        'message_code' => $tresponse->getMessages()[0]->getCode(),
        //                        'name_on_card' => trim($input['owner']),
        //                        'quantity'=>1
        //                    ]);
        //                     */
        //                } else {
        //                    $message_text = 'There were some issue with the payment. Please try again later.';
        //                    $msg_type = "error_msg";                                    
        //
        //                    if ($tresponse->getErrors() != null) {
        //                        $message_text = $tresponse->getErrors()[0]->getErrorText();
        //                        $msg_type = "error_msg";                                    
        //                    }
        //                }
        //                // Or, print errors if the API request wasn't successful
        //            } else {
        //                $message_text = 'There were some issue with the payment. Please try again later.';
        //                $msg_type = "error_msg";                                    
        //
        //                $tresponse = $response->getTransactionResponse();
        //
        //                if ($tresponse != null && $tresponse->getErrors() != null) {
        //                    $message_text = $tresponse->getErrors()[0]->getErrorText();
        //                    $msg_type = "error_msg";                    
        //                } else {
        //                    $message_text = $response->getMessages()->getMessage()[0]->getText();
        //                    $msg_type = "error_msg";
        //                }                
        //            }
        //        } else {
        //            $message_text = "No response returned";
        //            $msg_type = "error_msg";
        //        }
        //        return back()->with($msg_type, $message_text);
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName("2gkg2S52N6");
        $merchantAuthentication->setTransactionKey("8NVG9Lc32mwNv27a");
        $refId = 'ref' . time();

        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber("4111111111111111");
        $creditCard->setExpirationDate("2038-12");
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        // Create a transaction
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount(151.51);
        $transactionRequestType->setPayment($paymentOne);
        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setTransactionRequest($transactionRequestType);
        $controller = new AnetController\CreateTransactionController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
        $errorMessages = $response->getMessages()->getMessage();
        echo $errorMessages[0]->getCode() . "  " . $errorMessages[0]->getText();

        if ($response != null) {
            $tresponse = $response->getTransactionResponse();
            if (($tresponse != null) && ($tresponse->getResponseCode() == "1")) {
                echo "Charge Credit Card AUTH CODE : " . $tresponse->getAuthCode();
                echo "Charge Credit Card TRANS ID  : " . $tresponse->getTransId();
            } else {
                echo "Charge Credit Card ERROR :  Invalid response\n";
            }
        } else {
            echo "Charge Credit Card Null response returned";
        }
    }

    private function _getCadAmount($amount) {

        $cad_rate = $this->_getRate("cad_inverse");
        $cad_rate_to = $this->_getRate("cad");
        $eur_rate = $this->_getRate("eur_inverse");
        $cash_currency = Cookie::get('cart_currency');

        Log::debug("cad_rate: $cad_rate");
        Log::debug("cad_rate_to: $cad_rate_to");
        Log::debug("eur_rate: $eur_rate");
        Log::debug("cash_currency: $cash_currency");

        if ($cash_currency == "USD") {
            $rate = 1;
            $true_value = $amount * $rate;
        } else if ($cash_currency == "CAD") {
            $rate = $cad_rate;
            $true_value = $amount * $rate;
        } else if ($cash_currency == "EUR") {
            $rate = $eur_rate;
            $true_value = $amount * $rate;
        } else {
            $true_value = 0;
        }
        Log::debug("rate: $rate");
        Log::debug("true_value: $true_value");


        $true_amount = $true_value * $cad_rate_to;
        Log::debug("true_amount: $true_amount");


        $result = round($true_amount, 2, PHP_ROUND_HALF_UP);
        Log::debug("result: $result");
        return $result;
    }

    private function _getRate($currency) {
        $rates = DB::table('ic_historical_rate')->orderBy('id', 'desc')->first();

        if (strtolower($currency) == "us" || strtolower($currency) == "usd") {
            return $rates->us_rate;
        } elseif (strtolower($currency) == "cad") {
            return $rates->cad_rate;
        } elseif (strtolower($currency) == "eur") {
            return $rates->eur_rate;
        } elseif (strtolower($currency) == "cad_inverse") {
            return $rates->cad_rate_inverse;
        } elseif (strtolower($currency) == "eur_inverse") {
            return $rates->eur_rate_inverse;
        } else {
            return 0;
        }
    }
}
