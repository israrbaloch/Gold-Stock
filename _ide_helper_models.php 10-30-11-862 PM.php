<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Account
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $last_ip_address
 * @property string|null $address_line1
 * @property string|null $fname
 * @property string|null $lname
 * @property string|null $city
 * @property string|null $phone
 * @property string|null $postcode
 * @property int|null $province_id
 * @property string|null $last_login_time
 * @property string|null $identification
 * @property int $verification_status
 * @property string|null $upload_id_date
 * @property-read mixed $balances
 * @property-read mixed $email
 * @property-read mixed $has_email
 * @property-read mixed $has_google
 * @property-read mixed $name_for_admins
 * @property-read mixed $orders
 * @method static \Illuminate\Database\Eloquent\Builder|Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account query()
 * @method static \Illuminate\Database\Eloquent\Builder|Account unique()
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereAddressLine1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereFname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereIdentification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereLastIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereLastLoginTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereLname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereUploadIdDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereVerificationStatus($value)
 */
	class Account extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AdditionalPercent
 *
 * @property int $id
 * @property float $percent
 * @property string $type
 * @property string $sign
 * @property string $edited_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalPercent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalPercent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalPercent query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalPercent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalPercent whereEditedTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalPercent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalPercent wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalPercent whereSign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalPercent whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalPercent whereUpdatedAt($value)
 */
	class AdditionalPercent extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Alert
 *
 * @property int $id
 * @property string $content
 * @property string $display
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Alert newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Alert newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Alert query()
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereUpdatedAt($value)
 */
	class Alert extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Blog
 *
 * @property int $id
 * @property string $title
 * @property string|null $slug
 * @property string $description
 * @property string $image
 * @property bool $disabled
 * @property \Illuminate\Support\Carbon $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $timestamp
 * @method static \Database\Factories\BlogFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog query()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereDisabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereUpdatedAt($value)
 */
	class Blog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CashDeposit
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $currency_id
 * @property float|null $value
 * @property int|null $status_id
 * @property int|null $payment_method_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read mixed $currency
 * @property-read mixed $date
 * @property-read mixed $email
 * @property-read mixed $has_fee
 * @property-read mixed $mode
 * @property-read mixed $payment_method
 * @property-read mixed $product
 * @property-read mixed $status
 * @property-read mixed $type
 * @method static \Illuminate\Database\Eloquent\Builder|CashDeposit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashDeposit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashDeposit query()
 * @method static \Illuminate\Database\Eloquent\Builder|CashDeposit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashDeposit whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashDeposit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashDeposit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashDeposit wherePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashDeposit whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashDeposit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashDeposit whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashDeposit whereValue($value)
 */
	class CashDeposit extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CashWithdrawal
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $currency_id
 * @property float|null $value
 * @property int|null $order_id
 * @property int|null $metal_order_id
 * @property int|null $payment_method_id
 * @property int|null $status_id
 * @property string|null $bank_name
 * @property string|null $bank_address
 * @property string|null $account_number
 * @property string|null $institution_number
 * @property string|null $transit_number
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read mixed $currency
 * @property-read mixed $date
 * @property-read mixed $email
 * @property-read mixed $mode
 * @property-read mixed $payment_method
 * @property-read mixed $product
 * @property-read mixed $product_order
 * @property-read mixed $status
 * @property-read mixed $type
 * @method static \Illuminate\Database\Eloquent\Builder|CashWithdrawal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashWithdrawal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashWithdrawal query()
 * @method static \Illuminate\Database\Eloquent\Builder|CashWithdrawal whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashWithdrawal whereBankAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashWithdrawal whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashWithdrawal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashWithdrawal whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashWithdrawal whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashWithdrawal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashWithdrawal whereInstitutionNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashWithdrawal whereMetalOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashWithdrawal whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashWithdrawal wherePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashWithdrawal whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashWithdrawal whereTransitNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashWithdrawal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashWithdrawal whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashWithdrawal whereValue($value)
 */
	class CashWithdrawal extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Currency
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency query()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereUpdatedAt($value)
 */
	class Currency extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DepositOrder
 *
 * @property int $id
 * @property string $order_type
 * @property int $order_id
 * @property string $table_name
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $date
 * @property-read mixed $fedex_id
 * @property-read mixed $order_payments
 * @method static \Illuminate\Database\Eloquent\Builder|DepositOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DepositOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DepositOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|DepositOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepositOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepositOrder whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepositOrder whereOrderType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepositOrder whereTableName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepositOrder whereUpdatedAt($value)
 */
	class DepositOrder extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DepositOrderPayment
 *
 * @property int $id
 * @property int|null $deposit_order_id
 * @property int|null $currency_id
 * @property float|null $value
 * @property int|null $payment_method_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $date
 * @property-read mixed $order
 * @method static \Illuminate\Database\Eloquent\Builder|DepositOrderPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DepositOrderPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DepositOrderPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|DepositOrderPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepositOrderPayment whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepositOrderPayment whereDepositOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepositOrderPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepositOrderPayment wherePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepositOrderPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepositOrderPayment whereValue($value)
 */
	class DepositOrderPayment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Fedex
 *
 * @property int $id
 * @property int $order_id
 * @property string $service
 * @property float $price
 * @property string $currency
 * @property string|null $tracking_number
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $date_confirmed
 * @method static \Illuminate\Database\Eloquent\Builder|Fedex newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fedex newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fedex query()
 * @method static \Illuminate\Database\Eloquent\Builder|Fedex whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fedex whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fedex whereDateConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fedex whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fedex whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fedex wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fedex whereService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fedex whereTrackingNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fedex whereUpdatedAt($value)
 */
	class Fedex extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HTGold15M
 *
 * @property int $timestamp_id
 * @property string $open
 * @property string $high
 * @property string $low
 * @property string $close
 * @property bool $market_open
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold15M newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold15M newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold15M query()
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold15M whereClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold15M whereHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold15M whereLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold15M whereMarketOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold15M whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold15M whereTimestampId($value)
 */
	class HTGold15M extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HTGold1D
 *
 * @property int $timestamp_id
 * @property string $open
 * @property string $high
 * @property string $low
 * @property string $close
 * @property bool $market_open
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1D newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1D newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1D query()
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1D whereClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1D whereHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1D whereLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1D whereMarketOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1D whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1D whereTimestampId($value)
 */
	class HTGold1D extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HTGold1H
 *
 * @property int $timestamp_id
 * @property string $open
 * @property string $high
 * @property string $low
 * @property string $close
 * @property bool $market_open
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1H newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1H newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1H query()
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1H whereClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1H whereHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1H whereLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1H whereMarketOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1H whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1H whereTimestampId($value)
 */
	class HTGold1H extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HTGold1M
 *
 * @property int $timestamp_id
 * @property string $open
 * @property string $high
 * @property string $low
 * @property string $close
 * @property bool $market_open
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1M newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1M newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1M query()
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1M whereClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1M whereHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1M whereLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1M whereMarketOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1M whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold1M whereTimestampId($value)
 */
	class HTGold1M extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HTGold5M
 *
 * @property int $timestamp_id
 * @property string $open
 * @property string $high
 * @property string $low
 * @property string $close
 * @property bool $market_open
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold5M newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold5M newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold5M query()
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold5M whereClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold5M whereHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold5M whereLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold5M whereMarketOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold5M whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTGold5M whereTimestampId($value)
 */
	class HTGold5M extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HTModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|HTModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTModel query()
 */
	class HTModel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HTPalladium15M
 *
 * @property int $timestamp_id
 * @property string $open
 * @property string $high
 * @property string $low
 * @property string $close
 * @property bool $market_open
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium15M newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium15M newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium15M query()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium15M whereClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium15M whereHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium15M whereLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium15M whereMarketOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium15M whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium15M whereTimestampId($value)
 */
	class HTPalladium15M extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HTPalladium1D
 *
 * @property int $timestamp_id
 * @property string $open
 * @property string $high
 * @property string $low
 * @property string $close
 * @property bool $market_open
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1D newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1D newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1D query()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1D whereClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1D whereHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1D whereLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1D whereMarketOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1D whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1D whereTimestampId($value)
 */
	class HTPalladium1D extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HTPalladium1H
 *
 * @property int $timestamp_id
 * @property string $open
 * @property string $high
 * @property string $low
 * @property string $close
 * @property bool $market_open
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1H newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1H newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1H query()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1H whereClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1H whereHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1H whereLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1H whereMarketOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1H whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1H whereTimestampId($value)
 */
	class HTPalladium1H extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HTPalladium1M
 *
 * @property int $timestamp_id
 * @property string $open
 * @property string $high
 * @property string $low
 * @property string $close
 * @property bool $market_open
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1M newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1M newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1M query()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1M whereClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1M whereHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1M whereLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1M whereMarketOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1M whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium1M whereTimestampId($value)
 */
	class HTPalladium1M extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HTPalladium5M
 *
 * @property int $timestamp_id
 * @property string $open
 * @property string $high
 * @property string $low
 * @property string $close
 * @property bool $market_open
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium5M newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium5M newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium5M query()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium5M whereClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium5M whereHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium5M whereLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium5M whereMarketOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium5M whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPalladium5M whereTimestampId($value)
 */
	class HTPalladium5M extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HTPlatinum15M
 *
 * @property int $timestamp_id
 * @property string $open
 * @property string $high
 * @property string $low
 * @property string $close
 * @property bool $market_open
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum15M newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum15M newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum15M query()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum15M whereClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum15M whereHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum15M whereLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum15M whereMarketOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum15M whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum15M whereTimestampId($value)
 */
	class HTPlatinum15M extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HTPlatinum1D
 *
 * @property int $timestamp_id
 * @property string $open
 * @property string $high
 * @property string $low
 * @property string $close
 * @property bool $market_open
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1D newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1D newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1D query()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1D whereClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1D whereHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1D whereLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1D whereMarketOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1D whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1D whereTimestampId($value)
 */
	class HTPlatinum1D extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HTPlatinum1H
 *
 * @property int $timestamp_id
 * @property string $open
 * @property string $high
 * @property string $low
 * @property string $close
 * @property bool $market_open
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1H newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1H newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1H query()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1H whereClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1H whereHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1H whereLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1H whereMarketOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1H whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1H whereTimestampId($value)
 */
	class HTPlatinum1H extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HTPlatinum1M
 *
 * @property int $timestamp_id
 * @property string $open
 * @property string $high
 * @property string $low
 * @property string $close
 * @property bool $market_open
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1M newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1M newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1M query()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1M whereClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1M whereHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1M whereLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1M whereMarketOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1M whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum1M whereTimestampId($value)
 */
	class HTPlatinum1M extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HTPlatinum5M
 *
 * @property int $timestamp_id
 * @property string $open
 * @property string $high
 * @property string $low
 * @property string $close
 * @property bool $market_open
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum5M newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum5M newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum5M query()
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum5M whereClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum5M whereHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum5M whereLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum5M whereMarketOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum5M whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTPlatinum5M whereTimestampId($value)
 */
	class HTPlatinum5M extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HTSilver15M
 *
 * @property int $timestamp_id
 * @property string $open
 * @property string $high
 * @property string $low
 * @property string $close
 * @property bool $market_open
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver15M newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver15M newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver15M query()
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver15M whereClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver15M whereHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver15M whereLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver15M whereMarketOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver15M whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver15M whereTimestampId($value)
 */
	class HTSilver15M extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HTSilver1D
 *
 * @property int $timestamp_id
 * @property string $open
 * @property string $high
 * @property string $low
 * @property string $close
 * @property bool $market_open
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1D newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1D newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1D query()
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1D whereClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1D whereHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1D whereLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1D whereMarketOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1D whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1D whereTimestampId($value)
 */
	class HTSilver1D extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HTSilver1H
 *
 * @property int $timestamp_id
 * @property string $open
 * @property string $high
 * @property string $low
 * @property string $close
 * @property bool $market_open
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1H newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1H newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1H query()
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1H whereClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1H whereHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1H whereLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1H whereMarketOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1H whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1H whereTimestampId($value)
 */
	class HTSilver1H extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HTSilver1M
 *
 * @property int $timestamp_id
 * @property string $open
 * @property string $high
 * @property string $low
 * @property string $close
 * @property bool $market_open
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1M newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1M newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1M query()
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1M whereClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1M whereHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1M whereLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1M whereMarketOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1M whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver1M whereTimestampId($value)
 */
	class HTSilver1M extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HTSilver5M
 *
 * @property int $timestamp_id
 * @property string $open
 * @property string $high
 * @property string $low
 * @property string $close
 * @property bool $market_open
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver5M newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver5M newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver5M query()
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver5M whereClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver5M whereHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver5M whereLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver5M whereMarketOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver5M whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HTSilver5M whereTimestampId($value)
 */
	class HTSilver5M extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HomeNew
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $slug
 * @property string|null $description
 * @property string|null $url
 * @property string|null $image
 * @property string|null $author
 * @property \Illuminate\Support\Carbon|null $date
 * @property \Illuminate\Support\Carbon|null $timestamp
 * @property bool $disabled
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|HomeNew newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HomeNew newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HomeNew query()
 * @method static \Illuminate\Database\Eloquent\Builder|HomeNew whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeNew whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeNew whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeNew whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeNew whereDisabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeNew whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeNew whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeNew whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeNew whereTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeNew whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeNew whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeNew whereUrl($value)
 */
	class HomeNew extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Identification
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $file
 * @property int $verified
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Identification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Identification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Identification query()
 * @method static \Illuminate\Database\Eloquent\Builder|Identification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Identification whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Identification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Identification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Identification whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Identification whereVerified($value)
 */
	class Identification extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Keyword
 *
 * @property int $id
 * @property int $seo_id
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SEO $seo
 * @method static \Database\Factories\KeywordFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword query()
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereSeoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Keyword whereValue($value)
 */
	class Keyword extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LoginSecurity
 *
 * @property int $id
 * @property int $user_id
 * @property int $google2fa_enable
 * @property string|null $google2fa_secret
 * @property int $email2fa_enable
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|LoginSecurity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginSecurity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginSecurity query()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginSecurity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginSecurity whereEmail2faEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginSecurity whereGoogle2faEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginSecurity whereGoogle2faSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginSecurity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginSecurity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginSecurity whereUserId($value)
 */
	class LoginSecurity extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MailTemplate
 *
 * @property int $id
 * @property string $subject
 * @property string $template
 * @property string|null $subscription
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MailTemplateProperty> $properties
 * @property-read int|null $properties_count
 * @method static \Database\Factories\MailTemplateFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|MailTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|MailTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailTemplate whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailTemplate whereSubscription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailTemplate whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailTemplate whereUpdatedAt($value)
 */
	class MailTemplate extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MailTemplateProperty
 *
 * @property int $id
 * @property int $mail_template_id
 * @property string $name
 * @property string $type
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MailTemplate $mailTemplate
 * @method static \Database\Factories\MailTemplatePropertyFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|MailTemplateProperty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailTemplateProperty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailTemplateProperty query()
 * @method static \Illuminate\Database\Eloquent\Builder|MailTemplateProperty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailTemplateProperty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailTemplateProperty whereMailTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailTemplateProperty whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailTemplateProperty whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailTemplateProperty whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailTemplateProperty whereValue($value)
 */
	class MailTemplateProperty extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Metal
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property float|null $buy_premium
 * @property float|null $bprofit
 * @property float|null $sell_premium
 * @property float|null $sprofit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read mixed $real_price
 * @method static \Illuminate\Database\Eloquent\Builder|Metal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Metal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Metal query()
 * @method static \Illuminate\Database\Eloquent\Builder|Metal whereBprofit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metal whereBuyPremium($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metal whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metal whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metal whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metal whereSellPremium($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metal whereSprofit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metal whereUpdatedAt($value)
 */
	class Metal extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MetalDeposit
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $metal_id
 * @property float|null $oz
 * @property int|null $method_payment_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $status_id
 * @property-read mixed $currency
 * @property-read mixed $date
 * @property-read mixed $email
 * @property-read mixed $has_fee
 * @property-read mixed $metal
 * @property-read mixed $metal_name
 * @property-read mixed $mode
 * @property-read mixed $payment_method
 * @property-read mixed $product
 * @property-read mixed $status
 * @property-read mixed $type
 * @method static \Illuminate\Database\Eloquent\Builder|MetalDeposit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MetalDeposit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MetalDeposit query()
 * @method static \Illuminate\Database\Eloquent\Builder|MetalDeposit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalDeposit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalDeposit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalDeposit whereMetalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalDeposit whereMethodPaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalDeposit whereOz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalDeposit whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalDeposit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalDeposit whereUserId($value)
 */
	class MetalDeposit extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MetalOrder
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $metal_id
 * @property float|null $quantity_oz
 * @property float|null $price_per_oz
 * @property string|null $notes
 * @property int $by_admin
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $currency_id
 * @property string|null $deleted_at
 * @property int|null $status_id
 * @property int|null $created_by
 * @property string|null $fee
 * @property-read mixed $currency
 * @property-read mixed $date
 * @property-read mixed $email
 * @property-read mixed $fedex_details
 * @property-read mixed $has_fee
 * @property-read \App\Models\Metal $metal
 * @property-read mixed $metal_name
 * @property-read mixed $mtp
 * @property-read mixed $nameuser
 * @property-read mixed $order_type
 * @property-read mixed $orderid
 * @property-read mixed $paid
 * @property-read mixed $paid_fee
 * @property-read mixed $payment_status
 * @property-read mixed $payments
 * @property-read mixed $priceproduct
 * @property-read \App\Models\Metal $product
 * @property-read mixed $quantity
 * @property-read mixed $shipping
 * @property-read mixed $shipping_option
 * @property-read mixed $shipping_status
 * @property-read mixed $status
 * @property-read mixed $subtotal
 * @property-read mixed $type
 * @method static \Illuminate\Database\Eloquent\Builder|MetalOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MetalOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MetalOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|MetalOrder whereByAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalOrder whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalOrder whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalOrder whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalOrder whereFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalOrder whereMetalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalOrder whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalOrder wherePricePerOz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalOrder whereQuantityOz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalOrder whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalOrder whereUserId($value)
 */
	class MetalOrder extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MetalWithdrawal
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $metal_id
 * @property float|null $oz
 * @property int|null $order_id
 * @property int|null $method_payment_id
 * @property int|null $status_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $metal_order_id
 * @property-read mixed $currency
 * @property-read mixed $date
 * @property-read mixed $email
 * @property-read mixed $metal_name
 * @property-read mixed $mode
 * @property-read mixed $payment_method
 * @property-read mixed $product
 * @property-read mixed $product_order
 * @property-read mixed $status
 * @property-read mixed $type
 * @method static \Illuminate\Database\Eloquent\Builder|MetalWithdrawal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MetalWithdrawal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MetalWithdrawal query()
 * @method static \Illuminate\Database\Eloquent\Builder|MetalWithdrawal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalWithdrawal whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalWithdrawal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalWithdrawal whereMetalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalWithdrawal whereMetalOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalWithdrawal whereMethodPaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalWithdrawal whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalWithdrawal whereOz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalWithdrawal whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalWithdrawal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetalWithdrawal whereUserId($value)
 */
	class MetalWithdrawal extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\NewsBar
 *
 * @method static \Illuminate\Database\Eloquent\Builder|NewsBar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsBar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsBar query()
 */
	class NewsBar extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderProduct
 *
 * @property int $id
 * @property int|null $order_id
 * @property int|null $product_id
 * @property int|null $quantity
 * @property float|null $price
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $currency_id
 * @property-read mixed $name
 * @property-read mixed $product
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereUpdatedAt($value)
 */
	class OrderProduct extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PaymentMethod
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereUpdatedAt($value)
 */
	class PaymentMethod extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string|null $sku
 * @property string|null $type
 * @property string|null $description
 * @property int $metal_id
 * @property float|null $price
 * @property float|null $physical_price
 * @property string $images
 * @property string|null $backup_images
 * @property string|null $tags
 * @property float|null $percent_interval_1
 * @property float|null $percent_interval_2
 * @property float|null $percent_interval_3
 * @property float|null $percent_interval_4
 * @property int|null $shop_position
 * @property string|null $weight
 * @property string|null $purity
 * @property string|null $producer
 * @property bool|null $in_stock
 * @property bool $enabled
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read mixed $image
 * @property-read mixed $metal_name
 * @property-read mixed $real_price
 * @property-read mixed $url_name
 * @property-read mixed $weight_oz
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read int|null $reviews_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBackupImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereInStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMetalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePercentInterval1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePercentInterval2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePercentInterval3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePercentInterval4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePhysicalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProducer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePurity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereShopPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWeight($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductOrder
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $payment_method
 * @property int|null $shipping_option_id
 * @property int|null $shipping_status_id
 * @property string|null $notes
 * @property int $by_admin
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $currency_id
 * @property int|null $status_id
 * @property int|null $created_by
 * @property string|null $fee
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $shipping_address_1
 * @property string|null $shipping_address_2
 * @property string|null $shipping_city
 * @property string|null $shipping_country
 * @property string|null $shipping_province
 * @property string|null $shipping_postal_code
 * @property string|null $billing_address_1
 * @property string|null $billing_address_2
 * @property string|null $billing_city
 * @property string|null $billing_country
 * @property string|null $billing_province
 * @property string|null $billing_postal_code
 * @property string $payed
 * @property string $total
 * @property string|null $promo_code
 * @property string $promo_code_discount
 * @property string|null $moneris_order_id
 * @property string|null $moneris_ticket
 * @property-read mixed $currency
 * @property-read mixed $date
 * @property-read mixed $fedex_details
 * @property-read mixed $fedex_price
 * @property-read mixed $has_fee
 * @property-read mixed $metal_id
 * @property-read mixed $mtp
 * @property-read mixed $nameuser
 * @property-read mixed $order_type
 * @property-read mixed $orderid
 * @property-read mixed $paid
 * @property-read mixed $paid_fee
 * @property-read mixed $payment_status
 * @property-read mixed $payments
 * @property-read mixed $priceproduct
 * @property-read mixed $product
 * @property-read mixed $products
 * @property-read mixed $quantity
 * @property-read mixed $shipping
 * @property-read mixed $shipping_option
 * @property-read mixed $shipping_status
 * @property-read mixed $status
 * @property-read mixed $subtotal
 * @property-read mixed $type
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read int|null $reviews_count
 * @property-read \App\Models\ShippingOption|null $shippingOption
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereBillingAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereBillingAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereBillingCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereBillingCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereBillingPostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereBillingProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereByAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereMonerisOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereMonerisTicket($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder wherePayed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder wherePromoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder wherePromoCodeDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereShippingAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereShippingAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereShippingCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereShippingCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereShippingOptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereShippingPostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereShippingProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereShippingStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductOrder whereUserId($value)
 */
	class ProductOrder extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PromoCode
 *
 * @property int $id
 * @property string $code
 * @property string $discount_type
 * @property string $discount
 * @property \Illuminate\Support\Carbon|null $valid_from
 * @property \Illuminate\Support\Carbon|null $valid_until
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode query()
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereValidFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereValidUntil($value)
 */
	class PromoCode extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Province
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $abbrev
 * @method static \Illuminate\Database\Eloquent\Builder|Province newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Province newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Province query()
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereAbbrev($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereName($value)
 */
	class Province extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Review
 *
 * @property int $id
 * @property int $order_id
 * @property int $user_id
 * @property int $product_id
 * @property int $rating Rating from 1 to 5
 * @property string|null $review
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review query()
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereReview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereUserId($value)
 */
	class Review extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SEO
 *
 * @property int $id
 * @property string $uri
 * @property string|null $title
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Keyword> $keywords
 * @property-read int|null $keywords_count
 * @method static \Database\Factories\SEOFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|SEO newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SEO newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SEO query()
 * @method static \Illuminate\Database\Eloquent\Builder|SEO whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SEO whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SEO whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SEO whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SEO whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SEO whereUri($value)
 */
	class SEO extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Scheduler
 *
 * @property int $id
 * @property int $template_id
 * @property \Illuminate\Support\Carbon $scheduled_at
 * @property string $status
 * @property string|null $type
 * @property int|null $subscription_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $selectedUsers
 * @property-read int|null $selected_users_count
 * @property-read \App\Models\Subscription|null $subscription
 * @property-read \App\Models\MailTemplate $template
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SchedulerUser> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\SchedulerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Scheduler newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Scheduler newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Scheduler query()
 * @method static \Illuminate\Database\Eloquent\Builder|Scheduler whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scheduler whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scheduler whereScheduledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scheduler whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scheduler whereSubscriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scheduler whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scheduler whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scheduler whereUpdatedAt($value)
 */
	class Scheduler extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SchedulerSelectedUser
 *
 * @property int $id
 * @property int $scheduler_id
 * @property int $user_id
 * @property bool $sent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Scheduler $scheduler
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\SchedulerSelectedUserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulerSelectedUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulerSelectedUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulerSelectedUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulerSelectedUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulerSelectedUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulerSelectedUser whereSchedulerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulerSelectedUser whereSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulerSelectedUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulerSelectedUser whereUserId($value)
 */
	class SchedulerSelectedUser extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SchedulerUser
 *
 * @property int $id
 * @property int $scheduler_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $sent_at
 * @property string $status
 * @property int $attempts
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Scheduler $scheduler
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\SchedulerUserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulerUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulerUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulerUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulerUser whereAttempts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulerUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulerUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulerUser whereSchedulerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulerUser whereSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulerUser whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulerUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulerUser whereUserId($value)
 */
	class SchedulerUser extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShippingOption
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property float $price
 * @property float $free_from
 * @property bool $show_address
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingOption byadmin()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingOption query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingOption whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingOption whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingOption whereFreeFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingOption whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingOption wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingOption whereShowAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingOption whereUpdatedAt($value)
 */
	class ShippingOption extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SliderItems
 *
 * @property int $id
 * @property string|null $link
 * @property string|null $image
 * @property string|null $image_css
 * @property string|null $image_link
 * @property string|null $text
 * @property string|null $text_css
 * @property string|null $text_link
 * @property string|null $button
 * @property string|null $button_css
 * @property string|null $button_link
 * @property string|null $slider_name
 * @property int|null $is_desktop
 * @property int|null $is_mobile
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SliderItems newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SliderItems newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SliderItems query()
 * @method static \Illuminate\Database\Eloquent\Builder|SliderItems whereButton($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderItems whereButtonCss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderItems whereButtonLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderItems whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderItems whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderItems whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderItems whereImageCss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderItems whereImageLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderItems whereIsDesktop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderItems whereIsMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderItems whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderItems whereSliderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderItems whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderItems whereTextCss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderItems whereTextLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderItems whereUpdatedAt($value)
 */
	class SliderItems extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Status
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Status newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Status newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Status query()
 * @method static \Illuminate\Database\Eloquent\Builder|Status shipping()
 * @method static \Illuminate\Database\Eloquent\Builder|Status transaction()
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereUpdatedAt($value)
 */
	class Status extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Subscription
 *
 * @property int $id
 * @property string $email
 * @property bool $subscribed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\SubscriptionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereSubscribed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereUpdatedAt($value)
 */
	class Subscription extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SubscriptionList
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SubscriptionListUser> $subscriptionListUsers
 * @property-read int|null $subscription_list_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\SubscriptionListFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionList query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionList whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionList whereUpdatedAt($value)
 */
	class SubscriptionList extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SubscriptionListUser
 *
 * @property int $id
 * @property int $subscription_list_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SubscriptionList $subscriptionList
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\SubscriptionListUserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionListUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionListUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionListUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionListUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionListUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionListUser whereSubscriptionListId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionListUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionListUser whereUserId($value)
 */
	class SubscriptionListUser extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property int $role_id
 * @property string $name
 * @property string $email
 * @property bool $subscribed
 * @property bool $news_subscribed
 * @property bool $blogs_subscribed
 * @property bool $promo_subscribed
 * @property string|null $name_for_admins
 * @property string|null $avatar
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $settings
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $account_number
 * @property-read mixed $balances
 * @property-read mixed $has_email
 * @property-read mixed $has_google
 * @property mixed $locale
 * @property-read \App\Models\LoginSecurity|null $loginSecurity
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \TCG\Voyager\Models\Role $role
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \TCG\Voyager\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBlogsSubscribed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNameForAdmins($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNewsSubscribed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePromoSubscribed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSubscribed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

namespace App\Models{
/**
 * App\Models\UserCode
 *
 * @property int $id
 * @property int $user_id
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCode query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCode whereUserId($value)
 */
	class UserCode extends \Eloquent {}
}

