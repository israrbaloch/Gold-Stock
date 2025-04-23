<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Province;
use FedEx\RateService\Request;
use FedEx\RateService\SimpleType;
use FedEx\RateService\ComplexType;


class FedexController extends Controller {
    public function getFedex($userId, $weight) {
        if ($userId > 0) {
            $account = Account::where('user_id', $userId)->orderBy('id', 'desc')->first();
            $province = Province::find($account->province_id);

            $rateRequest = new ComplexType\RateRequest();

            // Authentication & Client Details
            $rateRequest->WebAuthenticationDetail->UserCredential->Key = env("FEDEX_KEY");
            $rateRequest->WebAuthenticationDetail->UserCredential->Password = env("FEDEX_PASS");
            $rateRequest->ClientDetail->AccountNumber = env("FEDEX_ACCOUNT");
            $rateRequest->ClientDetail->MeterNumber = env("FEDEX_METER");

            $rateRequest->TransactionDetail->CustomerTransactionId = 'GoldStockCanada Order';

            //version
            $rateRequest->Version->ServiceId = 'crs';
            $rateRequest->Version->Major = 31;
            $rateRequest->Version->Minor = 0;
            $rateRequest->Version->Intermediate = 0;

            $rateRequest->ReturnTransitAndCommit = true;

            //shipper
            $rateRequest->RequestedShipment->PreferredCurrency = 'USD';
            $rateRequest->RequestedShipment->Shipper->Address->StreetLines = ['3rd Floor - 55 Dundas St East'];
            $rateRequest->RequestedShipment->Shipper->Address->City = 'Toronto';
            $rateRequest->RequestedShipment->Shipper->Address->StateOrProvinceCode = 'ON';
            $rateRequest->RequestedShipment->Shipper->Address->PostalCode = 'M5B1C6';
            $rateRequest->RequestedShipment->Shipper->Address->CountryCode = 'CA';

            //recipient
            $rateRequest->RequestedShipment->Recipient->Address->StreetLines = $account->address_line1;
            $rateRequest->RequestedShipment->Recipient->Address->City = $account->city;
            $rateRequest->RequestedShipment->Recipient->Address->StateOrProvinceCode = $province->abbrev;
            $rateRequest->RequestedShipment->Recipient->Address->PostalCode = $account->postcode;
            $rateRequest->RequestedShipment->Recipient->Address->CountryCode = 'CA';

            //shipping charges payment
            $rateRequest->RequestedShipment->ShippingChargesPayment->PaymentType = SimpleType\PaymentType::_SENDER;

            //rate request types
            $rateRequest->RequestedShipment->RateRequestTypes = [SimpleType\RateRequestType::_PREFERRED, SimpleType\RateRequestType::_LIST];

            $rateRequest->RequestedShipment->PackageCount = 1;
            $RequestedPackageLineItems = array();
            $RequestedPackageLineItems[] = new ComplexType\RequestedPackageLineItem();
            $rateRequest->RequestedShipment->RequestedPackageLineItems = $RequestedPackageLineItems;
            //create package line items
            // $rateRequest->RequestedShipment->RequestedPackageLineItems = [new ComplexType\RequestedPackageLineItem(), new ComplexType\RequestedPackageLineItem()];

            //package 1
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Value = $weight;
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Units = SimpleType\WeightUnits::_LB;
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->Dimensions->Length = $weight->length;
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->Dimensions->Width = $weight->width;
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->Dimensions->Height = $weight->height;
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->Dimensions->Units = SimpleType\LinearUnits::_IN;
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->GroupPackageCount = 1;

            $rateServiceRequest = new Request();
            $rateServiceRequest->getSoapClient()->__setLocation(Request::PRODUCTION_URL); //use production URL

            $rateReply = $rateServiceRequest->getGetRatesReply($rateRequest); // send true as the 2nd argument to return the SoapClient's stdClass response.

            // if (!empty($rateReply->RateReplyDetails)) {
            //     foreach ($rateReply->RateReplyDetails as $rateReplyDetail) {
            //         var_dump($rateReplyDetail->ServiceType);
            //         if (!empty($rateReplyDetail->RatedShipmentDetails)) {
            //             foreach ($rateReplyDetail->RatedShipmentDetails as $ratedShipmentDetail) {
            //                 var_dump($ratedShipmentDetail->ShipmentRateDetail->RateType . ": " . $ratedShipmentDetail->ShipmentRateDetail->TotalNetCharge->Amount);
            //             }
            //         }
            //         echo "<hr />";
            //     }
            // }
            return ($rateReply->RateReplyDetails);
        }
    }
}
