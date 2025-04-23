<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class ProductsParseCurrentImages extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('products', function (Blueprint $table) {
            // create backup_images column
            $table->text('backup_images')->nullable()->after('images');
        });
        // copy images to backup_images
        DB::statement('UPDATE products SET backup_images = images');

        // with storage create a storage/products/current folder
        Storage::disk('public')->makeDirectory('products/current');
        // get all products
        $products = DB::table('products')->get();
        // loop through products
        foreach ($products as $product) {
            /*
            * check if is a string splitted by comma or array, if is a string, check in /img/products/ folder
            * 
            */
            $slug = str_replace(' ', '-', strtolower($product->name));
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', $slug);
            $slug = substr($slug, 0, 120);

            $images = json_decode($product->images);

            if (empty($images)) {
                // parse string splitted by comma
                $images = explode(',', $product->images);
                // Log::info($images);
                $newImages = [];

                // loop through images
                foreach ($images as $index => $image) {
                    // check if image exists in /img/products/ folder
                    $publicImagePath = public_path($image);
                    Log::info("Checking: " . $image);
                    if (file_exists($publicImagePath)) {
                        Log::info("Image found: " . $publicImagePath);
                        $path = 'products/current/' . $slug . '-' . $index . '.jpg';

                        // copy image from public/img/ to /storage/products/current folder, set the same name as the product like slug, 
                        Storage::put('public/' . $path, file_get_contents($publicImagePath));

                        // // add new image to newImages array
                        Log::info($path);
                        array_push($newImages, $path);
                    } else {
                        Log::info("Image not found: " . $image);
                    }
                }
                // update product images to format [image1, image2, ...]
                Log::info($newImages);
                DB::table('products')->where('id', $product->id)->update(['images' => $newImages]);
            } else {
                $newImages = [];
                foreach ($images as $index => $image) {
                    // replace \\ with \/
                    $image = str_replace('\\', '/', $image);
                    array_push($newImages, $image);
                }
                DB::table('products')->where('id', $product->id)->update(['images' => $newImages]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('products', function (Blueprint $table) {
            // restore images column
            DB::statement('UPDATE products SET images = backup_images');
            // drop backup_images column
            $table->dropColumn('backup_images');
        });
    }
}
