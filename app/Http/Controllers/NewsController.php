<?php

namespace App\Http\Controllers;

use App\Models\HomeNew;

class NewsController extends Controller {
    function index() {
        $news = $this->getAll();
        // recent news
        $recentNews = HomeNew::where('disabled', '=', 0)->limit(4)->get();
        
        return view('news.index')->with('news', $news)->with('recentNews', $recentNews);
    }

    function getNewView($slug) {
        $new = $this->getBySlug($slug);
        if ($new === null) {
            return redirect('/news');
        }
        return view('news.new', ['new' => $new]);
    }

    private function getAll() {
        $news = HomeNew::where('disabled', '=', 0)->orderBy('id', 'DESC')->limit(10)->get();
        return $news;
    }

    private function getBySlug($slug) {
        $new = HomeNew::where('disabled', '=', 0)
            ->where('slug', '=', $slug)
            ->first();
        return $new;
    }
}
