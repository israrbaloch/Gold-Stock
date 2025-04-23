<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminBlogsController extends Controller {

    public function index() {
        if (auth()->user()) {
            $blogs = Blog::orderBy('id', 'desc')->paginate(10);
            return view('admin.blogs.list')->with('blogs', $blogs);
        } else {
            return redirect("/admin/login");
        }
    }

    public function getCreateView() {
        if (auth()->user()) {
            return view('admin.blogs.create');
        } else {
            return redirect("/admin/login");
        }
    }

    function getUpdateView($id) {
        if (auth()->user()) {
            $blog = $this->getById($id);
            return view('admin.blogs.update')->with('blog', $blog);
        } else {
            return redirect("/admin/login");
        }
    }

    // Create Blogs
    public function create(Request $request) {
        if (auth()->user()) {
            try {
                $request->validate([
                    'title' => 'required',
                    'description' => 'required',
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif',
                    'date' => 'required',
                ]);

                $image = $request->file('image');

                if (!file_exists(public_path('images'))) {
                    mkdir(public_path('images'), 0777, true);
                }
                $path = $image->store('images', 'public');

                $blog = new Blog;
                $blog->title = $request->title;
                $blog->description = $request->description;
                // $blog->url = $request->url;
                $blog->image = $path;
                // $blog->author = $request->author;

                // generate slug
                $slug = str_replace(' ', '-', strtolower($request->title));
                $slug = preg_replace('/[^A-Za-z0-9\-]/', '', $slug);
                $slug = substr($slug, 0, 120);
                $blog->slug = $slug;

                $date = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $request->date);
                $blog->date = $date;
                $blog->save();
            } catch (\Throwable $th) {
                Log::error($th);
            }
            return redirect('/admin/blogs');
        } else {
            return redirect("/admin/login");
        }
    }

    // Update Blog
    public function update(Request $request, $id) {
        if (auth()->user()) {
            // Log::info($request->all());

            // disabled
            $disabled = $request->disabled == 'on' ? true : false;

            // dd($request->all());

            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'image' => '',
                'date' => 'required',
                // 'disabled' => 'boolean',
            ]);

            // dd($request->all());

            $blog = $this->getById($id);
            $data = $request->only(['title', 'description', 'url', 'author']);

            // Parse the 'disabled' value to a boolean
            $data['disabled'] = $disabled;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                if (!file_exists(public_path('images'))) {
                    mkdir(public_path('images'), 0777, true);
                }
                $path = $image->store('images', 'public');
                $data['image'] = $path;
            }

            $date = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $request->date);
            $data['date'] = $date;

            // generate slug
            $slug = str_replace(' ', '-', strtolower($request->title));
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', $slug);
            $slug = substr($slug, 0, 120);
            $blog->slug = $slug;

            $blog->update($data);

            return redirect('/admin/blogs/' . $id);
        } else {
            return redirect("/admin/login");
        }
    }

    private function getById($id) {
        if (auth()->user()) {
            $blog = Blog::where('id', '=', $id)
                ->first();
            return $blog;
        } else {
            return redirect("/admin/login");
        }
    }
}
