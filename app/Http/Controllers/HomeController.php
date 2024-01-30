<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Panduan;
use App\Models\Slideshow;
use App\Models\Organisasi;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $slideshows = Slideshow::all();
        return view('home.index', compact('slideshows'));
    }

    public function tentangkami()
    {
        $organisasi = Organisasi::orderBy('posisi')->get();
        return view('home.tentangkami', compact('organisasi'));
    }

    public function kontak()
    {
        return view('home.kontak-kami');
    }

    public function panduan()
    {
        $panduans = Panduan::paginate(10); // Ganti dengan query sesuai kebutuhan Anda

        return view('home.panduan', compact('panduans'));
    }

    public function galeri()
    {
        $galleries = Gallery::latest()->paginate(8);

        return view('home.galeri', compact('galleries'));
    }
    public function galerishow(Gallery $gallery)
    {
        // Mengambil semua gambar galeri dengan paginate
        $images = $gallery->images()->paginate(8);

        return view('home.galerishow', compact('gallery', 'images'));
    }
    // Tambahkan metode lain sesuai kebutuhan Anda
}
