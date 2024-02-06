<?php

namespace App\Http\Controllers;

use App\Models\Panduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanduanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        if (!Auth::user()->hasAnyRole('admin', 'superadmin')) {
            abort(403, 'Unauthorized access');
        }
        $panduans = Panduan::query()
            ->when($search, function ($query, $search) {
                return $query->where('judul', 'like', '%' . $search . '%');
            })
            ->paginate(10);

        return view('faq.index', compact('panduans'));
    }

    public function create()
    {
        if (!Auth::user()->hasAnyRole('admin', 'superadmin')) {
            abort(403, 'Unauthorized access');
        }
        return view('faq.create');
    }
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
        ]);

        // Membuat instance Panduan
        $panduan = new Panduan;
        $panduan->judul = $request->input('judul');
        $panduan->isi = $request->input('isi');

        // Simpan panduan ke dalam database
        $panduan->save();

        return redirect()->route('panduan.index')
            ->with('success', 'Panduan berhasil ditambahkan.');
    }

    public function edit(Panduan $panduan)
    {
        if (!Auth::user()->hasAnyRole('admin', 'superadmin')) {
            abort(403, 'Unauthorized access');
        }
        return view('faq.edit', compact('panduan'));
    }

    public function update(Request $request, Panduan $panduan)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
        ]);

        $panduan->judul = $request->input('judul');
        $panduan->isi = $request->input('isi');
        $panduan->save();

        return redirect()->route('panduan.index')
            ->with('success', 'Panduan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Cari panduan berdasarkan ID
        $panduan = Panduan::find($id);

        // Jika panduan ditemukan, hapus
        if ($panduan) {
            $panduan->delete();
            return redirect()->route('panduan.index')
                ->with('success', 'Panduan berhasil dihapus.');
        }

        // Jika panduan tidak ditemukan, tampilkan pesan error
        return redirect()->route('panduan.index')
            ->with('error', 'Panduan tidak ditemukan.');
    }
}
