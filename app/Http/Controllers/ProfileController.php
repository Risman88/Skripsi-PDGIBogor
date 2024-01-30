<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function updateEmail(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
        }

        $user->save();

        return Redirect::route('profile.edit')->with('success', 'Email berhasil di ubah, silahkan lakukan cek email untuk verifikasi email');
    }

    public function addDocument(Request $request): RedirectResponse
    {
        $user = $request->user();

        $request->validate([
            'scan_kta' => ['sometimes', 'file', 'mimes:pdf,jpeg,png', 'max:1024'],
            'scan_s1' => ['sometimes', 'file', 'mimes:pdf,jpeg,png', 'max:1024'],
            'scan_s2' => ['sometimes', 'file', 'mimes:pdf,jpeg,png', 'max:1024'],
            'scan_drg' => ['sometimes', 'file', 'mimes:pdf,jpeg,png', 'max:1024'],
            'scan_drgsp' => ['sometimes', 'file', 'mimes:pdf,jpeg,png', 'max:1024'],
            'scan_ktp' => ['sometimes', 'file', 'mimes:pdf,jpeg,png', 'max:1024'],
            'scan_foto' => ['sometimes', 'file', 'mimes:jpeg,png', 'max:1024'],
        ]);

        $documentData = [];

        foreach (['scan_kta', 'scan_s1', 'scan_s2', 'scan_drg', 'scan_drgsp', 'scan_ktp', 'scan_foto'] as $key) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $path = 'documents/' . $user->id . '/' . $key;
                $uploadedFile = Storage::disk('s3')->put($path, $file);

                if ($uploadedFile) {
                    $documentData[$key] = $uploadedFile;
                }
            }
        }

        if (count($documentData) > 0) {
            if ($user->userDocument) {
                $user->userDocument->update($documentData);
            } else {
                $user->userDocument()->create($documentData);
            }
        }

        return Redirect::route('profile.edit')->with('success', 'Dokumen berhasil ditambahkan, apabila ada kesalahan unggah hubungi pengurus');
    }


    /*
      Delete the user's account.

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    */
}
