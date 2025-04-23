<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\ShippingStatus;
use App\Helper\Helper;
use App\Helper\HistoricalHelper;
use App\Mail\OrderProductsModifiedMail;
use App\Mail\OrderShippedMail;
use App\Models\Account;
use App\Models\Currency;
use App\Models\DepositOrder;
use App\Models\DepositOrderPayment;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\Province;
use App\Models\ShippingOption;
use App\Models\Status;
use Illuminate\Http\Request;
use Log;
use Mail;
use Yajra\DataTables\Facades\DataTables;

class AdminProductOrderController extends Controller {

    public function index() {
        // 
        if (!auth()->user()->hasPermission('browse_product_orders')) {
            abort(403, 'You do not have permission to manage Orders');
        }
        // (dd(auth()->user()->permissions));
        // $this->authorize('browse', ProductOrder::class);
        // $productOrders = ProductOrder::orderBy('id', 'desc')->get();
        $shippingStatuses = ShippingStatus::getStatuses();
        $paymentStatuses = OrderStatus::getStatuses();

        return view('admin.orders.products.index', compact('shippingStatuses', 'paymentStatuses'));
    }

    // getProductOrdersData
    public function getProductOrdersData(Request $request)
    {
        if (!auth()->user()->hasPermission('browse_product_orders')) {
            abort(403, 'You do not have permission to manage Orders');
        }
        $sorting_order = $request->input('order.0.dir');

        $search = $request->input('search.value');
        $shipping_status = $request->input('shipping_status'); //array
        $payment_status = $request->input('payment_status'); //array

        if ($sorting_order == 'asc') {
            $sorting_order = 'desc';
        } else {
            $sorting_order = 'asc';
        }
        // Fetch orders
        // $orders = ProductOrder::select([
        //     'id',
        //     'email',
        //     'shipping_option_id',
        //     'shipping_status_id',
        //     'currency_id',
        //     'status_id',
        //     'created_at',
        // ])
        // ->orderBy('id', $sorting_order);

        $orderStatuses = OrderStatus::getStatuses();

        $orders = ProductOrder::query()
        ->when($search, function ($query, $search) {
            return $query->where('id', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->orWhere('first_name', 'like', '%'.$search.'%')
                ->orWhere('last_name', 'like', '%'.$search.'%')
                // join first_name and last_name
                ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ['%'.$search.'%'])
                ->orWhere('created_at', 'like', '%'.$search.'%');
        })
        ->when($shipping_status, function ($query, $shipping_status) {
            return $query->whereIn('shipping_status_id', $shipping_status);
        })
        ->when($payment_status, function ($query, $payment_status) {
            return $query->whereIn('status_id', $payment_status);
        })
        ->orderBy('id', $sorting_order);

        return DataTables::of($orders)
            ->editColumn('id', function ($order) {
                return "<a class='order-link' href='" . route('admin.orders.products.view', $order->id) . "'>{$order->orderid}</a>";
            })
            ->editColumn('shipping_status', function ($order) {

                if ($order->shipping_status_id == 3) {
                    $shiiping_badge = 'warning';
                } elseif ($order->shipping_status_id == 4) {
                    $shiiping_badge = 'success';
                } elseif ($order->shipping_status_id == 5) {
                    $shiiping_badge = 'info';
                } elseif ($order->shipping_status_id == 6) {
                    $shiiping_badge = 'success';
                } else {
                    $shiiping_badge = 'danger';
                }

                $status = $order->shipping_status;
                $statusClass = 'badgeMain badge-'.$shiiping_badge;

                return "<span class='{$statusClass}'>{$status}</span>";
            })
            ->addColumn('shipping_option', function ($order) {
                return $order->shipping_option;
            })
            ->addColumn('shipping_status', function ($order) {
                return $order->shipping_status;
            })
            ->addColumn('currency', function ($order) {
                return $order->currency;
            })
            ->addColumn('payment_status', function ($order) use ($orderStatuses) {
                if (in_array($order->status_id, [4, 5, 15, 17])) {
                    $status_badge = 'success';
                } elseif (in_array($order->status_id, [7, 9, 10, 18])) {
                    $status_badge = 'danger';
                } elseif (in_array($order->status_id, [3, 11, 14])) {
                    $status_badge = 'info';
                } elseif (in_array($order->status_id, [2])) {
                    $status_badge = 'primary';
                } else {
                    $status_badge = 'warning';
                }

                $status = isset($orderStatuses[$order->status_id]) ? $orderStatuses[$order->status_id] : 'N/A';
                $statusClass = 'badge-'.$status_badge;

                // if ($status === 'PAYMENT COMPLETE') {
                //     $status = 'Paid';
                // }else{
                //     $status = 'Pending';
                // }

                return "<span class='badgeMain {$statusClass}'>{$status}</span>";
            })
            ->editColumn('created_at', function ($order) {
                return $order->created_at->format('d M Y h:i a');
            })
            ->rawColumns(['shipping_status', 'payment_status', 'id']) // Allow HTML rendering
            ->make(true);
    }

    // show
    public function show($id) {
        if (!auth()->user()->hasPermission('browse_product_orders')) {
            abort(403, 'You do not have permission to manage Orders');
        }
        $productOrder = ProductOrder::find($id);
        $products = Product::where('in_stock', true)->where('enabled', true)->get();
        $orderStatuses = OrderStatus::getStatuses();
        $shippingOptions = ShippingOption::all();
        $shippingStatuses = ShippingStatus::getStatuses();
        $currencies = Currency::all();
        $orderProducts = $productOrder->products;
//dd($orderProducts);
        $currentProducts = [];
        foreach ($orderProducts as $orderProduct) {
            $product = Product::find($orderProduct->product_id);
//dd($product);
            $product->quantity = $orderProduct->quantity;
            $product->price = $orderProduct->price;
            $currentProducts[] = $product;
        }

        $productOrder = $this->inferProductOrder($productOrder);

        $shippingOption = ShippingOption::find($productOrder->shipping_option_id);

        if ($shippingOption) {
            $shippingFee = $shippingOption->price;
        }else{
            $shippingFee = 0;
        }

        return view('admin.orders.products.show')
            ->with('productOrder', $productOrder)
            ->with('currentProducts', $currentProducts)
            ->with('currencies', $currencies)
            ->with('shippingOptions', $shippingOptions)
            ->with('shippingStatuses', $shippingStatuses)
            ->with('orderStatuses', $orderStatuses)
            ->with('orderProducts', $orderProducts)
            ->with('shippingFee', $shippingFee)
            ->with('products', $products);
    }

    // editOrderCustomerDetails
    public function editOrderCustomerDetails($id) {
        $productOrder = ProductOrder::find($id);
        return view('admin.orders.products.edit-customer-details', compact('productOrder'));
    }

    // updateOrderCustomerDetails
    public function updateOrderCustomerDetails(Request $request, $id) {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $productOrder = ProductOrder::find($id);
        $productOrder->first_name = $request->first_name;
        $productOrder->last_name = $request->last_name;
        $productOrder->email = $request->email;
        $productOrder->phone = $request->phone;

        $productOrder->save();

        return redirect()->route('admin.orders.products.view', $id)->with('success', 'Customer details updated');
    }

    // editShippingAddress
    public function editShippingAddress($id) {
        $productOrder = ProductOrder::find($id);
        return view('admin.orders.products.edit-shipping-address', compact('productOrder'));
    }

    // updateShippingAddress
    public function updateShippingAddress(Request $request, $id) {

        $this->validate($request, [
            'shipping_address_1' => 'required',
            'shipping_city' => 'required',
            'shipping_province' => 'required',
            'shipping_postal_code' => 'required',
        ]);

        $productOrder = ProductOrder::find($id);
        $productOrder->shipping_address_1 = $request->shipping_address_1;
        $productOrder->shipping_address_2 = $request->shipping_address_2;
        $productOrder->shipping_city = $request->shipping_city;
        $productOrder->shipping_country = $request->shipping_country;
        $productOrder->shipping_province = $request->shipping_province;
        $productOrder->shipping_postal_code = $request->shipping_postal_code;

        $productOrder->save();

        return redirect()->route('admin.orders.products.view', $id)->with('success', 'Shipping address updated');
    }

    // editBillingAddress
    public function editBillingAddress($id) {
        $productOrder = ProductOrder::find($id);
        return view('admin.orders.products.edit-billing-address', compact('productOrder'));
    }

    // updateBillingAddress
    public function updateBillingAddress(Request $request, $id) {

        $this->validate($request, [
            'billing_address_1' => 'required',
            'billing_city' => 'required',
            'billing_province' => 'required',
            'billing_postal_code' => 'required',
        ]);

        $productOrder = ProductOrder::find($id);
        $productOrder->billing_address_1 = $request->billing_address_1;
        $productOrder->billing_address_2 = $request->billing_address_2;
        $productOrder->billing_city = $request->billing_city;
        $productOrder->billing_country = $request->billing_country;
        $productOrder->billing_province = $request->billing_province;
        $productOrder->billing_postal_code = $request->billing_postal_code;

        $productOrder->save();

        return redirect()->route('admin.orders.products.view', $id)->with('success', 'Billing address updated');
    }

    // editProductInfo
    public function editProductInfo($id) {
        $productOrder = ProductOrder::find($id);

        $orderStatuses = OrderStatus::getStatuses();
        $shippingOptions = ShippingOption::all();
        $shippingStatuses = ShippingStatus::getStatuses();
        $currencies = Currency::all();

        return view('admin.orders.products.edit-product-info')
            ->with('productOrder', $productOrder)
            ->with('orderStatuses', $orderStatuses)
            ->with('shippingOptions', $shippingOptions)
            ->with('shippingStatuses', $shippingStatuses)
            ->with('currencies', $currencies);
    }

    // updateProductInfo
    public function updateProductInfo(Request $request, $id) {

        // dd($request->all());
        $this->validate($request, [
            'shipping_option' => 'required',
            'shipping_status' => 'required',
            // 'currency' => 'required',
            'status' => 'required',
            'moneris_order_id' => 'required',
            'moneris_ticket'
        ]);

        $productOrder = ProductOrder::find($id);
        $oldStatusId = $productOrder->status_id;

        $productOrder->shipping_option_id = $request->shipping_option;
        $productOrder->shipping_status_id = $request->shipping_status;
        // $currency = Currency::where('code', $request->currency)->first();
        // if ($currency) {
        //     $productOrder->currency_id = $currency->id;
        // }
        $productOrder->status_id = $request->status;

        $productOrder->moneris_order_id = $request->moneris_order_id;
        $productOrder->moneris_ticket = $request->moneris_ticket;

        $productOrder->save();

        Helper::sendProductStatusEmail($productOrder, $oldStatusId);

        return redirect()->route('admin.orders.products.view', $id)->with('success', 'Product info updated');
    }


    // editPaymentInfo
    public function editPaymentInfo($id) {
        $productOrder = ProductOrder::find($id);

        $shippingOption = ShippingOption::find($productOrder->shipping_option_id);

        if ($shippingOption) {
            $shippingFee = $shippingOption->price;
        }else{
            $shippingFee = 0;
        }

        return view('admin.orders.products.edit-payment-info', compact('productOrder', 'shippingFee'));
    }

    // updatePaymentInfo
    public function updatePaymentInfo(Request $request, $id) {

        $this->validate($request, [
            'payed' => 'required',
            // 'total' => 'required',
            // 'deposit' => 'required',
            // 'fee' => 'required',
            // 'outstanding' => 'required',

        ]);

        $productOrder = ProductOrder::find($id);
        $productOrder->payed = $request->payed;
        // $productOrder->total = $request->total;
        // $productOrder->deposit = $request->deposit;
        // $productOrder->fee = $request->fee;
        // $productOrder->outstanding = $request->outstanding;

        $productOrder->save();

        return redirect()->route('admin.orders.products.view', $id)->with('success', 'Payment info updated');
    }

    // getProductDetails
    public function getProductDetails(Request $request) {
        $id = $request->product_id;
        $product = Product::find($id);
        return response()->json($product);
    }

    // editOrderInfo
    public function editOrderInfo($id) {
        $productOrder = ProductOrder::find($id);
        $orderStatuses = OrderStatus::getStatuses();
        $shippingStatuses = ShippingStatus::getStatuses();
        return view('admin.orders.products.edit-order-info', compact('productOrder', 'orderStatuses', 'shippingStatuses'));
    }

    // updateOrderInfo
    public function updateOrderInfo(Request $request, $id) {

        $this->validate($request, [
            'status' => 'required',
            'shipping_status' => 'required',
        ]);

        $productOrder = ProductOrder::find($id);

        $oldStatusId = $productOrder->status_id;
        $productOrder->status_id = $request->status;
        $productOrder->shipping_status_id = $request->shipping_status;

        $productOrder->save();

        Helper::sendProductStatusEmail($productOrder, $oldStatusId);

        return redirect()->route('admin.orders.products.view', $id)->with('success', 'Order info updated');
    }


    // editOrderProducts
    public function editOrderProducts($id) {
        $productOrder = ProductOrder::find($id);
        $products = Product::where('in_stock', true)->where('enabled', true)->get();
        $orderProducts = $productOrder->products;

        $currentProducts = [];
        foreach ($orderProducts as $orderProduct) {
            $product = Product::find($orderProduct->product_id);
            $product->quantity = $orderProduct->quantity;
            $product->price = $orderProduct->price;
            // $product->weight = $orderProduct->weight;
            $currentProducts[] = $product;
        }

        $allProducts = Product::where('in_stock', true)->where('enabled', true)->get();

        return view('admin.orders.products.edit-order-products')
            ->with('productOrder', $productOrder)
            ->with('currentProducts', $currentProducts)
            ->with('allProducts', $allProducts)
            ->with('products', $products);
    }

    // updateOrderProducts
    public function updateOrderProducts(Request $request, $id) {
        // dd($request->all());
        // Validate the request data
        $this->validate($request, [
            'product_ids' => 'required|array',
            'weight' => 'required|array',
            'price' => 'required|array',
            'quantity' => 'required|array',
            'total_price' => 'required|array',
        ]);
    
        $productOrder = ProductOrder::find($id);

        $oldTotal = $productOrder->total;
    
        // Current products associated with the order
        $currentOrderProducts = $productOrder->products;
    
        // Prepare arrays for adding and removing products
        $addProducts = [];
        $removeProducts = [];
    
        // Iterate through current order products to identify updates or removals
        foreach ($currentOrderProducts as $currentOrderProduct) {
            $index = array_search($currentOrderProduct->product_id, $request->product_ids);
    
            if ($index !== false) {
                // Update existing product if necessary
                if (
                    $currentOrderProduct->quantity != $request->quantity[$index] ||
                    $currentOrderProduct->price != $request->price[$index]
                ) {
                    $currentOrderProduct->quantity = $request->quantity[$index];
                    $currentOrderProduct->price = $request->price[$index];
                    $currentOrderProduct->save();
                }
            } else {
                // Mark product for removal if not in the updated list
                $removeProducts[] = $currentOrderProduct;
            }
        }
    
        // Identify new products to add
        foreach ($request->product_ids as $index => $productId) {
            $found = $currentOrderProducts->contains('product_id', $productId);
    
            if (!$found) {
                $addProducts[] = [
                    'product_id' => $productId,
                    'quantity' => $request->quantity[$index],
                    'price' => $request->price[$index],
                    // 'weight' => $request->weight[$index],
                    'total_price' => $request->total_price[$index],
                ];
            }
        }
    
        // Add new products
        foreach ($addProducts as $addProduct) {
            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $productOrder->id;
            $orderProduct->product_id = $addProduct['product_id'];
            $orderProduct->quantity = $addProduct['quantity'];
            $orderProduct->price = $addProduct['price'];
            // $orderProduct->weight = $addProduct['weight'];
            $orderProduct->save();
        }
    
        // Remove products not in the updated list
        foreach ($removeProducts as $removeProduct) {
            $removeProduct->delete();
        }

        $productOrder->total = array_sum($request->total_price);
        $productOrder->update();


        if ($request->has('send_approval')) {
            $productOrder->status_id = OrderStatus::WAITING_FOR_APPROVAL;
            $productOrder->update();
            
            try {
                Mail::to($productOrder->user->email)->send(new OrderProductsModifiedMail($productOrder, $currentOrderProducts, $oldTotal));
            } catch (\Throwable $th) {
                \Log::error($th);
            }
        }
    
        return redirect()->route('admin.orders.products.view', $id)->with('success', 'Order products updated');
    }


    // approveOrder
    public function approveOrder($id) {
        $productOrder = ProductOrder::findOrfail($id);

        if ($productOrder->status_id != OrderStatus::WAITING_FOR_APPROVAL) {
            abort(403, 'This Action is not allowed for this order');
        }
        
        $productOrder->status_id = OrderStatus::MODIFICATION_APPROVED;
        $productOrder->update();

        return redirect()->route('home')->with('review_submit', 'Order Modifications Approved');
    }
    



    // create
    public function create() {
        if (!auth()->user()->hasPermission('browse_product_orders')) {
            abort(403, 'You do not have permission to manage Orders');
        }
        $products = Product::where('in_stock', true)->where('enabled', true)->get();
        $orderStatuses = OrderStatus::getStatuses();
        $shippingOptions = ShippingOption::all();
        $shippingStatuses = ShippingStatus::getStatuses();
        $currencies = Currency::all();

        return view('admin.orders.products.local.create.index')
            ->with('products', $products)
            ->with('orderStatuses', $orderStatuses)
            ->with('shippingOptions', $shippingOptions)
            ->with('shippingStatuses', $shippingStatuses)
            ->with('currencies', $currencies);
    }

    // store
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermission('browse_product_orders')) {
            abort(403, 'You do not have permission to manage Orders');
        }
        // Validate the input
        $validatedData = $request->validate([
            'shipping_option' => 'required|integer',
            'shipping_status' => 'required|integer',
            'currency' => 'required|string',
            'status' => 'required|integer',
            'product_id' => 'required|array',
            'product_id.*' => 'nullable|integer',
            'price' => 'required|array',
            'price.*' => 'nullable|numeric',
            'quantity' => 'required|array',
            'quantity.*' => 'nullable|integer',
            'email' => 'nullable|email',
        ]);
    
        // Create the product order
        $productOrder = new ProductOrder();
        $productOrder->user_id = 1; // Assuming a default user
        $productOrder->shipping_option_id = $request->shipping_option;
        $productOrder->shipping_status_id = $request->shipping_status;
    
        // Find the currency
        $currency = Currency::where('code', $request->currency)->first();
        if ($currency) {
            $productOrder->currency_id = $currency->id;
        } else {
            return back()->withErrors(['currency' => 'Invalid currency code.']);
        }
    
        $productOrder->status_id = $request->status;
        $productOrder->email = $request->email;
    
        // Save shipping and billing information if provided
        $productOrder->shipping_address_1 = $request->shipping_address_1 ?? null;
        $productOrder->shipping_address_2 = $request->shipping_address_2 ?? null;
        $productOrder->shipping_city = $request->shipping_city ?? null;
        $productOrder->shipping_country = $request->shipping_country ?? null;
        $productOrder->shipping_province = $request->shipping_province ?? null;
        $productOrder->shipping_postal_code = $request->shipping_postal_code ?? null;
        $productOrder->billing_address_1 = $request->billing_address_1 ?? null;
        $productOrder->billing_address_2 = $request->billing_address_2 ?? null;
        $productOrder->billing_city = $request->billing_city ?? null;
        $productOrder->billing_country = $request->billing_country ?? null;
        $productOrder->billing_province = $request->billing_province ?? null;
        $productOrder->billing_postal_code = $request->billing_postal_code ?? null;
    
        $productOrder->save();
    
        // Handle product details
        $productIds = $request->product_id;
        $prices = $request->price;
        $quantities = $request->quantity;
    
        // Check for mismatched array lengths
        if (count($productIds) !== count($prices) || count($prices) !== count($quantities)) {
            return back()->withErrors(['products' => 'Product, price, and quantity arrays must have the same length.']);
        }
    
        foreach ($productIds as $index => $productId) {
            // Skip entries with null product IDs
            if (!$productId) {
                continue;
            }
    
            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $productOrder->id;
            $orderProduct->product_id = $productId;
            $orderProduct->quantity = $quantities[$index] ?? 1; // Default to 1 if quantity is missing
            $orderProduct->price = $prices[$index] ?? 0;       // Default to 0 if price is missing
            $orderProduct->currency_id = $currency->id;
            $orderProduct->save();
        }

        $total = 0;
        foreach ($productOrder->products as $product) {
            $total += $product->price * $product->quantity;
        }
        $productOrder->total = $total;
        $productOrder->save();
    

        return redirect()->route('admin.orders.products.view', $productOrder->id)->with('success', 'Order products updated');

    }
    


    public function edit($id) {
        $productOrder = ProductOrder::find($id);
        $products = Product::where('in_stock', true)->where('enabled', true)->get();
        $orderStatuses = OrderStatus::getStatuses();
        $shippingOptions = ShippingOption::all();
        $shippingStatuses = ShippingStatus::getStatuses();
        $currencies = Currency::all();
        $orderProducts = $productOrder->products;

        $currentProducts = [];
        foreach ($orderProducts as $orderProduct) {
            $product = Product::find($orderProduct->product_id);
            $product->quantity = $orderProduct->quantity;
            $product->price = $orderProduct->price;
            $currentProducts[] = $product;
        }

        $productOrder = $this->inferProductOrder($productOrder);

        return view('admin.orders.products.update')
            ->with('productOrder', $productOrder)
            ->with('currentProducts', $currentProducts)
            ->with('currencies', $currencies)
            ->with('shippingOptions', $shippingOptions)
            ->with('shippingStatuses', $shippingStatuses)
            ->with('orderStatuses', $orderStatuses)
            ->with('orderProducts', $orderProducts)
            ->with('products', $products);
    }

    private function inferProductOrder(ProductOrder $productOrder) {
        $account = Account::where('user_id', $productOrder->user_id)->first();
        if ($account) {
            if ($productOrder->first_name == null || $productOrder->first_name == '') {
                $productOrder->first_name = $account->fname;
            }
            if ($productOrder->last_name == null || $productOrder->last_name == '') {
                $productOrder->last_name = $account->lname;
            }
            if ($productOrder->email == null || $productOrder->email == '') {
                $productOrder->email = $account->email;
            }
            if ($productOrder->phone == null || $productOrder->phone == '') {
                $productOrder->phone = $account->phone;
            }

            if ($productOrder->shipping_address_1 == null || $productOrder->shipping_address_1 == '') {
                $productOrder->shipping_address_1 = $account->address_line1;
            }
            // $productOrder->shipping_address_2 = $account->address_line2;
            if ($productOrder->shipping_city == null || $productOrder->shipping_city == '') {
                $productOrder->shipping_city = $account->city;
            }
            // $productOrder->shipping_country = $account->country;
            if ($productOrder->shipping_province == null || $productOrder->shipping_province == '') {
                $productOrder->shipping_province = Province::where('id', $account->province_id)->first()->name;
            }
            if ($productOrder->shipping_postal_code == null || $productOrder->shipping_postal_code == '') {
                $productOrder->shipping_postal_code = $account->post_code;
            }

            if ($productOrder->billing_address_1 == null || $productOrder->billing_address_1 == '') {
                $productOrder->billing_address_1 = $account->address_line1;
            }
            // $productOrder->billing_address_2 = $account->address_line2;
            if ($productOrder->billing_city == null || $productOrder->billing_city == '') {
                $productOrder->billing_city = $account->city;
            }
            // $productOrder->billing_country = $account->country;
            if ($productOrder->billing_province == null || $productOrder->billing_province == '') {
                $productOrder->billing_province = Province::where('id', $account->province_id)->first()->name;
            }
            if ($productOrder->billing_postal_code == null || $productOrder->billing_postal_code == '') {
                $productOrder->billing_postal_code = $account->post_code;
            }

            if ($productOrder->payed == null || $productOrder->payed == 0) {
                $depositOrder = DepositOrder::where('order_id', $productOrder->id)->first();
                if ($depositOrder) {
                    $depositOrderPayment = DepositOrderPayment::where('deposit_order_id', $depositOrder->id)->first();
                    if ($depositOrderPayment) {
                        $productOrder->payed = $depositOrderPayment->value + floor($depositOrderPayment->value * 0.0375 * 100) / 100;
                    }
                }
            }
        }
        return $productOrder;
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'shippingOption' => 'required',
            'shippingStatus' => 'required',
            'currency' => 'required',
            'status' => 'required',
            'products' => 'required',
        ]);

        $productOrder = ProductOrder::find($id);
        $productOrder->shipping_option_id = $request->shippingOption;
        $productOrder->shipping_status_id = $request->shippingStatus;
        $currency = Currency::where('code', $request->currency)->first();
        if ($currency) {
            $productOrder->currency_id = $currency->id;
        }
        $productOrder->status_id = $request->status;
        $productOrder->first_name = $request->first_name;
        $productOrder->last_name = $request->last_name;
        $productOrder->email = $request->email;
        $productOrder->phone = $request->phone;
        $productOrder->shipping_address_1 = $request->shipping_address_1;
        $productOrder->shipping_address_2 = $request->shipping_address_2;
        $productOrder->shipping_city = $request->shipping_city;
        $productOrder->shipping_country = $request->shipping_country;
        $productOrder->shipping_province = $request->shipping_province;
        $productOrder->shipping_postal_code = $request->shipping_postal_code;
        $productOrder->billing_address_1 = $request->billing_address_1;
        $productOrder->billing_address_2 = $request->billing_address_2;
        $productOrder->billing_city = $request->billing_city;
        $productOrder->billing_country = $request->billing_country;
        $productOrder->billing_province = $request->billing_province;
        $productOrder->billing_postal_code = $request->billing_postal_code;

        $productOrder->save();

        $currentOrderProducts = $productOrder->products;
        $products = $request->products;

        $addProducts = [];
        $removeProducts = [];
        foreach ($currentOrderProducts as $currentOrderProduct) {
            $found = false;
            foreach ($products as $product) {
                if ($currentOrderProduct->product_id == $product['id']) {
                    $found = true;
                    if ($currentOrderProduct->quantity != $product['quantity']) {
                        $currentOrderProduct->quantity = $product['quantity'];
                        $currentOrderProduct->save();
                    }
                    if ($currentOrderProduct->price != $product['price']) {
                        $currentOrderProduct->price = $product['price'];
                        $currentOrderProduct->save();
                    }
                    break;
                }
            }
            if (!$found) {
                $removeProducts[] = $currentOrderProduct;
            }
        }

        foreach ($products as $product) {
            $found = false;
            foreach ($currentOrderProducts as $currentOrderProduct) {
                if ($currentOrderProduct->product_id == $product['id']) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $addProducts[] = $product;
            }
        }

        foreach ($addProducts as $addProduct) {
            $product = Product::find($addProduct['id']);
            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $productOrder->id;
            $orderProduct->product_id = $addProduct['id'];
            $orderProduct->quantity = $addProduct['quantity'];

            $orderProduct->price = $addProduct['price'];
            $orderProduct->currency_id = $currency->id;
            Log::info($orderProduct);
            $orderProduct->save();
        }

        foreach ($removeProducts as $removeProduct) {
            $removeProduct->delete();
        }

        return response()->json(['message' => 'Product updated']);
    }
}
