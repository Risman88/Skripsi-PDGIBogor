<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');

        $roles = Role::all();
        if (!Auth::user()->hasAnyRole('admin', 'interview', 'bendahara')) {
            abort(403, 'Unauthorized access');
        }
        $users = User::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->when($role, function ($query, $role) {
                return $query->role($role);
            })
            ->paginate(10);

        return view('users.index', compact('users', 'roles'));
    }

    public function showUserProfile(User $user)
    {
        if (!Auth::user()->hasAnyRole('admin', 'interview', 'bendahara')) {
            abort(403, 'Unauthorized access');
        }
        return view('users.show', compact('user'));
    }

    public function editUser(User $user)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized access');
        }
        $roles = Role::all();

        return view('users.edit', compact('user', 'roles'));
    }
    public function updateUserProfile(Request $request, User $user)
    {
        // Validasi input dari form
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|exists:roles,name',
            'email' => ['required', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'handphone' => 'required|string|max:255',
        ]);

        // Memperbarui atribut pengguna
        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'tempat_lahir' => $validatedData['tempat_lahir'],
            'tanggal_lahir' => $validatedData['tanggal_lahir'],
            'jenis_kelamin' => $validatedData['jenis_kelamin'],
            'agama' => $validatedData['agama'],
            'alamat' => $validatedData['alamat'],
            'handphone' => $validatedData['handphone'],
        ]);
        // Memperbarui peran pengguna
        $role = Role::where('name', $validatedData['role'])->first();
        $user->syncRoles([$role]);
        // Redirect kembali ke halaman edit pengguna dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'Informasi pengguna berhasil diperbarui.');
    }

    public function updateUserDocuments(Request $request, User $user)
    {

        $documentData = $user->userDocument;
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized access');
        }
        $validatedData = $request->validate([
            'scan_foto' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
            'scan_drgsp' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
            'scan_ktp' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
            'scan_kta' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
            'scan_s1' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
            'scan_s2' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
            'scan_drg' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
        ]);
        $scanFiles = [
            'scan_ktp',
            'scan_kta',
            'scan_s1',
            'scan_s2',
            'scan_drg',
            'scan_drgsp',
            'scan_foto',
        ];
        // Proses penyimpanan dokumen pengguna yang diperbarui
        foreach ($scanFiles as $scanFile) {
            if ($request->hasFile($scanFile)) {
                $file = $request->file($scanFile);
                // Hapus gambar lama dari penyimpanan jika ada
                $oldPath = $documentData->{$scanFile};
                if ($oldPath && Storage::exists($oldPath)) {
                    Storage::delete($oldPath);
                }

                // Simpan gambar baru dengan path yang sama
                $path = $file->store('public/images/documents/' . $user->id . '/' . $scanFile);
                $validatedData[$scanFile] = $path;
            }
        }
        $documentData->update($validatedData);

        return redirect()->route('users.edit', $user->id)->with('success', 'Dokumen pengguna berhasil diperbarui.');
    }
}
