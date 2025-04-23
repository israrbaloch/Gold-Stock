<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreKeywordRequest;
use App\Http\Requests\UpdateKeywordRequest;
use App\Models\Keyword;
use App\Models\SEO;
use Cache;
use Illuminate\Http\Request;

class KeywordController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $keywords = Keyword::all();
        return view('admin.keywords.index')
            ->with('keywords', $keywords);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('keywords.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKeywordRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKeywordRequest $request) {

        $request->validated();

        $seo = SEO::where('uri', $request->uri)->first();
        if (!$seo) {
            throw new \Exception('SEO not found for uri: ' . $request->uri);
        }

        $added = [];
        foreach ($request->keywords as $keyword) {
            // not duplicated
            if (Keyword::where('seo_id', $seo->id)->where('value', $keyword)->exists()) {
                continue;
            }

            $keyword = new Keyword([
                'seo_id' => $seo->id,
                'value' => $keyword,
            ]);
            $keyword->save();
            $added[] = $keyword;
        }

        Cache::forget('site_meta_seo_' . $request->uri);
        return response()->json(['success' => 'Keyword created successfully.', 'added' => $added]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Keyword  $keyword
     * @return \Illuminate\Http\Response
     */
    public function show(Keyword $keyword) {
        return view('keywords.show', compact('keyword'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Keyword  $keyword
     * @return \Illuminate\Http\Response
     */
    public function edit(Keyword $keyword) {
        return view('admin.keywords.edit')->with('keyword', $keyword);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $uri
     * @return \Illuminate\Http\Response
     */
    public function editURI(string $uri) {
        $keywords = Keyword::where('uri', $uri)->get();
        return view('admin.keywords.edit')
            ->with('uri', $uri)
            ->with('keywords', $keywords);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKeywordRequest  $request
     * @param  \App\Models\Keyword  $keyword
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKeywordRequest $request, Keyword $keyword) {
        $keyword->update($request->validated());
        return redirect()->route('keywords.index')->with('success', 'Keyword updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Keyword  $keyword
     * @return \Illuminate\Http\Response
     */
    public function destroy(Keyword $keyword) {
        $keyword->delete();
        Cache::forget('site_meta_seo_' . $keyword->uri);
        return response()->json(['success' => 'Keyword deleted successfully.']);
    }

    public function destroyAll(Request $request) {
        $seo = SEO::where('uri', $request->uri)->first();
        if (!$seo) {
            throw new \Exception('SEO not found for uri: ' . $request->uri);
        }

        $deleted = Keyword::where('seo_id', $seo->id)->delete();
        Cache::forget('site_meta_seo_' . $request->uri);
        return response()->json(['success' => 'All keywords deleted successfully.', 'deleted' => $deleted]);
    }
}
