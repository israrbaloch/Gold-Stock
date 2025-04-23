<?php

namespace App\Http\Controllers;

use App\Models\Blog;

class BlogController extends Controller {

    public function index() {
        $blogs = $this->getAll();
        return view('blog.index')->with('blogs', $blogs);
    }

    function getBlogView($slug) {
        $blog = $this->getBySlug($slug);
        if ($blog === null) {
            return redirect('/blog');
        }
        return view('blog.blog', ['blog' => $blog]);
    }

    private function getAll() {
        $blogs = Blog::where('disabled', '=', 0)->orderBy('id', 'DESC')->limit(10)->get();
        return $blogs;
    }

    private function getBySlug($slug) {
        $blog = Blog::where('disabled', '=', 0)
            ->where('slug', '=', $slug)
            ->first();
        return $blog;
    }
}
