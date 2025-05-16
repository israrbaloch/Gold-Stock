<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasPermission('browse_banners')) {
            abort(403, 'You do not have permission to browse banners.');
        }
        // $this->authorize('browse_banners', Banner::class);
        $banners = Banner::latest()->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('add_banners')) {
            abort(403, 'You do not have permission to create banners.');
        }
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasPermission('add_banners')) {
            abort(403, 'You do not have permission to create banners.');
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'type' => 'required|in:image,text,both',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'mobile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|url',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'nullable',
            'position' => 'required|integer',
        ]);

        $validator->after(function ($validator) use ($request) {
            if (!$request->hasFile('image') && !$request->hasFile('mobile_image')) {
                $validator->errors()->add('image', 'Either Banner Image or Mobile Banner Image is required.');
                $validator->errors()->add('mobile_image', 'Either Banner Image or Mobile Banner Image is required.');
            }
        });

        $validator->validate();


        // Upload image
        $imagePath = $request->file('image')->store('banners', 'public');
        $mobImage = $request->file('mobile_image')->store('banners', 'public');

        Banner::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'mobile_image' => $mobImage,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'position' => $request->position,
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully!');
    }

    public function edit(Banner $banner)
    {
        if (!auth()->user()->hasPermission('edit_banners')) {
            abort(403, 'You do not have permission to edit banners.');
        }
        $dataTypeContent = $banner;
        return view('admin.banners.create', compact('dataTypeContent'));
    }

    public function update(Request $request, Banner $banner)
    {
        if (!auth()->user()->hasPermission('edit_banners')) {
            abort(403, 'You do not have permission to edit banners.');
        }
        // dd($request->all());
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'mobile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|url',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'nullable',
            'position' => 'required|integer',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if (Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }
            // Upload new image
            $banner->image = $request->file('image')->store('banners', 'public');
        }

        if ($request->hasFile('mobile_image')) {
            // Delete old image
            if (Storage::disk('public')->exists($banner->mobile_image)) {
                Storage::disk('public')->delete($banner->mobile_image);
            }
            // Upload new image
            $banner->mobile_image = $request->file('mobile_image')->store('banners', 'public');
        }

        $banner->update(
            $request->except('image', 'mobile_image')
        );

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully!');
    }

    public function destroy(Banner $banner)
    {
        if (!auth()->user()->hasPermission('delete_banners')) {
            abort(403, 'You do not have permission to delete banners.');
        }
        if (Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully!');
    }
}
