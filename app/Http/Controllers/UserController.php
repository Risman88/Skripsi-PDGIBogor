<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');
        $showUnpaid = $request->input('show_unpaid'); // Menambahkan input untuk menunjukkan iuran yang belum dibayar

        $roles = Role::all();
        if (!Auth::user()->hasAnyRole('admin', 'interview', 'bendahara', 'superadmin')) {
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
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'superadmin');
            })
            ->when($showUnpaid, function ($query) {
                // Hanya menampilkan yang iuran_until lebih dari tanggal sekarang dan tidak null
                $query->whereNotNull('iuran_until')
                    ->where('iuran_until', '<', now());
            })
            ->paginate(10);

        return view('users.index', compact('users', 'roles'));
    }

    public function showUserProfile(User $user)
    {
        if (!Auth::user()->hasAnyRole('admin', 'interview', 'bendahara', 'superadmin')) {
            abort(403, 'Unauthorized access');
        }
        return view('users.show', compact('user'));
    }

    public function create()
    {
        if (!Auth::user()->hasAnyRole('admin', 'superadmin')) {
            abort(403, 'Unauthorized access');
        }
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // Sesuaikan dengan kebutuhan validasi Anda
            'name' => 'required|string|max:60',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
            'tempat_lahir' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string|max:10',
            'alamat' => 'required|string',
            'handphone' => 'required|string|max:15',
            'iuran_at' => 'required|date',
            'iuran_until' => 'required|date',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'alamat' => $request->alamat,
            'handphone' => $request->handphone,
            'email_verified_at' => now(), // Admin langsung mengonfirmasi verifikasi email
            'iuran_at' => $request->iuran_at,
            'iuran_until' => $request->iuran_until,
        ]);
        dd($user);

        $user->userDocument()->create([]);
        $user->assignRole('anggota');

        // Redirect atau berikan respons sesuai kebutuhan
        return redirect()->route('users.index')->with('success', 'User berhasil dibuat.');
    }

    public function editUser(User $user)
    {
        if (!Auth::user()->hasAnyRole('admin', 'superadmin')) {
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
        if (!Auth::user()->hasAnyRole('admin', 'superadmin')) {
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
        // Proses penyimpanan dokumen pengguna yang diperbarui di S3
        foreach ($scanFiles as $scanFile) {
            if ($request->hasFile($scanFile)) {
                $file = $request->file($scanFile);

                // Hapus gambar lama dari penyimpanan S3 jika ada
                $oldPath = $documentData->{$scanFile};
                if ($oldPath) {
                    Storage::disk('s3')->delete($oldPath);
                }

                // Simpan gambar baru ke penyimpanan S3
                $path = $file->store("documents/{$user->id}/{$scanFile}", 's3');
                $validatedData[$scanFile] = $path;
            }
        }

        $documentData->update($validatedData);

        return redirect()->route('users.edit', $user->id)->with('success', 'Dokumen pengguna berhasil diperbarui.');
    }
    public function deleteUser(User $user)
    {
        // Check if the currently authenticated user has the required role for this action
        if (!Auth::user()->hasRole('superadmin')) {
            abort(403, 'Unauthorized access');
        }

        // Retrieve the user's document data
        $documentData = UserDocument::where('user_id', $user->id)->first();

        // Delete the associated documents from S3 and the database
        $scanFiles = [
            'scan_ktp',
            'scan_kta',
            'scan_s1',
            'scan_s2',
            'scan_drg',
            'scan_drgsp',
            'scan_foto',
        ];

        foreach ($scanFiles as $scanFile) {
            $path = $documentData->{$scanFile};
            if ($path) {
                // Delete the document from S3
                Storage::disk('s3')->delete($path);
            }
        }

        // Delete the document data from the database
        $documentData->delete();

        // Delete the user's profile
        $user->delete();

        // Redirect back to the user list with a success message
        return redirect()->route('users.index')->with('success', 'User and associated documents have been deleted.');
    }
}
