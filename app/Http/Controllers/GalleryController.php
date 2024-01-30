<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        if (!Auth::user()->hasAnyRole('admin', 'superadmin')) {
            abort(403, 'Unauthorized access');
        }
        $galleries = Gallery::query()
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('gallery.index', compact('galleries'));
    }

    public function create()
    {
        if (!Auth::user()->hasAnyRole('admin', 'superadmin')) {
            abort(403, 'Unauthorized access');
        }
        return view('gallery.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        $gallery = Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);
        $firstImage = true; // Flag untuk menandai gambar pertama
        foreach ($request->file('images') as $image) {
            $path = $image->store('images/gallery/' . $gallery->title, 's3');
            $isThumbnail = $firstImage;
            $galleryImage = $gallery->images()->create(['image_path' => $path, 'is_thumbnail' => $isThumbnail]);

            if ($firstImage) {
                // Setelah operasi create, kita pastikan hanya satu gambar yang memiliki is_thumbnail true
                $gallery->images()->where('id', '!=', $galleryImage->id)->update(['is_thumbnail' => false]);
                $firstImage = false;
            }
        }

        return redirect()->route('gallery.index')->with('success', 'Gallery created successfully.');
    }

    public function edit(Gallery $gallery)
    {
        if (!Auth::user()->hasAnyRole('admin', 'superadmin')) {
            abort(403, 'Unauthorized access');
        }
        return view('gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        $gallery->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if ($request->has('remove_images') && is_array($request->remove_images)) {
            foreach ($request->remove_images as $imageId) {
                // Hapus gambar dari database dan penyimpanan
                $image = GalleryImage::find($imageId);
                if ($image) {
                    Storage::disk('s3')->delete($image->image_path);
                    $image->delete();
                }
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images/gallery/' . $gallery->title, 's3');
                $gallery->images()->create(['image_path' => $path]);
            }
        }

        if ($request->has('thumbnail_id')) {
            // Setelah operasi create, kita pastikan hanya satu gambar yang memiliki is_thumbnail true
            $gallery->images()->update(['is_thumbnail' => false]);
            $gallery->images()->find($request->thumbnail_id)->update(['is_thumbnail' => true]);
        }

        return redirect()->route('gallery.index')->with('success', 'Gallery updated successfully.');
    }

    public function destroy(Gallery $gallery)
    {
        foreach ($gallery->images as $image) {
            Storage::disk('s3')->delete($image->image_path);
            $image->delete();
        }

        $gallery->delete();

        return redirect()->route('gallery.index')->with('success', 'Gallery deleted successfully.');
    }
}
