<?php

namespace App\Http\Controllers;

use App\Models\HomeNew;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminNews extends Controller {

    function index() {
        if (auth()->user()) {
            $news = HomeNew::orderBy('id', 'desc')->paginate(10);
            return view('admin.news.list')->with('news', $news);
        } else {
            return redirect("/admin/login");
        }
    }

    function getCreateView() {
        if (auth()->user()) {
            return view('admin.news.create');
        } else {
            return redirect("/admin/login");
        }
    }

    function getUpdateView($id) {
        if (auth()->user()) {
            $new = $this->getById($id);
            return view('admin.news.update')->with('new', $new);
        } else {
            return redirect("/admin/login");
        }
    }

    // Create News
    public function create(Request $request) {
        if (auth()->user()) {
            try {
                $request->validate([
                    'title' => 'required',
                    'description' => 'required',
                    'image' => 'required',
                    'date' => 'required',
                ]);

                $image = $request->file('image');

                $path = $image->store('images', 'public');

                $new = new HomeNew;
                $new->title = $request->title;
                $new->description = $request->description;
                // $homeNew->url = $request->url;
                $new->image = $path;
                // $homeNew->author = $request->author;

                // generate slug
                $slug = str_replace(' ', '-', strtolower($request->title));
                $slug = preg_replace('/[^A-Za-z0-9\-]/', '', $slug);
                $slug = substr($slug, 0, 120);
                $new->slug = $slug;

                $date = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $request->date);
                $new->date = $date;
                $new->save();
            } catch (\Throwable $th) {
                Log::error($th);
            }
            return redirect('/admin/news?error=1');
        } else {
            return redirect("/admin/login");
        }
    }

    // Update New
    public function update(Request $request, $id) {
        if (auth()->user()) {
            Log::info($request->all());
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'image' => '',
                'date' => 'required',
                'disabled' => 'boolean',
            ]);

            $new = $this->getById($id);
            $data = $request->only(['title', 'description', 'url', 'author']);

            // Parse the 'disabled' value to a boolean
            $data['disabled'] = filter_var($request->input('disabled'), FILTER_VALIDATE_BOOLEAN);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $path = $image->store('images', 'public');
                $data['image'] = $path;
            }

            $date = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $request->date);
            $data['date'] = $date;

            // generate slug
            $slug = str_replace(' ', '-', strtolower($request->title));
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', $slug);
            $slug = substr($slug, 0, 120);
            $new->slug = $slug;

            $new->update($data);

            return redirect('/admin/news/' . $id);
        } else {
            return redirect("/admin/login");
        }
    }

    private function getById($id) {
        $new = HomeNew::where('id', '=', $id)
            ->first();
        return $new;
    }
}
