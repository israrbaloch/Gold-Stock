<?php

namespace App\Http\Controllers;

use App\Models\Metal;
use App\Models\Product;
use App\Models\SliderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class ProductsController extends Controller {
    function getView() {
        $params = array();
        $params['type'] = (request()->has('type')) ? request()->type : null;
        $params['metal'] = (request()->has('metal')) ? request()->metal : null;
        $params['weight'] = (request()->has('weight')) ? request()->weight : null;
        // in-stock
        $params['in_stock'] = (request()->has('in-stock')) ? request()->get('in-stock') : null;
        $params['producer'] = (request()->has('producer')) ? request()->producer : null;

        $params['sort'] = (request()->has('sort')) ? request()->sort : null;

        $userId = Auth::check() ? Auth::id() : 0;
        if ($params['sort'] == 'price-asc' || $params['sort'] == 'price-desc') {
            $products = $this->_getProductsSorted($params);
        } else {
            $products = $this->_getProducts($params);
        }

        // dd($products);

        $currency = Cookie::get('currency');
        $metalTypes = $this->_getMetalTypes();
        $slides = $this->_getSlides();
        $weights = $this->_getWeights();
        return view('shop.index')
            ->with('products', $products)
            ->with('slides', $slides)
            ->with('body_class', 'shop')
            ->with('metal_types', $metalTypes)
            ->with('weights', $weights)
            ->with('currency', $currency)
            ->with('userId', $userId);
    }

    private function _getProducts($params = null) {
        $products = Product::query();
        if ($params['sort'] == '') {
            $products->orderBy('shop_position')->orderBy('id');
        }
        $products->where('enabled', true);
        // $products->where('in_stock', true);
        if ($params['metal']) {
            $metals = explode('-', $params['metal']);
            $products->whereIn('metal_id', $metals);
        }
        if ($params['weight']) {
            $allWeights = explode('-', $params['weight']);
            $weights = str_replace("_", "/", $allWeights);
            $products->whereIn('weight', $weights);
        }
        if ($params['type']) {
            $products->where('type', $params['type']);
        }
        if ($params['in_stock'] == 1) {
            $products->where('in_stock', true);
        }
        if ($params['in_stock'] === '0') {
            $products->where('in_stock', false);
        }
        if ($params['producer'] && $params['producer'] != null) {
            $products->where('producer', 'like', '%' . $params['producer'] . '%');
        }

        // sort
        if ($params['sort'] == 'price-asc') {
            $products->orderBy('price');
        }

        if ($params['sort'] == 'price-desc') {
            $products->orderByDesc('price');
        }

        // dd($params);

        return $products->paginate(16)->withQueryString();
    }

    private function _getProductsSorted($params = null) {
        // Start query
        $products = Product::query();
    
        if (empty($params['sort'])) {
            $products->orderBy('shop_position')->orderBy('id');
        }
    
        $products->where('enabled', true);
    
        // Filter by metal
        if (!empty($params['metal'])) {
            $metals = explode('-', $params['metal']);
            $products->whereIn('metal_id', $metals);
        }
    
        // Filter by weight
        if (!empty($params['weight'])) {
            $allWeights = explode('-', $params['weight']);
            $weights = str_replace("_", "/", $allWeights);
            $products->whereIn('weight', $weights);
        }
    
        // Filter by type
        if (!empty($params['type'])) {
            $products->where('type', $params['type']);
        }
    
        // Filter by stock
        if (isset($params['in_stock'])) {
            $products->where('in_stock', $params['in_stock']);
        }
    
        // Filter by producer
        if (!empty($params['producer'])) {
            $products->where('producer', 'like', '%' . $params['producer'] . '%');
        }
    
        // Get all products
        $products = $products->get();
    
        // Sort by real_price
        if (!empty($params['sort'])) {
            $products = $params['sort'] === 'price-asc'
                ? $products->sortBy('real_price')
                : ($params['sort'] === 'price-desc' ? $products->sortByDesc('real_price') : $products);
        }
    
        // Paginate the sorted collection
        $perPage = 16;
        $currentPage = request()->input('page', 1);
        $paginatedProducts = new \Illuminate\Pagination\LengthAwarePaginator(
            $products->forPage($currentPage, $perPage),
            $products->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    
        return $paginatedProducts;
    }
    


    private function _getWeights() {
        $products = Product::where('in_stock', true)->where('enabled', true)->get();
        $allWeights = array();
        foreach ($products as $product) {
            $allWeights[] = $product->weight;
        }
        return array_unique($allWeights);
    }

    private function _getMetalTypes() {
        $metalTypes = Metal::get();
        return $metalTypes;
    }

    private function _getSlides() {
        $desktop_slides = SliderItems::where('slider_name', 'shop')->get();
        return $desktop_slides;
    }

    private function _getMobileSlides() {
        $mobile_slides = SliderItems::get();
        return $mobile_slides;
    }

    public function getSingleProduct(Request $request) {
        $userId = Auth::check() ? Auth::id() : 0;
        $product = Product::find($request->id);

        
        // $product = Product::find($request->id)->toArray();

        $relatedProducts = Product::where('metal_id', $product['metal_id'])
            ->where('id', '!=', $product['id'])
            ->where('enabled', true)
            ->where('in_stock', true)
            ->limit(8)
            ->get();
        return view('product.index')
            ->with('product', $product)
            ->with('userId', $userId)
            ->with('relatedProducts', $relatedProducts);
    }

    function addProduct(Request $request) {
        $images = "";
        if ($request->is_edit) {
            $product = Product::where('id', $request->id)
                ->where('enabled', true)
                ->where('in_stock', true)
                ->first();
            $i = 1;
            if (count($request->oldimages) > 0) {
                foreach ($request->oldimages as $oldImage) {
                    $images .= $oldImage;
                    $i < count($request->oldimages) ? $images .= ',' :  $images .= '';
                    $i++;
                }
                $request->images && count($request->images) > 0 ? $images .= ',' : $images .= '';
            }
        } else {
            $product = new Product();
        }
        if ($request->images && count($request->images)) {
            $i = 1;
            foreach ($request->images as $image) {
                $images .= '/img/products/';
                $images .= $image->getClientOriginalName();
                $i < count($request->images) ? $images .= ',' : $images .= '';
                $i++;
                $destinationPath = 'img/products';
                if (!$image->move($destinationPath, $image->getClientOriginalName())) {
                    return 'Error saving the file.';
                }
            }
        }

        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->type = $request->type;
        $product->metal_id = $request->metal_id;
        $product->price = $request->price;
        $product->physical_price = $request->physical_price;
        $product->images = $images;
        $product->tags = $request->tags;
        $product->percent_interval_1 = $request->percent_interval_1;
        $product->percent_interval_2 = $request->percent_interval_2;
        $product->percent_interval_3 = $request->percent_interval_3;
        $product->percent_interval_4 = $request->percent_interval_4;
        $product->shop_position = $request->shop_position;
        $product->weight = $request->weight;
        $product->purity = $request->purity;
        $product->producer = $request->producer;
        $product->in_stock = $request->in_stock;
        $product->enabled = $request->enabled == "on" ? "1" : "0";
        $product->status = $request->status;
        $product->created_at = $request->created_at;
        $product->updated_at = $request->updated_at;
        $product->deleted_at = $request->deleted_at;

        $product->save();
        return redirect('/admin/products');
    }
}
