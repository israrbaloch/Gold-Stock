<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreSEORequest;
use App\Http\Requests\UpdateSEORequest;
use App\Models\Blog;
use App\Models\HomeNew;
use App\Models\Product;
use App\Models\SEO;
use Cache;
use Illuminate\Support\Facades\Route;
use Log;
use Request;

class SEOController extends Controller {

    private static $except = [
        'arrilot',
        '_dusk',
        'test',
        'admin',
        'robots',
        'anet',
        'password',
        'email/verify',
        'subscription',
        'cart/quantity',
    ];

    public function index() {
        $routes = Route::getRoutes()->getRoutes();

        $routes = self::filterRoutes($routes);

        $seos = SEO::all();

        return view('admin.seo.index')
            ->with('routes', $routes)
            ->with('seos', $seos);
    }

    public function indexProducts() {
        $products = Product::all();

        $routes = [];
        foreach ($products as $product) {
            $routes[] = (object) [
                'uri' => 'product/' . $product->id . '/' . $product->url_name,
            ];
        }

        $seos = SEO::all();

        return view('admin.seo.index')
            ->with('routes', $routes)
            ->with('seos', $seos);
    }

    public function indexBlogs() {
        $blogs = Blog::all();

        $routes = [];
        foreach ($blogs as $blog) {
            $routes[] = (object) [
                'uri' => 'blog/' . $blog->slug,
            ];
        }

        $seos = SEO::all();

        return view('admin.seo.index')
            ->with('routes', $routes)
            ->with('seos', $seos);
    }

    public function indexNews() {
        $news = HomeNew::all();

        $routes = [];
        foreach ($news as $new) {
            $routes[] = (object) [
                'uri' => 'news/' . $new->slug,
            ];
        }

        $seos = SEO::all();

        return view('admin.seo.index')
            ->with('routes', $routes)
            ->with('seos', $seos);
    }

    private static function filterRoutes($routes) {
        // filter the routes array
        $except = self::$except;
        $routes = array_filter($routes, function ($route) use ($except) {
            $uri = $route->uri;
            // check contains
            foreach ($except as $e) {
                if (strpos($uri, $e) !== false) {
                    return false;
                }
            }
            return true;
        });

        // filter get routes
        $routes = array_filter($routes, function ($route) {
            return in_array('GET', $route->methods);
        });

        // filter routes with '/{'
        $routes = array_filter($routes, function ($route) {
            return strpos($route->uri, '/{') === false;
        });

        // order by uri
        usort($routes, function ($a, $b) {
            return strcmp($a->uri, $b->uri);
        });

        return $routes;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('seo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSEORequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSEORequest $request) {
        Log::debug($request);
        Log::debug($request->validated());


        $seo = SEO::where('uri', $request->uri)->first();
        if (!$seo) {
            $seo = new SEO([
                'uri' => $request->uri,
                'title' => $request->title,
                'description' => $request->description,
            ]);
            $seo->save();
        } else {
            $seo->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);
        }


        Cache::forget('site_meta_seo_' . $request->uri);
        return redirect()->route('voyager.seos.edit.uri', ['uri' => $request->uri]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SEO  $seo
     * @return \Illuminate\Http\Response
     */
    public function show(SEO $seo) {
        return view('seo.show', compact('keyword'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SEO  $seo
     * @return \Illuminate\Http\Response
     */
    public function edit(SEO $seo) {
        Log::debug($seo);
        return view('admin.seo.edit')->with('seo', $seo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editURI() {
        // get the uri from query parameter
        $uri = Request::query('uri');
        Log::debug($uri);
        $seo = SEO::where('uri', $uri)->first();

        if (!$seo) {
            $seo = new SEO([
                'uri' => $uri,
                'title' => '',
                'description' => '',
            ]);
            $seo->save();
        }

        return view('admin.seo.edit')
            ->with('uri', $uri)
            ->with('seo', $seo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSEORequest  $request
     * @param  \App\Models\SEO  $seo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSEORequest $request, SEO $seo) {
        Log::debug($seo);
        $seo->update($request->validated());
        return redirect()->route('voyager.seos.index')->with('success', 'Keyword updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SEO  $seo
     * @return \Illuminate\Http\Response
     */
    public function destroy(SEO $seo) {
        Log::debug($seo);
        $seo->delete();
        Cache::forget('site_meta_seo_' . $seo->uri);
        return response()->json(['success' => 'Keyword deleted successfully.']);
    }
}
