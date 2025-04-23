<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class OrderProduct extends Model {
    protected $table = "order_products";
    protected $appends = ['name'];

    public function getNameAttribute() {
        $product = DB::table('products')->where('id', $this->product_id)->first();
        return $product ? $product->name : "Product deleted";
    }

    public function getImages() {
        $product = Product::where('id', $this->product_id)
            ->first();
        if ($product) {
            return $product->images;
        }
        return '[]';
    }

    public function getProductAttribute() {
        return Product::where('id', $this->product_id)->first();
    }
}
