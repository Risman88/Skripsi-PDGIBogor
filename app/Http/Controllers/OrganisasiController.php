<?php

namespace App\Http\Controllers;

use App\Models\Organisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrganisasiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        if (!Auth::user()->hasAnyRole('admin', 'superadmin')) {
            abort(403, 'Unauthorized access');
        }
        $organisasiData = Organisasi::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('jabatan', 'like', '%' . $search . '%');
            })
            ->paginate(10);

        return view('organisasi.index', compact('organisasiData'));
    }

    public function create()
    {
        if (!Auth::user()->hasAnyRole('admin', 'superadmin')) {
            abort(403, 'Unauthorized access');
        }
        return view('organisasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo_url' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
        ]);
        $organisasi = new Organisasi(); // Buat instance model Organisasi

        if ($request->hasFile('photo_url')) {
            $file = $request->file('photo_url');
            $path = $file->store("images/foto", 's3'); // Simpan gambar ke direktori storage
            $organisasi->photo_url = $path;
        }

        $organisasi->nama = $request->input('nama');
        $organisasi->jabatan = $request->input('jabatan');
        $organisasi->posisi = $organisasi->getNextPosition();
        $organisasi->save(); // Simpan data organisasi ke database

        return redirect()->route('organisasi.index')
            ->with('success', 'Data organisasi berhasil ditambahkan.');
    }

    public function edit(Organisasi $organisasi)
    {
        if (!Auth::user()->hasAnyRole('admin', 'superadmin')) {
            abort(403, 'Unauthorized access');
        }
        return view('organisasi.edit', compact('organisasi'));
    }

    public function update(Request $request, Organisasi $organisasi)
    {
        $request->validate([
            'photo_url' => 'sometimes|mimes:png,jpg,jpeg|max:1024',
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'posisi' => 'required|integer|lte:' . Organisasi::max('posisi'),
        ]);
        if ($request->input('posisi') != $organisasi->posisi) {
            $newPosition = $request->input('posisi');

            // Menggeser posisi data lain yang terpengaruh
            if ($newPosition > $organisasi->posisi) {
                Organisasi::where('posisi', '>', $organisasi->posisi)
                    ->where('posisi', '<=', $newPosition)
                    ->decrement('posisi');
            } elseif ($newPosition < $organisasi->posisi) {
                Organisasi::where('posisi', '<', $organisasi->posisi)
                    ->where('posisi', '>=', $newPosition)
                    ->increment('posisi');
            }

            $organisasi->posisi = $newPosition;
        }
        if ($request->hasFile('photo_url')) {
            $file = $request->file('photo_url');
            // Hapus gambar lama dari penyimpanan jika ada
            $oldPath = $organisasi->photo_url;
            if (!empty($oldPath)) {
                Storage::disk('s3')->delete($oldPath);
            }

            // Simpan gambar baru dengan path yang sama
            $path = $file->store("images/foto", 's3');
            $organisasi->photo_url = $path;
        }
        $organisasi->nama = $request->input('nama');
        $organisasi->jabatan = $request->input('jabatan');
        $organisasi->save();

        return redirect()->route('organisasi.index')
            ->with('success', 'Data organisasi berhasil diperbarui.');
    }

    public function destroy(Organisasi $organisasi)
    {
        // Hapus gambar dari penyimpanan jika ada
        if ($organisasi->photo_url && Storage::exists($organisasi->photo_url)) {
            Storage::delete($organisasi->photo_url);
        }

        // Hapus data organisasi dari database
        $organisasi->delete();
        Organisasi::reorderPositions();

        return redirect()->route('organisasi.index')
            ->with('success', 'Data organisasi berhasil dihapus.');
    }
}
