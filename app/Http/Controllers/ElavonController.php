<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GlobalPayments\Api\ServicesContainer;
use GlobalPayments\Api\PaymentMethods\CreditCardData;
use GlobalPayments\Api\ServiceConfigs\ServicesConfig;
use GlobalPayments\Api\Entities\Exceptions\ApiException;
use GlobalPayments\Api\Entities\Exceptions\BuilderException;
use GlobalPayments\Api\Entities\Exceptions\GatewayException;
use GlobalPayments\Api\Entities\Exceptions\ConfigurationException;
use GlobalPayments\Api\Entities\Exceptions\UnsupportedTransactionException;
use Illuminate\Support\Facades\DB;
use Cookie;


class ElavonController extends Controller {
    public function checkoutElavon() {
        /*
        $config = new ServicesConfig();
        $config->merchantId = env("ELAVON_MERCHANT");
        $config->accountId = env("ELAVON_ACCOUNT");
        $config->sharedSecret = env("ELAVON_PASS");
        $config->serviceUrl = env("ELAVON_URL");
        //
        ServicesContainer::configure($config);

        // create the card object
        $card = new CreditCardData();
        $card->number = '4263970000005262';
        $card->expMonth = 12;
        $card->expYear = 2025;
        $card->cvn = '131';
        $card->cardHolderName = "James Mason";

        try {

            // process an auto-capture authorization
            $response = $card->charge(19.99)
                ->withCurrency("EUR")
                ->execute();
        } catch (ApiException $e) {
            dd($e);
            // TODO: Add your error handling here
        }
        if (isset($response)) {

            $result = $response->responseCode; // 00 == Success
            $message = $response->responseMessage; // [ test system ] AUTHORISED

            // get the details to save to the DB for future requests
            $orderId = $response->orderId; // N6qsk4kYRZihmPrTXWYS6g
            $authCode = $response->authorizationCode; // 12345
            $paymentsReference = $response->transactionId; // pasref: 14610544313177922
            $schemeReferenceData = $response->schemeId; // MMC0F00YE4000000715
        }
        return $result;
        */
    }

    public function getToken() {
        $resp['success'] = false;
        $resp['token'] = '';
        $resp['error'] = '';


        $merchantID = config("services.elavon.merchant_id");
        $merchantUserID = config("services.elavon.account");
        $merchantPinCode = config("services.elavon.pass");
        $url = config("services.elavon.url");

        $firstname = $_POST['ssl_first_name']; //Post first name
        $lastname = $_POST['ssl_last_name']; //Post first name
        $amount = floatval($_POST['ssl_amount']); //Post Tran Amount
        $true_amount = $this->_getCadAmount($amount);

        $ch = curl_init();    // initialize curl handle
        curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
        curl_setopt($ch, CURLOPT_POST, true); // set POST method
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            "ssl_merchant_id=$merchantID" .
                "&ssl_user_id=$merchantUserID" .
                "&ssl_pin=$merchantPinCode" .
                "&ssl_transaction_type=CCSALE" .
                "&ssl_first_name=$firstname" .
                "&ssl_last_name=$lastname" .
                "&ssl_get_token=Y" .
                "&ssl_add_token=Y" .
                "&ssl_amount=$true_amount"
        );

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);

        $result = curl_exec($ch); // run the curl procss
        curl_close($ch); // Close cURL

        if (str_contains(strtolower($result), 'error')) {
            $resp['error'] = $result;
        } else {
            $resp['success'] = true;
            $resp['token'] = $result;
            $resp['merchantID'] = $merchantID;
            $resp['merchantUserID'] = $merchantUserID;
            $resp['merchantPinCode'] = $merchantPinCode;
            $resp['firstname'] = $firstname;
            $resp['lastname'] = $lastname;
            $resp['amount'] = $amount;
            $resp['true_amount'] = $true_amount;
            $resp['url'] = $url;
            $resp['rates'] = DB::table('ic_historical_rate')->orderBy('id', 'desc')->first();
            $resp['currency'] = Cookie::get('cart_currency');
        }
        return response()->json($resp, 200);
    }

    private function _getCadAmount($amount) {

        $cad_rate = $this->_getRate("cad_inverse");

        $cad_rate_to = $this->_getRate("cad");

        $eur_rate = $this->_getRate("eur_inverse");

        $cash_currency = Cookie::get('cart_currency');

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

        $true_amount = $true_value * $cad_rate_to;

        return round($true_amount, 2, PHP_ROUND_HALF_UP);
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
