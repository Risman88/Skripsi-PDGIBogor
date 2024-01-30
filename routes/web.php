<?php

use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PanduanController;
use App\Http\Controllers\SlideshowController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ZoomController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ZoomAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\SubmissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('', [HomeController::class, 'index'])->name('home');
Route::get('/tentang-kami', [HomeController::class, 'tentangkami'])->name('tentangkami');
Route::get('/faq', [HomeController::class, 'panduan'])->name('faq');
Route::get('/kontak-kami', [HomeController::class, 'kontak'])->name('kontak');
Route::get('/galeri', [HomeController::class, 'galeri'])->name('galeri');
Route::get('/galeri/{gallery}', [HomeController::class, 'galerishow'])->name('galeri.show');
Route::get('/photo_url/{organisasi}', [ImageController::class, 'photo'])->name('organisasi.photo');
Route::get('/image_url/{slideshowId}', [ImageController::class, 'slideshow'])->name('slideshow.banner');
Route::get('/show-mce/{filename}', [ImageController::class, 'showmce'])->name('show.mce');
Route::get('/show-galleries/{filename}', [ImageController::class, 'showgalleries'])->name('show.galleries');

Route::middleware('auth')->group(function () {
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'updateEmail'])->name('profile.update');
Route::patch('/user/document/update', [ProfileController::class, 'addDocument'])->name('user_document.update');
});
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/users/admin', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'showUserProfile'])->name('users.show');
    Route::get('users/{user}/edit', [UserController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}/profile/update', [UserController::class, 'updateUserProfile'])->name('users.updateProfile');
    Route::put('/users/{user}/document/update', [UserController::class, 'updateUserDocuments'])->name('users.updateDocument');
    Route::delete('users/{user}', [UserController::class, 'deleteUser'])->name('users.delete');
    Route::get('/gambar/scan/{type_id}/{scanFile}/{userId}/{submissionId}', [ImageController::class, 'show'])->name('images.scan');
    Route::get('/surat-keluar/{submission}/surat_keluar', [ImageController::class, 'showSuratKeluar'])->name('submission.surat_keluar');
    Route::get('/dokumen/{userId}/{scanFile}', [ImageController::class, 'showUserDocument'])->name('user_document.show');
    Route::get('/buktipembayaran/{payments}', [ImageController::class, 'showBuktiPembayaran'])->name('payments.buktipembayaran');
    Route::post('/upload-image',  [ImageController::class, 'uploadmce'])->name('upload.mce');
    Route::get('/pengajuan', [SubmissionController::class, 'index'])->name('submission.index');
    Route::get('/pengajuan/admin', [SubmissionController::class, 'indexall'])->name('submission.indexall');
    Route::get('/pengajuan/form/{type_id}', [SubmissionController::class, 'create'])->name('submission.create');
    Route::get('/pengajuan/{type_id}/{id}', [SubmissionController::class, 'show'])->name('submission.show');
    Route::get('/pengajuan/{type_id}/{id}/edit', [SubmissionController::class, 'edit'])->name('submission.edit');
    Route::put('/update-pengajuan/{type_id}/{id}', [SubmissionController::class, 'update'])->name('submission.update');
    Route::post('/pengajuan', [SubmissionController::class, 'store'])->name('submission.store');
    Route::delete('pengajuan/{type_id}/{id}', [SubmissionController::class, 'destroy'])->name('submission.destroy');
    Route::get('/pembayaran/admin', [PaymentsController::class, 'indexall'])->name('payments.indexall');
    Route::get('/pembayaran', [PaymentsController::class, 'index'])->name('payments.index');
    Route::post('/pembayaran/{payment}/upload', [PaymentsController::class, 'upload'])->name('payments.upload');
    Route::patch('/changeStatus/{payment}', [PaymentsController::class, 'changeStatus'])->name('payments.changeStatus');
    Route::post('/pembayaran/bayar-iuran', [PaymentsController::class, 'bayarIuran'])->name('payments.bayar-iuran');
    Route::delete('pembayaran/{payment}', [PaymentsController::class, 'destroy'])->name('payments.destroy');
    Route::get('/zoom/create', [ZoomController::class, 'create'])->name('zoom_meetings.create');
    Route::post('/zoom', [ZoomController::class, 'store'])->name('zoom_meetings.store');
    Route::get('/zoom', [ZoomController::class, 'index'])->name('zoom_meetings.index');
    Route::get('/zoom/admin', [ZoomController::class, 'indexall'])->name('zoom_meetings.indexall');
    Route::get('/zoom/konfirmasi', [ZoomController::class, 'indexKehadiran'])->name('zoom.kehadiran');
    Route::get('/callback', [ZoomAuthController::class, 'handleCallback'])->name('zoom.callback');
    Route::get('/zoom/redirect', [ZoomAuthController::class, 'redirectToProvider'])->name('zoom.redirect');
    Route::patch('zoom_meetings/{zoom_meeting}/status', [ZoomController::class, 'updateAttendanceStatus'])->name('zoom_meetings.status');
    Route::delete('/zoom/{id}', [ZoomController::class, 'delete'])->name('zoom_meetings.delete');
    Route::resource('organisasi', OrganisasiController::class);
    Route::resource('slideshow', SlideshowController::class);
    Route::resource('panduan', PanduanController::class);
    Route::resource('gallery', GalleryController::class);
});

Route::get('/insert-fake-data', function () {
    $faker = Faker\Factory::create();

    for ($i = 0; $i < 10; $i++) {
        DB::table('zoom_meetings')->insert([
            'title' => $faker->sentence,
            'description' => $faker->text,
            'start_time' => Carbon::now()->addDays(rand(1, 30)),
            'duration' => rand(30, 120),
            'link_zoom' => $faker->url,
            'untuk_id' => rand(1, 5),
            'dibuat_oleh' => rand(1, 2),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    return 'Data fake berhasil ditambahkan!';
});

require __DIR__ . '/auth.php';
