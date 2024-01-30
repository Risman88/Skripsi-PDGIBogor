<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Gallery;
use App\Models\Payments;
use App\Models\Slideshow;
use App\Models\Organisasi;
use App\Models\Submission;
use App\Models\GalleryImage;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

    public function show(Request $request, $type_id, $scanFile, $userId, $submissionId)
    {
        $user = Auth::user();

        // Cek apakah pengguna memiliki submission_id yang diberikan
        $hasSubmission = $user->submissions->contains($submissionId);

        // Cek apakah pengguna memiliki peran yang diizinkan
        if ($user->hasAnyRole(['admin', 'bendahara', 'interview', 'superadmin']) || $hasSubmission) {
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

                // Check if URL is cached
                $cacheKey = 's3_temp_url_' . md5($path);
                $url = Cache::get($cacheKey);

                if (!$url) {
                    // Generate pre-signed URL with 1-hour expiration
                    $url = Storage::disk('s3')->temporaryUrl($path, now()->addHours(72));

                    // Cache the URL for 1 hour
                    Cache::put($cacheKey, $url, Carbon::now()->addHours(72));
                }

                // Redirect to the pre-signed URL
                return redirect($url);
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
        if ($user->hasAnyRole(['admin', 'bendahara', 'interview', 'super-admin']) || $hasSubmission) {
            // Ambil path gambar dari database
            $submission = Submission::find($submissionId);

            if ($submission && isset($submission->surat_keluar)) {
                $path = $submission->surat_keluar;

                // Check if URL is cached
                $cacheKey = 's3_temp_url_' . md5($path);
                $url = Cache::get($cacheKey);

                if (!$url) {
                    // Generate pre-signed URL with 1-hour expiration
                    $url = Storage::disk('s3')->temporaryUrl($path, now()->addHours(72));

                    // Cache the URL for 1 hour
                    Cache::put($cacheKey, $url, Carbon::now()->addHours(72));
                }

                // Redirect to the pre-signed URL
                return redirect($url);
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

        if ($user->hasAnyRole(['admin', 'bendahara', 'interview', 'superadmin']) || $user->id == $userId) {
            $userDocument = UserDocument::where('user_id', $userId)->first();

            if ($userDocument && isset($userDocument->{$scanFile})) {
                $path = $userDocument->{$scanFile};

                // Check if URL is cached
                $cacheKey = 's3_temp_url_' . md5($path);
                $url = Cache::get($cacheKey);

                if (!$url) {
                    // Generate pre-signed URL with 5-minutes expiration
                    $url = Storage::disk('s3')->temporaryUrl($path, now()->addMinutes(5));

                    // Cache the URL for 5 minutes
                    Cache::put($cacheKey, $url, Carbon::now()->addMinutes(5));
                }

                // Redirect to the pre-signed URL
                return redirect($url);
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
        if ($user->hasAnyRole(['admin', 'bendahara', 'interview', 'superadmin']) || $hasPayment) {
            // Ambil path gambar dari database
            $payment = Payments::find($paymentsId);

            if ($payment && $payment->bukti_pembayaran) {
                $path = $payment->bukti_pembayaran;

                // Check if URL is cached
                $cacheKey = 's3_temp_url_' . md5($path);
                $url = Cache::get($cacheKey);

                if (!$url) {
                    // Generate pre-signed URL with 2-hour expiration
                    $url = Storage::disk('s3')->temporaryUrl($path, now()->addHours(168));

                    // Cache the URL for 2 hours
                    Cache::put($cacheKey, $url, Carbon::now()->addHours(168));
                }

                // Redirect to the pre-signed URL
                return redirect($url);
            } else {
                abort(404, "File not found");
            }
        } else {
            abort(403, "Unauthorized access");
        }
    }
    public function photo(Request $request, $organisasiId)
    {
        $organisasi = Organisasi::find($organisasiId);
        if ($organisasi && $organisasi->photo_url) {
            $path = $organisasi->photo_url;

            // Check if URL is cached
            $cacheKey = 's3_temp_url_' . md5($path);
            $url = Cache::get($cacheKey);

            if (!$url) {
                // Generate pre-signed URL with 2-hour expiration
                $url = Storage::disk('s3')->temporaryUrl($path, now()->addHours(168));

                // Cache the URL for 2 hours
                Cache::put($cacheKey, $url, Carbon::now()->addHours(168));
            }

            // Redirect to the pre-signed URL
            return redirect($url);
        } else {
            abort(404, "File not found");
        }
    }
    public function slideshow(Request $request, $slideshowId)
    {
        $slideshow = Slideshow::find($slideshowId);
        if ($slideshow && $slideshow->image_url) {
            $path = $slideshow->image_url;

            // Check if URL is cached
            $cacheKey = 's3_temp_url_' . md5($path);
            $url = Cache::get($cacheKey);

            if (!$url) {
                // Generate pre-signed URL with 7 days expiration
                $url = Storage::disk('s3')->temporaryUrl($path, now()->addHours(168));

                // Cache the URL for 7 days
                Cache::put($cacheKey, $url, Carbon::now()->addHours(168));
            }

            // Redirect to the pre-signed URL
            return redirect($url);
        } else {
            abort(404, "File not found");
        }
    }
    public function uploadmce(Request $request) {
        $user = Auth::user();
        // Cek apakah pengguna memiliki peran yang diizinkan
        if ($user->hasAnyRole(['admin', 'superadmin'])) {
            // Ambil path gambar dari database
            $image = $request->file('file');
            $path = $image->store("images", 's3'); // Menyimpan gambar ke S3
            $url = str_replace('https://testbucketpdgi.s3.ap-southeast-1.amazonaws.com/images', '', Storage::disk('s3')->url($path));
            return response()->json(['location' => $url]);
            }
            else {
            abort(403, "Unauthorized access");
        }
    }

    public function showmce($filename) {
        $url = Cache::get('presigned_url_' . $filename);

        if (!$url) {
            // Jika tidak ada dalam cache, maka buat URL baru dan simpan dalam cache
            $url = Storage::disk('s3')->temporaryUrl("images/$filename", now()->addHours(168), ['ResponseContentType' => 'image/jpeg']);
            Cache::put('presigned_url_' . $filename, $url,  Carbon::now()->addHours(168)); // Simpan dalam cache
        }

        // Mengarahkan langsung ke URL presigned
        return redirect($url);
    }

    public function showgalleries(Request $request, $galleryimageId)
    {
        $galleryImage = GalleryImage::find($galleryimageId);

        if ($galleryImage && $galleryImage->image_path) {
            $path = $galleryImage->image_path;

            // Check if URL is cached
            $cacheKey = 's3_temp_url_' . md5($path);
            $url = Cache::get($cacheKey);

            if (!$url) {
                // Generate pre-signed URL with 7 days expiration
                $url = Storage::disk('s3')->temporaryUrl($path, now()->addHours(168));

                // Cache the URL for 7 days
                Cache::put($cacheKey, $url, Carbon::now()->addHours(168));
            }

            // Redirect to the pre-signed URL
            return redirect($url);
        } else {
            abort(404, "File not found");
        }
    }
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

}
