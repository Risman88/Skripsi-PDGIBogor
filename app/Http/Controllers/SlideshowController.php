<?php

namespace App\Http\Controllers;

use App\Models\Slideshow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideshowController extends Controller
{

    public function index()
    {
        $slideshows = Slideshow::all();
        return view('slideshows.index', compact('slideshows'));
    }

    public function edit(Slideshow $slideshow)
    {
        return view('slideshows.edit', compact('slideshow'));
    }
    public function update(Request $request, Slideshow $slideshow)
    {
        $request->validate([
            'caption' => 'sometimes|string|max:255',
            'image_url' => 'sometimes|mimes:png,jpg,jpeg|max:1024'
        ]);
        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');

            // Hapus file bukti pembayaran lama dari penyimpanan S3 jika ada
            $oldPath = $slideshow->image_url;
            if (!empty($oldPath)) {
                Storage::disk('s3')->delete($oldPath);
            }

            // Simpan file bukti pembayaran baru ke penyimpanan S3 dengan path yang sesuai
            $path = $file->store("images/banner", 's3');

            $slideshow->image_url = $path;
        }
        $slideshow->caption = $request->input('caption');
        $slideshow->save();

        return redirect()->route('slideshow.index')
            ->with('success', 'Banner berhasil diperbarui.');
    }
}
