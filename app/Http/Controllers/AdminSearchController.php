<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\HomeNew;
use App\Models\Product;
use App\Models\User;

class AdminSearchController extends Controller {

    function products($search) {
        if (auth()->user()) {
            $products = Product::where('id', $search)
                ->orWhere(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->take(10)
                ->get();
            return response()->json($products);
        } else {
            return redirect("/admin/login");
        }
    }

    function users($search) {
        if (auth()->user()) {
            $users = User::where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
                ->where('subscribed', true)
                ->take(10)
                ->get();
            return response()->json($users);
        } else {
            return redirect("/admin/login");
        }
    }

    function blogs($search) {
        if (auth()->user()) {
            $blogs = Blog::where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            })
                ->take(10)
                ->get();
            return response()->json($blogs);
        } else {
            return redirect("/admin/login");
        }
    }

    function news($search) {
        if (auth()->user()) {
            $news = HomeNew::where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('author', 'like', '%' . $search . '%');
            })
                ->take(10)
                ->get();
            return response()->json($news);
        } else {
            return redirect("/admin/login");
        }
    }
}
