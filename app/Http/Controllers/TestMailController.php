<?php

namespace App\Http\Controllers;

use App\Mail\AdminProductTransactionCompletedMail;
use App\Mail\AdminIdentificationMail;
use App\Mail\AdminMetalTransactionCompletedMail;
use App\Mail\AdminPhysicalConversionMail;
use App\Mail\EmailSupportMail;
use App\Mail\UserChangePasswordMail;
use App\Mail\UserDepositCompletedMail;
use App\Mail\UserDepositConfirmationMail;
use App\Mail\UserMetalTransactionCompletedMail;
use App\Mail\UserPhysicalConversionMail;
use App\Mail\UserProductTransactionCompletedMail;
use App\Mail\UserWelcomeMail;
use App\Mail\UserWithdrawalConfirmationMail;
use App\Models\Account;
use App\Models\Fedex;
use App\Models\MetalOrder;
use App\Models\OrderProduct;
use App\Models\ProductOrder;
use App\Models\ShippingOption;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class TestMailController extends Controller {

    function verifyEmail() {
        $randomString = Str::random(40);
        $url = config('app.url') . "/email/verify/123/" . $randomString;
        return view('emails.user.verify-email', ['url' => $url]);
    }

    function welcome() {
        return new UserWelcomeMail();
    }

    function productTransactionCompleted() {
        // get random products
        $products = OrderProduct::inRandomOrder()->limit(10)->get();
        // get random shipping option
        $shippingOption = ShippingOption::inRandomOrder()->first();
        // get random fedex
        $fedex = Fedex::inRandomOrder()->first();
        // get random account
        $account = Account::inRandomOrder()->first();
        $data = [
            'fname' => 'John',
            'email' => 'johndoe@gmail.com',
            'account_number' => $account->number,
            'address' => $account->address_line1,
            'city' => $account->city,
            'phone' => $account->phone,
            'products' => $products,
            'currency' => 'CAD',
            'total' => rand(100, 200),
            'ordertype' => "Shop",
            'orderid' => rand(1000, 2000),
            'orderDate' => date("Y-m-d", strtotime('-' . rand(1, 365) . ' days')),
            'shippingOption' => $shippingOption,
            // 'fedex_service' => $fedex->name,
            // 'fedex_price' => rand(10, 20),
            'metalOrder' => rand(3000, 4000),
            'pending' => rand(50, 100),
            'due' => rand(50, 100),
            'fee' => rand(5, 10),
            'dueNow' => rand(5, 10),
        ];
        return new UserProductTransactionCompletedMail($data);
    }

    function adminProductTransactionCompleted() {
        // get random products
        $products = OrderProduct::inRandomOrder()->limit(10)->get();
        // get random shipping option
        $shippingOption = ShippingOption::inRandomOrder()->first();
        // get random fedex
        $fedex = Fedex::inRandomOrder()->first();
        // get random account
        $account = Account::inRandomOrder()->first();
        $data = [
            'fname' => 'John',
            'email' => 'johndoe@gmail.com',
            'account_number' => $account->number,
            'address' => $account->address_line1,
            'city' => $account->city,
            'phone' => $account->phone,
            'products' => $products,
            'currency' => 'CAD',
            'totalprice' => rand(100, 200),
            'ordertype' => "Shop",
            'orderid' => rand(1000, 2000),
            'orderDate' => date("Y-m-d", strtotime('-' . rand(1, 365) . ' days')),
            'shippingOption' => $shippingOption,
            // 'fedex_service' => $fedex->name,
            // 'fedex_price' => rand(10, 20),
            'metalOrder' => rand(3000, 4000),
            'pending' => rand(50, 100),
            'due' => rand(50, 100),
            'fee' => rand(5, 10),
            'dueNow' => rand(5, 10),
        ];
        return new AdminProductTransactionCompletedMail($data);
    }

    function metalTransactionCompleted() {
        // get random metal order
        $metalOrder = MetalOrder::inRandomOrder()->first();
        // get random account
        $account = Account::inRandomOrder()->first();
        $data = array(
            'fname' => 'John',
            'email' => 'johndoe@gmail.com',
            'account_number' => $account->number,
            'address' => $account->address_line1,
            'city' => $account->city,
            'phone' => $account->phone,
            'metal' => 'Gold',
            'currency' => 'CAD',
            'totalmetal' => $metalOrder->quantity_oz,
            'price_per_oz' => $metalOrder->price_per_oz,
            'totalprice' => rand(100, 200),
            'ordertype' => "Buy",
            'orderid' => $metalOrder->order_id,
            'orderDate' => date("Y-m-d", strtotime('-' . rand(1, 365) . ' days')),
            'metalOrder' => $metalOrder->id,
            'due' => rand(50, 100),
            'fee' => rand(5, 10),
            'pending' => rand(5, 10),
        );
        return new UserMetalTransactionCompletedMail($data);
    }

    function adminMetalTransactionCompleted() {
        // get random metal order
        $metalOrder = MetalOrder::inRandomOrder()->first();
        // get random account
        $account = Account::inRandomOrder()->first();
        $data = array(
            'fname' => 'John',
            'email' => 'johndoe@gmail.com',
            'account_number' => $account->number,
            'address' => $account->address_line1,
            'city' => $account->city,
            'phone' => $account->phone,
            'metal' => 'Gold',
            'currency' => 'CAD',
            'totalmetal' => $metalOrder->quantity_oz,
            'price_per_oz' => $metalOrder->price_per_oz,
            'totalprice' => rand(100, 200),
            'ordertype' => "Buy",
            'orderid' => $metalOrder->order_id,
            'orderDate' => date("Y-m-d", strtotime('-' . rand(1, 365) . ' days')),
            'metalOrder' => $metalOrder->id,
            'due' => rand(50, 100),
            'fee' => rand(5, 10),
            'pending' => rand(5, 10),
        );
        return new AdminMetalTransactionCompletedMail($data);
    }


    function verification() {
        $data = array(
            'fname' => 'Joen',
            'email' => 'test@gmail.com',
        );
        return new AdminIdentificationMail($data);
    }

    function depositConfirmation() {
        $data = array(
            'fname' => 'Joen',
            'email' => 'test@gmail.com',
            'date' => date("Y-m-d", strtotime('-' . rand(1, 365) . ' days')),
            'ordertype' => 'Cash',
            'curr_or_metal' => 'CAD',
            'total' => rand(100, 200),
        );
        return new UserDepositConfirmationMail($data);
    }
    function depositCompleted() {
        // get random products
        $products = OrderProduct::inRandomOrder()->limit(10)->get();
        // get random account
        $account = Account::inRandomOrder()->first();
        // get random ProductOrder
        $productOrder = ProductOrder::inRandomOrder()->first();
        $data = array(
            'fname' => 'Joen',
            'email' => 'test@gmail.com',
            'account_number' => $account->number,
            'address' => $account->address_line1,
            'city' => $account->city,
            'phone' => $account->phone,
            'products' => $products,
            'currency' => $productOrder->currency,
            'totalprice' => $productOrder->priceproduct,
            'ordertype' => 'Cash',
            'orderid' => $productOrder->order_id,
            'orderDate' => $productOrder->created_at,
            'shippingOption' => $productOrder->shipping_option,
            'fedex_service' => $productOrder->shipping,
            'fedex_price' => $productOrder->fedex_price,
            'metalOrder' => $productOrder->id,
            'pending' => rand(50, 100),
            'due' => rand(50, 100),
            'fee' => rand(5, 10),
        );
        return new UserDepositCompletedMail($data);
    }

    function withdrawalConfirmation() {
        $data = array(
            'fname' => 'Joen',
            'email' => 'test@gmail.com',
            'date' => date("Y-m-d", strtotime('-' . rand(1, 365) . ' days')),
            'ordertype' => 'Cash',
            'curr_or_metal' => 'CAD',
            'total' => rand(100, 200),
        );
        return new UserWithdrawalConfirmationMail($data);
    }

    function physicalConversion() {
        // get random account
        $account = Account::inRandomOrder()->first();
        // get random products
        $products = OrderProduct::inRandomOrder()->limit(10)->get();
        // get random shipping option
        $delivery = ShippingOption::inRandomOrder()->first();
        // get random ProductOrder
        $productOrder = ProductOrder::inRandomOrder()->first();
        $data = array(
            'fname' => 'Joen',
            'email' => 'test@gmail.com',
            'account_number' => $account->number,
            'address' => $account->address_line1,
            'city' => $account->city,
            'phone' => $account->phone,
            'products' => $products,
            'currency' => 'CAD',
            'totalmetal' => rand(100, 200),
            'totalprice' => rand(100, 200),
            'due' => rand(100, 200),
            'delivery'   => $delivery->name,
            'productOrder'   => $productOrder->id
        );
        return new UserPhysicalConversionMail($data);
    }

    function adminPhysicalConversion() {
        // get random account
        $account = Account::inRandomOrder()->first();
        // get random products
        $products = OrderProduct::inRandomOrder()->limit(10)->get();
        // get random shipping option
        $delivery = ShippingOption::inRandomOrder()->first();
        // get random ProductOrder
        $productOrder = ProductOrder::inRandomOrder()->first();
        $data = array(
            'fname' => 'Joen',
            'email' => 'test@gmail.com',
            'account_number' => $account->number,
            'address' => $account->address_line1,
            'city' => $account->city,
            'phone' => $account->phone,
            'products' => $products,
            'currency' => 'CAD',
            'totalmetal' => rand(100, 200),
            'totalprice' => rand(100, 200),
            'due' => rand(100, 200),
            'delivery'   => $delivery->name,
            'productOrder'   => $productOrder->id
        );
        return new AdminPhysicalConversionMail($data);
    }

    function supportMail() {
        $data = array(
            'option' => 'Sales',
            'fname' => 'Joen',
            'lname' => 'Doen',
            'email' => "example@gmail.com",
            'message' =>  'Loremasdsads dasd asd',
        );
        return new EmailSupportMail($data);
    }
    function passwordChange() {
        $randomString = Str::random(40);
        $token = config('app.url') . "/password/reset/" . $randomString;
        $data = array(
            'token' => $token,
        );
        return new UserChangePasswordMail($data);
    }

    function sendAll($pass, $email) {
        if ($pass != "GoldMessage123!") {
            return "Not Valid";
        }
        Mail::to($email)->send($this->welcome());
        Mail::to($email)->send($this->productTransactionCompleted());
        Mail::to($email)->send($this->adminProductTransactionCompleted());
        Mail::to($email)->send($this->metalTransactionCompleted());
        Mail::to($email)->send($this->adminMetalTransactionCompleted());
        Mail::to($email)->send($this->verification());
        Mail::to($email)->send($this->depositConfirmation());
        Mail::to($email)->send($this->depositCompleted());
        Mail::to($email)->send($this->withdrawalConfirmation());
        Mail::to($email)->send($this->physicalConversion());
        Mail::to($email)->send($this->adminPhysicalConversion());
        Mail::to($email)->send($this->supportMail());
        Mail::to($email)->send($this->passwordChange());
    }
}
