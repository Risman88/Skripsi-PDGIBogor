<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Submission;
use App\Models\Payments;
use App\Models\UserDocument;

class ImageController extends Controller
{

    public function show(Request $request, $type_id, $scanFile, $userId, $submissionId)
    {
        $user = Auth::user();

        // Cek apakah pengguna memiliki submission_id yang diberikan
        $hasSubmission = $user->submissions->contains($submissionId);

        // Cek apakah pengguna memiliki peran yang diizinkan
        if ($user->hasRole(['admin', 'bendahara', 'interview']) || $hasSubmission) {
            // Ambil path gambar dari database
            $submission = Submission::find($submissionId);

            switch ($type_id) {
                case 1:
                    $submissionDetail = $submission->submission_anggota;
                    break;
                case 2:
                case 3:
                case 4:
                case 5:
                case 6:
                    $submissionDetail = $submission->submission_izin_praktik;
                    break;
                case 7:
                    $submissionDetail = $submission->submission_ppdgs;
                    break;
                case 8:
                    $submissionDetail = $submission->submission_mutasi;
                    break;
                // Tambahkan case lainnya jika diperlukan
            }

            if ($submissionDetail && isset($submissionDetail->{$scanFile})) {
                $path = $submissionDetail->{$scanFile};

                if (Storage::exists($path)) {
                    $file = Storage::get($path);
                    $type = Storage::mimeType($path);

                    return response($file, 200)->header("Content-Type", $type);
                } else {
                    abort(404, "File not found");
                }
            } else {
                abort(404, "File not found");
            }
        } else {
            abort(403, "Unauthorized access");
        }
    }
    public function showSuratKeluar(Request $request, $submissionId)
    {
        $user = Auth::user();

        // Cek apakah pengguna memiliki submission_id yang diberikan
        $hasSubmission = $user->submissions->contains($submissionId);

        // Cek apakah pengguna memiliki peran yang diizinkan
        if ($user->hasRole(['admin', 'bendahara', 'interview']) || $hasSubmission) {
            // Ambil path gambar dari database
            $submission = Submission::find($submissionId);

            if ($submission && isset($submission->surat_keluar)) {
                $path = $submission->surat_keluar;

                if (Storage::exists($path)) {
                    $file = Storage::get($path);
                    $type = Storage::mimeType($path);

                    return response($file, 200)->header("Content-Type", $type);
                } else {
                    abort(404, "File not found");
                }
            } else {
                abort(404, "File not found");
            }
        } else {
            abort(403, "Unauthorized access");
        }
    }
    public function showUserDocument(Request $request, $userId, $scanFile)
    {
        $user = Auth::user();

        if ($user->hasRole(['admin', 'bendahara', 'interview']) || $user->id == $userId) {
            // Ambil path gambar dari database
            $userDocument = UserDocument::where('user_id', $userId)->first();

            if ($userDocument && isset($userDocument->{$scanFile})) {
                $path = $userDocument->{$scanFile};

                if (Storage::exists($path)) {
                    $file = Storage::get($path);
                    $type = Storage::mimeType($path);

                    return response($file, 200)->header("Content-Type", $type);
                } else {
                    abort(404, "File not found");
                }
            } else {
                abort(404, "File not found");
            }
        } else {
            abort(403, "Unauthorized access");
        }
    }

    public function showBuktiPembayaran(Request $request, $paymentsId)
    {
        $user = Auth::user();

        // Cek apakah pengguna memiliki submission_id yang diberikan
        $hasPayment = $user->payments->contains($paymentsId);

        // Cek apakah pengguna memiliki peran yang diizinkan
        if ($user->hasRole(['admin', 'bendahara', 'interview']) || $hasPayment) {
            // Ambil path gambar dari database
            $payments = Payments::find($paymentsId);

            if ($payments && isset($payments->bukti_pembayaran)) {
                $path = $payments->bukti_pembayaran;

                if (Storage::exists($path)) {
                    $file = Storage::get($path);
                    $type = Storage::mimeType($path);

                    return response($file, 200)->header("Content-Type", $type);
                } else {
                    abort(404, "File not found");
                }
            } else {
                abort(404, "File not found");
            }
        } else {
            abort(403, "Unauthorized access");
        }
    }
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

}
