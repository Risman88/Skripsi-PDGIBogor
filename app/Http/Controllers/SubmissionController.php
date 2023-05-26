<?php

namespace App\Http\Controllers;

use App\Mail\SubmissionCompletedUserNotification;
use App\Mail\SubmissionAnggotaCompletedUserNotification;
use App\Models\User;
use App\Models\UserDocument;
use App\Models\Submission;
use App\Models\Payments;
use Illuminate\Http\Request;
use App\Models\SubmissionPpdgs;
use App\Models\SubmissionMutasi;
use App\Models\SubmissionAnggota;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\SubmissionIzinPraktik;
use Illuminate\Support\Facades\Storage;
use App\Mail\NewSubmissionAdminNotification;
use Illuminate\Support\Facades\Mail;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $submissionsDitolak = Submission::with(['submissionType', 'payment'])
            ->where('user_id', $user->id)
            ->where('status', 'Ditolak')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $submissionsDiproses = Submission::with(['submissionType', 'payment'])
            ->where('user_id', $user->id)
            ->where('status', 'Diproses')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $submissionsSelesai = Submission::with(['submissionType', 'payment'])
            ->where('user_id', $user->id)
            ->where('status', 'Selesai')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('submission.index', compact('submissionsDitolak', 'submissionsDiproses', 'submissionsSelesai'));
    }

    public function indexall(Request $request)
    {
        $user = Auth::user();
        if ($user->hasAnyRole('admin', 'bendahara', 'interview')) {
            $search = $request->input('search');

            $baseQuery = Submission::query()->with(['submissionType', 'payment', 'user'])->orderBy('created_at', 'desc')->orderBy('id', 'desc');

            if ($search) {
                $baseQuery = $baseQuery->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                });
            }

            $submissionsDiproses = clone $baseQuery;
            $submissionsDitolak = clone $baseQuery;
            $submissionsSelesai = clone $baseQuery;

            $submissionsDiproses = $submissionsDiproses->where('status', 'Diproses')->paginate(5, ['*'], 'diproses')->withQueryString();
            $submissionsDitolak = $submissionsDitolak->where('status', 'Ditolak')->paginate(5, ['*'], 'ditolak')->withQueryString();
            $submissionsSelesai = $submissionsSelesai->where('status', 'Selesai')->paginate(5, ['*'], 'selesai')->withQueryString();

            return view('submission.indexall', compact('submissionsDiproses', 'submissionsDitolak', 'submissionsSelesai', 'search'));
        } else {
            abort(403, 'Unauthorized access');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $user, string $type_id)
    {
        $user = Auth::user();
        $submissionType = $type_id;
        $view = '';
        if (!$user->userDocument) {
            return redirect()->route('profile.edit')->with('error', 'Harap unggah dokumen pribadi yang diperlukan.');
        }

        $currentDate = now();

        switch ($submissionType) {
            case 1:
                if (!$user->userDocument->scan_ktp || !$user->userDocument->scan_s1 || !$user->userDocument->scan_drg || !$user->userDocument->scan_foto) {
                    return redirect()->route('profile.edit')->with('error', 'Harap lengkapi dokumen yang diperlukan yaitu KTP, Ijazah S1, Ijazah Profesi dan Foto Diri');
                }

                $view = 'submission.anggota';
                break;
            case 2:
                if (!$user->userDocument->scan_ktp || !$user->userDocument->scan_s1 || !$user->userDocument->scan_drg || !$user->userDocument->scan_foto || !$user->userDocument->scan_kta) {
                    return redirect()->route('profile.edit')->with('error', 'Harap lengkapi dokumen yang diperlukan yaitu KTP, Ijazah S1, Ijazah Profesi, Foto Diri dan KTA');
                }
                $view = 'submission.sripuser';
                break;
            case 3:
                if ($user->iuran_until < $currentDate) {
                    return redirect()->route('payments.index')->with('error', 'Harap lakukan pembayaran iuran terlebih dahulu.');
                }
                if (!$user->userDocument->scan_ktp || !$user->userDocument->scan_s1 || !$user->userDocument->scan_drg || !$user->userDocument->scan_foto || !$user->userDocument->scan_kta) {
                    return redirect()->route('profile.edit')->with('error', 'Harap lengkapi dokumen yang diperlukan yaitu KTP, Ijazah S1, Ijazah Profesi, Foto Diri dan KTA');
                }
                $view = 'submission.srip-anggota-drg';
                break;
            case 4:
                if ($user->iuran_until < $currentDate) {
                    return redirect()->route('payments.index')->with('error', 'Harap lakukan pembayaran iuran terlebih dahulu.');
                }
                if (!$user->userDocument || !$user->userDocument->scan_ktp || !$user->userDocument->scan_s1 || !$user->userDocument->scan_drg || !$user->userDocument->scan_drgsp || !$user->userDocument->scan_foto || !$user->userDocument->scan_kta) {
                    return redirect()->route('profile.edit')->with('error', 'Harap lengkapi dokumen yang diperlukan yaitu KTP, Ijazah S1, Ijazah Profesi, Ijazah Spesialis, Foto Diri dan KTA');
                }
                $view = 'submission.srip-anggota-drg-sp';
                break;
            case 5:
                if ($user->iuran_until < $currentDate) {
                    return redirect()->route('payments.index')->with('error', 'Harap lakukan pembayaran iuran terlebih dahulu.');
                }
                if (!$user->userDocument || !$user->userDocument->scan_ktp || !$user->userDocument->scan_s1 || !$user->userDocument->scan_drg || !$user->userDocument->scan_foto || !$user->userDocument->scan_kta) {
                    return redirect()->route('profile.edit')->with('error', 'Harap lengkapi dokumen yang diperlukan yaitu KTP, Ijazah S1, Ijazah Profesi, Foto Diri dan KTA');
                }
                $view = 'submission.spip-anggota-drg';
                break;
            case 6:
                if ($user->iuran_until < $currentDate) {
                    return redirect()->route('payments.index')->with('error', 'Harap lakukan pembayaran iuran terlebih dahulu.');
                }
                if (!$user->userDocument || !$user->userDocument->scan_ktp || !$user->userDocument->scan_s1 || !$user->userDocument->scan_drg || !$user->userDocument->scan_drgsp || !$user->userDocument->scan_foto || !$user->userDocument->scan_kta) {
                    return redirect()->route('profile.edit')->with('error', 'Harap lengkapi dokumen yang diperlukan yaitu KTP, Ijazah S1, Ijazah Profesi, Ijazah Spesialis, Foto Diri dan KTA');
                }
                $view = 'submission.spip-anggota-drg-sp';
                break;
            case 7:
                if ($user->iuran_until < $currentDate) {
                    return redirect()->route('payments.index')->with('error', 'Harap lakukan pembayaran iuran terlebih dahulu.');
                }
                $view = 'submission.mutasi-anggota';
                break;
            case 8:
                if ($user->iuran_until < $currentDate) {
                    return redirect()->route('payments.index')->with('error', 'Harap lakukan pembayaran iuran terlebih dahulu.');
                }
                $view = 'submission.ppdgs-anggota';
                break;
            default:
                abort(404, 'Halaman tidak ditemukan');
        }
        return view($view, compact('submissionType'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $submissionType = $request->input('submission_type');

        // Buat objek Submission Type berdasarkan tipe submission yang dipilih
        switch ($submissionType) {
            case 1:
                // Validasi data
                $validatedData = $request->validate([
                    'str' => 'required|max:25',
                    'serkom' => 'required|max:25',
                    'cabang_mutasi' => 'nullable|max:40',
                    'scan_str' => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_serkom' => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_mutasi' => 'nullable|mimes:png,jpg,jpeg,pdf|max:1024',
                ]);

                // Membuat submission baru
                $submission = Submission::create([
                    'user_id' => Auth::user()->id,
                    'submission_type_id' => $submissionType,
                    'status' => 'Diproses',
                    'surat_keluar' => null,
                ]);
                $scanFiles = [
                    'scan_serkom',
                    'scan_mutasi',
                    'scan_str',
                ];

                // Menyimpan data untuk Submission Type 1 (Anggota)
                $SubmissionAnggota = new SubmissionAnggota($validatedData);
                foreach ($scanFiles as $scanFile) {
                    if ($request->hasFile($scanFile)) {
                        $file = $request->file($scanFile);
                        $path = $file->store('public/images/' . $scanFile . '/' . $submission->user_id . '/' . $submission->id);
                        $SubmissionAnggota->{$scanFile} = $path;
                    }
                }
                $SubmissionAnggota->submission()->associate($submission);
                $SubmissionAnggota->save();
                // Membuat pembayaran baru
                $paymentAmount = 400000;
                $jenisPembayaran = 'Pengajuan Anggota dan Pembayaran Iuran 1 Tahun dengan ID Pengajuan ' . $submission->id;

                $payment = new Payments([
                    'user_id' => Auth::user()->id,
                    'submission_id' => $submission->id,
                    'jenis_pembayaran' => $jenisPembayaran,
                    'jumlah_pembayaran' => $paymentAmount,
                    'jangka_iuran' => 365,
                    'status' => 'Belum dibayar',
                    'bank_account_id' => 1,
                    'payment_proof' => null,
                ]);

                $payment->save();
                // Kirim email ke admin saat pengajuan baru dibuat
                $admins = User::role('admin')->get();
                foreach ($admins as $admin) {
                    Mail::to($admin->email)->send(new NewSubmissionAdminNotification($submission));
                }
                break;
            case 2:
                // Validasi data yang diterima dari form
                $validatedData = $request->validate([
                    'praktik_ke' => 'required|in:1,2,3',
                    'tujuan_surat' => 'required|in:Pembuatan SIP,Perpanjangan SIP,Pindah Alamat SIP',
                    'alumni_drg' => 'required|max:50',
                    'tahun_lulus' => 'required|numeric|digits:4',
                    'str' => 'required|max:25',
                    'valid_str' => 'required|date',
                    'serkom' => 'required|max:25',
                    'npa' => 'required|max:11',
                    'cabang_pdgi' => 'required|max:40',
                    'alamat_fakes1' => 'nullable',
                    'jadwal_praktik1' => 'nullable',
                    'surat_praktik1' => 'nullable|mimes:png,jpg,jpeg,pdf|max:1024',
                    'alamat_fakes2' => 'nullable',
                    'jadwal_praktik2' => 'nullable',
                    'surat_praktik2' => 'nullable|mimes:png,jpg,jpeg,pdf|max:1024',
                    'alamat_fakes3' => 'nullable',
                    'jadwal_praktik3' => 'nullable',
                    'surat_praktik3' => 'nullable|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_serkom' => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_str' => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_surat_sehat' => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_surat_pengantar' => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_surat_kolegium' => 'nullable|mimes:png,jpg,jpeg,pdf|max:1024',
                ]);
                $scanFiles = [
                    'surat_praktik1',
                    'surat_praktik2',
                    'surat_praktik3',
                    'scan_serkom',
                    'scan_str',
                    'scan_surat_sehat',
                    'scan_surat_pengantar',
                    'scan_surat_kolegium',
                ];

                // Membuat submission baru
                $submission = Submission::create([
                    'user_id' => Auth::user()->id,
                    'submission_type_id' => $submissionType,
                    'status' => 'Diproses',
                    'surat_keluar' => null,
                ]);

                // Menyimpan data untuk Submission Type 2
                $SubmissionIzinPraktik = new SubmissionIzinPraktik($validatedData);
                foreach ($scanFiles as $scanFile) {
                    if ($request->hasFile($scanFile)) {
                        $file = $request->file($scanFile);
                        $path = $file->store('public/images/' . $scanFile . '/' . $submission->user_id . '/' . $submission->id);
                        $SubmissionIzinPraktik->{$scanFile} = $path;
                    }
                }
                $SubmissionIzinPraktik->submission()->associate($submission);
                $SubmissionIzinPraktik->save();
                // Membuat pembayaran baru
                $paymentAmount = 400000;
                $jenisPembayaran = 'Pengajuan Surat Rekomendasi Izin Praktik-NonAnggota dengan ID Pengajuan ' . $submission->id;

                $payment = new Payments([
                    'user_id' => Auth::user()->id,
                    'submission_id' => $submission->id,
                    'jenis_pembayaran' => $jenisPembayaran,
                    'jumlah_pembayaran' => $paymentAmount,
                    'status' => 'Belum dibayar',
                    'bank_account_id' => 1,
                    'payment_proof' => null,
                ]);

                $payment->save();
                // Kirim email ke admin saat pengajuan baru dibuat
                $admins = User::role('admin')->get();
                foreach ($admins as $admin) {
                    Mail::to($admin->email)->send(new NewSubmissionAdminNotification($submission));
                }
                break;
            case 3:
                // Validasi data yang diterima dari form
                $validatedData = $request->validate([
                    'praktik_ke' => 'required|in:1,2,3',
                    'tujuan_surat' => 'required|in:Pembuatan SIP,Perpanjangan SIP,Pindah Alamat SIP',
                    'alumni_drg' => 'required|max:50',
                    'tahun_lulus' => 'required|numeric|digits:4',
                    'str' => 'required|max:25',
                    'valid_str' => 'required|date',
                    'serkom' => 'required|max:25',
                    'npa' => 'required|max:11',
                    'cabang_pdgi' => 'required|max:40',
                    'alamat_fakes1' => 'nullable',
                    'jadwal_praktik1' => 'nullable',
                    'surat_praktik1' => 'nullable|mimes:png,jpg,jpeg,pdf|max:1024',
                    'alamat_fakes2' => 'nullable',
                    'jadwal_praktik2' => 'nullable',
                    'surat_praktik2' => 'nullable|mimes:png,jpg,jpeg,pdf|max:1024',
                    'alamat_fakes3' => 'nullable',
                    'jadwal_praktik3' => 'nullable',
                    'surat_praktik3' => 'nullable|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_serkom' => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_str' => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_surat_sehat' => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
                ]);

                $scanFiles = [
                    'surat_praktik1',
                    'surat_praktik2',
                    'surat_praktik3',
                    'scan_serkom',
                    'scan_str',
                    'scan_surat_sehat',
                ];

                // Membuat submission baru
                $submission = Submission::create([
                    'user_id' => Auth::user()->id,
                    'submission_type_id' => $submissionType,
                    'status' => 'Diproses',
                    'surat_keluar' => null,
                ]);

                // Menyimpan data untuk Submission Type 3
                $SubmissionIzinPraktik = new SubmissionIzinPraktik($validatedData);
                foreach ($scanFiles as $scanFile) {
                    if ($request->hasFile($scanFile)) {
                        $file = $request->file($scanFile);
                        $path = $file->store('public/images/' . $scanFile . '/' . $submission->user_id . '/' . $submission->id);
                        $SubmissionIzinPraktik->{$scanFile} = $path;
                    }
                }
                $SubmissionIzinPraktik->submission()->associate($submission);
                $SubmissionIzinPraktik->save();
                // Membuat pembayaran baru
                $paymentAmount = 150000;
                $jenisPembayaran = 'Pengajuan Surat Rekomendasi Izin Praktik-Anggota Dokter Gigi dengan ID Pengajuan ' . $submission->id;

                $payment = new Payments([
                    'user_id' => Auth::user()->id,
                    'submission_id' => $submission->id,
                    'jenis_pembayaran' => $jenisPembayaran,
                    'jumlah_pembayaran' => $paymentAmount,
                    'status' => 'Belum dibayar',
                    'bank_account_id' => 1,
                    'payment_proof' => null,
                ]);

                $payment->save();
                // Kirim email ke admin saat pengajuan baru dibuat
                $admins = User::role('admin')->get();
                foreach ($admins as $admin) {
                    Mail::to($admin->email)->send(new NewSubmissionAdminNotification($submission));
                }
                break;
            case 4:
                // Validasi data yang diterima dari form
                $validatedData = $request->validate([
                    'praktik_ke' => 'required|in:1,2,3',
                    'tujuan_surat' => 'required|in:Pembuatan SIP,Perpanjangan SIP,Pindah Alamat SIP',
                    'alumni_drg' => 'required|max:50',
                    'tahun_lulus' => 'required|numeric|digits:4',
                    'str' => 'required|max:25',
                    'valid_str' => 'required|date',
                    'serkom' => 'required|max:25',
                    'npa' => 'required|max:11',
                    'cabang_pdgi' => 'required|max:40',
                    'alamat_fakes1' => 'nullable',
                    'jadwal_praktik1' => 'nullable',
                    'surat_praktik1' => 'nullable|mimes:png,jpg,jpeg,pdf|max:1024',
                    'alamat_fakes2' => 'nullable',
                    'jadwal_praktik2' => 'nullable',
                    'surat_praktik2' => 'nullable|mimes:png,jpg,jpeg,pdf|max:1024',
                    'alamat_fakes3' => 'nullable',
                    'jadwal_praktik3' => 'nullable',
                    'surat_praktik3' => 'nullable|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_serkom' => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_str' => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_surat_sehat' => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_surat_kolegium' => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
                ]);
                $scanFiles = [
                    'surat_praktik1',
                    'surat_praktik2',
                    'surat_praktik3',
                    'scan_serkom',
                    'scan_str',
                    'scan_surat_sehat',
                    'scan_surat_kolegium',
                ];
                // Membuat submission baru
                $submission = Submission::create([
                    'user_id' => Auth::user()->id,
                    'submission_type_id' => $submissionType,
                    'status' => 'Diproses',
                    'surat_keluar' => null,
                ]);

                // Menyimpan data untuk Submission Type 4
                $SubmissionIzinPraktik = new SubmissionIzinPraktik($validatedData);
                foreach ($scanFiles as $scanFile) {
                    if ($request->hasFile($scanFile)) {
                        $file = $request->file($scanFile);
                        $path = $file->store('public/images/' . $scanFile . '/' . $submission->user_id . '/' . $submission->id);
                        $SubmissionIzinPraktik->{$scanFile} = $path;
                    }
                }
                $SubmissionIzinPraktik->submission()->associate($submission);
                $SubmissionIzinPraktik->save();
                // Membuat pembayaran baru
                $paymentAmount = 300000;
                $jenisPembayaran = 'Pengajuan Surat Rekomendasi Izin Praktik-Anggota Dokter Gigi Spesialis dengan ID Pengajuan ' . $submission->id;

                $payment = new Payments([
                    'user_id' => Auth::user()->id,
                    'submission_id' => $submission->id,
                    'jenis_pembayaran' => $jenisPembayaran,
                    'jumlah_pembayaran' => $paymentAmount,
                    'status' => 'Belum dibayar',
                    'bank_account_id' => 1,
                    'payment_proof' => null,
                ]);

                $payment->save();
                // Kirim email ke admin saat pengajuan baru dibuat
                $admins = User::role('admin')->get();
                foreach ($admins as $admin) {
                    Mail::to($admin->email)->send(new NewSubmissionAdminNotification($submission));
                }
                break;
            case 5:
                // Validasi data yang diterima dari form
                $validatedData = $request->validate([
                    'praktik_ke' => 'required|in:1,2,3',
                    'tujuan_surat' => 'required|in:Pembuatan SIP,Perpanjangan SIP,Pindah Alamat SIP',
                    'alumni_drg' => 'required|max:50',
                    'tahun_lulus' => 'required|numeric|digits:4',
                    'str' => 'required|max:25',
                    'valid_str' => 'required|date',
                    'serkom' => 'required|max:25',
                    'npa' => 'required|max:11',
                    'cabang_pdgi' => 'required|max:40',
                    'alamat_fakes1' => 'nullable',
                    'jadwal_praktik1' => 'nullable',
                    'surat_praktik1' => 'nullable|mimes:png,jpg,jpeg,pdf|max:1024',
                    'alamat_fakes2' => 'nullable',
                    'jadwal_praktik2' => 'nullable',
                    'surat_praktik2' => 'nullable|mimes:png,jpg,jpeg,pdf|max:1024',
                    'alamat_fakes3' => 'nullable',
                    'jadwal_praktik3' => 'nullable',
                    'surat_praktik3' => 'nullable|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_serkom' => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_str' => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_surat_sehat' => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
                ]);

                $scanFiles = [
                    'surat_praktik1',
                    'surat_praktik2',
                    'surat_praktik3',
                    'scan_serkom',
                    'scan_str',
                    'scan_surat_sehat',
                ];


                // Membuat submission baru
                $submission = Submission::create([
                    'user_id' => Auth::user()->id,
                    'submission_type_id' => $submissionType,
                    'status' => 'Diproses',
                    'surat_keluar' => null,
                ]);

                // Menyimpan data untuk Submission Type 5
                $SubmissionIzinPraktik = new SubmissionIzinPraktik($validatedData);
                foreach ($scanFiles as $scanFile) {
                    if ($request->hasFile($scanFile)) {
                        $file = $request->file($scanFile);
                        $path = $file->store('public/images/' . $scanFile . '/' . $submission->user_id . '/' . $submission->id);
                        $SubmissionIzinPraktik->{$scanFile} = $path;
                    }
                }
                $SubmissionIzinPraktik->submission()->associate($submission);
                $SubmissionIzinPraktik->save();
                // Membuat pembayaran baru
                $paymentAmount = 100000;
                $jenisPembayaran = 'Pengajuan Surat Pengantar Izin Praktik-Anggota Dokter Gigi dengan ID Pengajuan ' . $submission->id;

                $payment = new Payments([
                    'user_id' => Auth::user()->id,
                    'submission_id' => $submission->id,
                    'jenis_pembayaran' => $jenisPembayaran,
                    'jumlah_pembayaran' => $paymentAmount,
                    'status' => 'Belum dibayar',
                    'bank_account_id' => 1,
                    'payment_proof' => null,
                ]);

                $payment->save();
                // Kirim email ke admin saat pengajuan baru dibuat
                $admins = User::role('admin')->get();
                foreach ($admins as $admin) {
                    Mail::to($admin->email)->send(new NewSubmissionAdminNotification($submission));
                }
                break;
            case 6:
                // Validasi data yang diterima dari form
                $validatedData = $request->validate([
                    'praktik_ke' => 'required|in:1,2,3',
                    'tujuan_surat' => 'required|in:Pembuatan SIP,Perpanjangan SIP,Pindah Alamat SIP',
                    'alumni_drg' => 'required|max:50',
                    'tahun_lulus' => 'required|numeric|digits:4',
                    'str' => 'required|max:25',
                    'valid_str' => 'required|date',
                    'serkom' => 'required|max:25',
                    'npa' => 'required|max:11',
                    'cabang_pdgi' => 'required|max:40',
                    'alamat_fakes1' => 'nullable',
                    'jadwal_praktik1' => 'nullable',
                    'surat_praktik1' => 'nullable|mimes:png,jpg,jpeg,pdf|max:1024',
                    'alamat_fakes2' => 'nullable',
                    'jadwal_praktik2' => 'nullable',
                    'surat_praktik2' => 'nullable|mimes:png,jpg,jpeg,pdf|max:1024',
                    'alamat_fakes3' => 'nullable',
                    'jadwal_praktik3' => 'nullable',
                    'surat_praktik3' => 'nullable|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_serkom' => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_str' => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_surat_sehat' => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_surat_kolegium' => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
                ]);
                $scanFiles = [
                    'surat_praktik1',
                    'surat_praktik2',
                    'surat_praktik3',
                    'scan_serkom',
                    'scan_str',
                    'scan_surat_sehat',
                    'scan_surat_kolegium',
                ];
                // Membuat submission baru
                $submission = Submission::create([
                    'user_id' => Auth::user()->id,
                    'submission_type_id' => $submissionType,
                    'status' => 'Diproses',
                    'surat_keluar' => null,
                ]);

                // Menyimpan data untuk Submission Type 6
                $SubmissionIzinPraktik = new SubmissionIzinPraktik($validatedData);
                foreach ($scanFiles as $scanFile) {
                    if ($request->hasFile($scanFile)) {
                        $file = $request->file($scanFile);
                        $path = $file->store('public/images/' . $scanFile . '/' . $submission->user_id . '/' . $submission->id);
                        $SubmissionIzinPraktik->{$scanFile} = $path;
                    }
                }
                $SubmissionIzinPraktik->submission()->associate($submission);
                $SubmissionIzinPraktik->save();
                // Membuat pembayaran baru
                $paymentAmount = 250000;
                $jenisPembayaran = 'Pengajuan Surat Pengantar Izin Praktik-Anggota Dokter Gigi Spesialis dengan ID Pengajuan ' . $submission->id;

                $payment = new Payments([
                    'user_id' => Auth::user()->id,
                    'submission_id' => $submission->id,
                    'jenis_pembayaran' => $jenisPembayaran,
                    'jumlah_pembayaran' => $paymentAmount,
                    'status' => 'Belum dibayar',
                    'bank_account_id' => 1,
                    'payment_proof' => null,
                ]);

                $payment->save();
                // Kirim email ke admin saat pengajuan baru dibuat
                $admins = User::role('admin')->get();
                foreach ($admins as $admin) {
                    Mail::to($admin->email)->send(new NewSubmissionAdminNotification($submission));
                }
                break;
            case 7:
                $validatedData = $request->validate([
                    'npa' => 'required|max:11',
                    'mutasi_ke' => 'required|max:40',
                    'alasan_mutasi' => 'required|max:255',
                ]);

                // Membuat submission baru
                $submission = Submission::create([
                    'user_id' => Auth::user()->id,
                    'submission_type_id' => $submissionType,
                    'status' => 'Diproses',
                    'surat_keluar' => null,
                ]);

                // Menyimpan data untuk Submission Type 7 (Mutasi)
                $submissionMutasi = new SubmissionMutasi($validatedData);
                $submissionMutasi->submission()->associate($submission);
                $submissionMutasi->save();
                // Membuat pembayaran baru
                $paymentAmount = 100000;
                $jenisPembayaran = 'Pengajuan Surat Rekomendasi untuk Mutasi Anggota dengan ID Pengajuan ' . $submission->id;

                $payment = new Payments([
                    'user_id' => Auth::user()->id,
                    'submission_id' => $submission->id,
                    'jenis_pembayaran' => $jenisPembayaran,
                    'jumlah_pembayaran' => $paymentAmount,
                    'status' => 'Belum dibayar',
                    'bank_account_id' => 1,
                    'payment_proof' => null,
                ]);

                $payment->save();
                // Kirim email ke admin saat pengajuan baru dibuat
                $admins = User::role('admin')->get();
                foreach ($admins as $admin) {
                    Mail::to($admin->email)->send(new NewSubmissionAdminNotification($submission));
                }
                break;
            case 8:
                $validatedData = $request->validate([
                    'npa' => 'required|max:11',
                    'nama_univ' => 'required|max:40',
                ]);

                // Membuat submission baru
                $submission = Submission::create([
                    'user_id' => Auth::user()->id,
                    'submission_type_id' => $submissionType,
                    'status' => 'Diproses',
                    'surat_keluar' => null,
                ]);
                // Menyimpan data untuk Submission Type 8 (PPDGS)
                $submissionPpdgs = new SubmissionPpdgs($validatedData);
                $submissionPpdgs->submission()->associate($submission);
                $submissionPpdgs->save();
                // Membuat pembayaran baru
                $paymentAmount = 100000;
                $jenisPembayaran = 'Pengajuan Surat Rekomendasi untuk PPDGS Anggota dengan ID Pengajuan ' . $submission->id;

                $payment = new Payments([
                    'user_id' => Auth::user()->id,
                    'submission_id' => $submission->id,
                    'jenis_pembayaran' => $jenisPembayaran,
                    'jumlah_pembayaran' => $paymentAmount,
                    'status' => 'Belum dibayar',
                    'bank_account_id' => 1,
                    'payment_proof' => null,
                ]);

                $payment->save();
                // Kirim email ke admin saat pengajuan baru dibuat
                $admins = User::role('admin')->get();
                foreach ($admins as $admin) {
                    Mail::to($admin->email)->send(new NewSubmissionAdminNotification($submission));
                }
                break;
            default:
                return redirect()->route('submission.index')->with('error', 'Invalid submission type.');
        }

        return redirect()->route('submission.index')->with('success', 'Pengajuan berhasil dibuat, silahkan lakukan pembayaran dan cek email secara berkala untuk mengetahui perkembangan pengajuan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, string $type_id, string $id)
    {
        $submission = Submission::where('submission_type_id', $type_id)->where('id', $id)->first();

        if (!$submission) {
            return redirect()->route('submission.index')->with('error', 'Pengajuan tidak ditemukan.');
        }
        $user = Auth::user();
        if (!($user->hasRole(['admin', 'bendahara', 'interview']) || $user->id == $submission->user_id)) {
            abort(403, 'Unauthorized access');
        }

        $submissionType = $submission->submission_type_id;

        $view = '';

        switch ($submissionType) {
            case 1:
                $view = 'submission.show.anggota';
                break;
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
                $view = 'submission.show.izinpraktik';
                break;
            case 7:
                $view = 'submission.show.mutasi';
                break;
            case 8:
                $view = 'submission.show.ppdgs';
                break;
            default:
                return redirect()->route('submission.index')->with('error', 'Invalid submission type.');
        }

        return view($view, compact('submission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user, string $type_id, string $id)
    {
        $submission = Submission::where('submission_type_id', $type_id)->where('id', $id)->first();

        $user = Auth::user();
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized access');
        }
        $submissionType = $submission->submission_type_id;

        $view = '';

        switch ($submissionType) {
            case 1:
                $view = 'submission.edit.anggota';
                break;
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
                $view = 'submission.edit.izinpraktik';
                break;
            case 7:
                $view = 'submission.edit.mutasi';
                break;
            case 8:
                $view = 'submission.edit.ppdgs';
                break;
            default:
                return redirect()->route('submission.index')->with('error', 'Invalid submission type.');
        }

        return view($view, compact('submission'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $type_id, string $id)
    {
        $submission = Submission::where('submission_type_id', $type_id)->where('id', $id)->first();
        $submissionType = $submission->submission_type_id;

        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized access');
        }

        switch ($submissionType) {
            case 1:
                // Validasi data yang diterima dari form
                $validatedData = $request->validate([
                    'str' => 'required|max:25',
                    'serkom' => 'required|max:25',
                    'cabang_mutasi' => 'sometimes|max:40',
                    'scan_str' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_serkom' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_mutasi' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'status' => 'required|in:Diproses,Selesai,Ditolak',
                    'surat_keluar' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                ]);

                // Mengunggah file dan menyimpan path ke dalam array $validatedData
                $scanFiles = [
                    'scan_serkom',
                    'scan_mutasi',
                    'scan_str',
                ];

                if ($request->hasFile('surat_keluar')) {
                    $file = $request->file('surat_keluar');
                    // Hapus gambar lama dari penyimpanan jika ada
                    $oldPath = $submission->surat_keluar;
                    if ($oldPath && Storage::exists($oldPath)) {
                        Storage::delete($oldPath);
                    }

                    // Simpan gambar baru dengan path yang sama
                    $path = $file->store('public/images/surat_keluar/' . $submission->user_id . '/' . $submission->id);
                    $submission->update(['surat_keluar' => $path]);
                }
                // Mengupdate submission sesuai dengan validasi dan request
                $submission->update([
                    'status' => $validatedData['status'],
                    'updated_by' => auth()->user()->id,
                ]);
                if ($validatedData['status'] === 'Selesai') {
                    $user = $submission->user;
                    $user->syncRoles('anggota');
                    Mail::to($submission->user->email)->send(new SubmissionAnggotaCompletedUserNotification($submission));
                }
                // Mengupdate data untuk Submission Type 1 (Anggota)
                $submissionAnggota = SubmissionAnggota::where('submission_id', $submission->id)->first();
                foreach ($scanFiles as $scanFile) {
                    if ($request->hasFile($scanFile)) {
                        $file = $request->file($scanFile);
                        // Hapus gambar lama dari penyimpanan jika ada
                        $oldPath = $submissionAnggota->{$scanFile};
                        if ($oldPath && Storage::exists($oldPath)) {
                            Storage::delete($oldPath);
                        }

                        // Simpan gambar baru dengan path yang sama
                        $path = $file->store('public/images/' . $scanFile . '/' . $submission->user_id . '/' . $submission->id);
                        $validatedData[$scanFile] = $path;
                    }
                }
                // Hapus 'status' dari $validatedData
                unset($validatedData['status']);
                unset($validatedData['surat_keluar']);
                $submissionAnggota->update($validatedData);
                break;
            case 2:
                $validatedData = $request->validate([
                    'praktik_ke' => 'required|in:1,2,3',
                    'tujuan_surat' => 'required|in:Pembuatan SIP,Perpanjangan SIP,Pindah Alamat SIP',
                    'alumni_drg' => 'required|max:50',
                    'tahun_lulus' => 'required|numeric|digits:4',
                    'str' => 'required|max:25',
                    'valid_str' => 'required|date',
                    'serkom' => 'required|max:25',
                    'npa' => 'required|max:11',
                    'cabang_pdgi' => 'required|max:40',
                    'alamat_fakes1' => 'sometimes',
                    'jadwal_praktik1' => 'sometimes',
                    'surat_praktik1' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'alamat_fakes2' => 'sometimes',
                    'jadwal_praktik2' => 'sometimes',
                    'surat_praktik2' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'alamat_fakes3' => 'sometimes',
                    'jadwal_praktik3' => 'sometimes',
                    'surat_praktik3' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_serkom' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_str' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_surat_sehat' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_surat_pengantar' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_surat_kolegium' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'surat_mkekg' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'status' => 'required|in:Diproses,Selesai,Ditolak',
                    'surat_keluar' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                ]);
                $scanFiles = [
                    'surat_praktik1',
                    'surat_praktik2',
                    'surat_praktik3',
                    'scan_serkom',
                    'scan_str',
                    'scan_surat_sehat',
                    'scan_surat_pengantar',
                    'scan_surat_kolegium',
                    'surat_mkekg',
                ];
                // Mengupdate submission sesuai dengan validasi dan request
                if ($request->hasFile('surat_keluar')) {
                    $file = $request->file('surat_keluar');
                    // Hapus gambar lama dari penyimpanan jika ada
                    $oldPath = $submission->surat_keluar;
                    if ($oldPath && Storage::exists($oldPath)) {
                        Storage::delete($oldPath);
                    }

                    // Simpan gambar baru dengan path yang sama
                    $path = $file->store('public/images/surat_keluar/' . $submission->user_id . '/' . $submission->id);
                    $submission->update(['surat_keluar' => $path]);
                }
                // Mengupdate submission sesuai dengan validasi dan request
                $submission->update([
                    'status' => $validatedData['status'],
                    'updated_by' => auth()->user()->id,
                ]);
                if ($validatedData['status'] === 'Selesai') {
                    Mail::to($submission->user->email)->send(new SubmissionCompletedUserNotification($submission));
                }
                // Mengupdate data untuk Submission Type 2
                $submissionIzinPraktik = SubmissionIzinPraktik::where('submission_id', $submission->id)->first();
                foreach ($scanFiles as $scanFile) {
                    if ($request->hasFile($scanFile)) {
                        $file = $request->file($scanFile);
                        // Hapus gambar lama dari penyimpanan jika ada
                        $oldPath = $submissionIzinPraktik->{$scanFile};
                        if ($oldPath && Storage::exists($oldPath)) {
                            Storage::delete($oldPath);
                        }

                        // Simpan gambar baru dengan path yang sama
                        $path = $file->store('public/images/' . $scanFile . '/' . $submission->user_id . '/' . $submission->id);
                        $validatedData[$scanFile] = $path;
                    }
                }
                unset($validatedData['status']);
                unset($validatedData['surat_keluar']);
                $submissionIzinPraktik->update($validatedData);
                break;
            // case untuk tipe submission lainnya...
            case 3:
                // Validasi data yang diterima dari form
                $validatedData = $request->validate([
                    'praktik_ke' => 'required|in:1,2,3',
                    'tujuan_surat' => 'required|in:Pembuatan SIP,Perpanjangan SIP,Pindah Alamat SIP',
                    'alumni_drg' => 'required|max:50',
                    'tahun_lulus' => 'required|numeric|digits:4',
                    'str' => 'required|max:25',
                    'valid_str' => 'required|date',
                    'serkom' => 'required|max:25',
                    'npa' => 'required|max:11',
                    'cabang_pdgi' => 'required|max:40',
                    'alamat_fakes1' => 'sometimes',
                    'jadwal_praktik1' => 'sometimes',
                    'surat_praktik1' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'alamat_fakes2' => 'sometimes',
                    'jadwal_praktik2' => 'sometimes',
                    'surat_praktik2' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'alamat_fakes3' => 'sometimes',
                    'jadwal_praktik3' => 'sometimes',
                    'surat_praktik3' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_serkom' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_str' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_surat_sehat' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'surat_mkekg' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'status' => 'required|in:Diproses,Selesai,Ditolak',
                    'surat_keluar' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                ]);
                $scanFiles = [
                    'surat_praktik1',
                    'surat_praktik2',
                    'surat_praktik3',
                    'scan_serkom',
                    'scan_str',
                    'scan_surat_sehat',
                    'surat_mkekg',
                ];
                // Mengupdate submission sesuai dengan validasi dan request
                if ($request->hasFile('surat_keluar')) {
                    $file = $request->file('surat_keluar');
                    // Hapus gambar lama dari penyimpanan jika ada
                    $oldPath = $submission->surat_keluar;
                    if ($oldPath && Storage::exists($oldPath)) {
                        Storage::delete($oldPath);
                    }

                    // Simpan gambar baru dengan path yang sama
                    $path = $file->store('public/images/surat_keluar/' . $submission->user_id . '/' . $submission->id);
                    $submission->update(['surat_keluar' => $path]);
                }
                // Mengupdate submission sesuai dengan validasi dan request
                $submission->update([
                    'status' => $validatedData['status'],
                    'updated_by' => auth()->user()->id,
                ]);
                if ($validatedData['status'] === 'Selesai') {
                    Mail::to($submission->user->email)->send(new SubmissionCompletedUserNotification($submission));
                }
                // Mengupdate data untuk Submission Type 3
                $submissionIzinPraktik = SubmissionIzinPraktik::where('submission_id', $submission->id)->first();
                foreach ($scanFiles as $scanFile) {
                    if ($request->hasFile($scanFile)) {
                        $file = $request->file($scanFile);
                        // Hapus gambar lama dari penyimpanan jika ada
                        $oldPath = $submissionIzinPraktik->{$scanFile};
                        if ($oldPath && Storage::exists($oldPath)) {
                            Storage::delete($oldPath);
                        }

                        // Simpan gambar baru dengan path yang sama
                        $path = $file->store('public/images/' . $scanFile . '/' . $submission->user_id . '/' . $submission->id);
                        $validatedData[$scanFile] = $path;
                    }
                }
                unset($validatedData['status']);
                unset($validatedData['surat_keluar']);
                $submissionIzinPraktik->update($validatedData);
                break;
            case 4:
                // Validasi data yang diterima dari form
                $validatedData = $request->validate([
                    'praktik_ke' => 'required|in:1,2,3',
                    'tujuan_surat' => 'required|in:Pembuatan SIP,Perpanjangan SIP,Pindah Alamat SIP',
                    'alumni_drg' => 'required|max:50',
                    'tahun_lulus' => 'required|numeric|digits:4',
                    'str' => 'required|max:25',
                    'valid_str' => 'required|date',
                    'serkom' => 'required|max:25',
                    'npa' => 'required|max:11',
                    'cabang_pdgi' => 'required|max:40',
                    'alamat_fakes1' => 'sometimes',
                    'jadwal_praktik1' => 'sometimes',
                    'surat_praktik1' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'alamat_fakes2' => 'sometimes',
                    'jadwal_praktik2' => 'sometimes',
                    'surat_praktik2' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'alamat_fakes3' => 'sometimes',
                    'jadwal_praktik3' => 'sometimes',
                    'surat_praktik3' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_serkom' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_str' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_surat_sehat' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_surat_kolegium' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'surat_mkekg' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'status' => 'required|in:Diproses,Selesai,Ditolak',
                    'surat_keluar' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                ]);
                $scanFiles = [
                    'surat_praktik1',
                    'surat_praktik2',
                    'surat_praktik3',
                    'scan_serkom',
                    'scan_str',
                    'scan_surat_sehat',
                    'scan_surat_kolegium',
                    'surat_mkekg',
                ];
                // Mengupdate submission sesuai dengan validasi dan request
                if ($request->hasFile('surat_keluar')) {
                    $file = $request->file('surat_keluar');
                    // Hapus gambar lama dari penyimpanan jika ada
                    $oldPath = $submission->surat_keluar;
                    if ($oldPath && Storage::exists($oldPath)) {
                        Storage::delete($oldPath);
                    }

                    // Simpan gambar baru dengan path yang sama
                    $path = $file->store('public/images/surat_keluar/' . $submission->user_id . '/' . $submission->id);
                    $submission->update(['surat_keluar' => $path]);
                }
                // Mengupdate submission sesuai dengan validasi dan request
                $submission->update([
                    'status' => $validatedData['status'],
                    'updated_by' => auth()->user()->id,
                ]);
                if ($validatedData['status'] === 'Selesai') {
                    Mail::to($submission->user->email)->send(new SubmissionCompletedUserNotification($submission));
                }
                // Mengupdate data untuk Submission Type 4
                $submissionIzinPraktik = SubmissionIzinPraktik::where('submission_id', $submission->id)->first();
                foreach ($scanFiles as $scanFile) {
                    if ($request->hasFile($scanFile)) {
                        $file = $request->file($scanFile);
                        // Hapus gambar lama dari penyimpanan jika ada
                        $oldPath = $submissionIzinPraktik->{$scanFile};
                        if ($oldPath && Storage::exists($oldPath)) {
                            Storage::delete($oldPath);
                        }

                        // Simpan gambar baru dengan path yang sama
                        $path = $file->store('public/images/' . $scanFile . '/' . $submission->user_id . '/' . $submission->id);
                        $validatedData[$scanFile] = $path;
                    }
                }
                unset($validatedData['status']);
                unset($validatedData['surat_keluar']);
                $submissionIzinPraktik->update($validatedData);
                break;
            case 5:
                // Validasi data yang diterima dari form
                $validatedData = $request->validate([
                    'praktik_ke' => 'required|in:1,2,3',
                    'tujuan_surat' => 'required|in:Pembuatan SIP,Perpanjangan SIP,Pindah Alamat SIP',
                    'alumni_drg' => 'required|max:50',
                    'tahun_lulus' => 'required|numeric|digits:4',
                    'str' => 'required|max:25',
                    'valid_str' => 'required|date',
                    'serkom' => 'required|max:25',
                    'npa' => 'required|max:11',
                    'cabang_pdgi' => 'required|max:40',
                    'alamat_fakes1' => 'sometimes',
                    'jadwal_praktik1' => 'sometimes',
                    'surat_praktik1' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'alamat_fakes2' => 'sometimes',
                    'jadwal_praktik2' => 'sometimes',
                    'surat_praktik2' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'alamat_fakes3' => 'sometimes',
                    'jadwal_praktik3' => 'sometimes',
                    'surat_praktik3' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_serkom' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_str' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_surat_sehat' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'surat_mkekg' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'status' => 'required|in:Diproses,Selesai,Ditolak',
                    'surat_keluar' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                ]);
                $scanFiles = [
                    'surat_praktik1',
                    'surat_praktik2',
                    'surat_praktik3',
                    'scan_serkom',
                    'scan_str',
                    'scan_surat_sehat',
                    'surat_mkekg',
                ];
                // Mengupdate submission sesuai dengan validasi dan request
                if ($request->hasFile('surat_keluar')) {
                    $file = $request->file('surat_keluar');
                    // Hapus gambar lama dari penyimpanan jika ada
                    $oldPath = $submission->surat_keluar;
                    if ($oldPath && Storage::exists($oldPath)) {
                        Storage::delete($oldPath);
                    }

                    // Simpan gambar baru dengan path yang sama
                    $path = $file->store('public/images/surat_keluar/' . $submission->user_id . '/' . $submission->id);
                    $submission->update(['surat_keluar' => $path]);
                }
                // Mengupdate submission sesuai dengan validasi dan request
                $submission->update([
                    'status' => $validatedData['status'],
                    'updated_by' => auth()->user()->id,
                ]);
                if ($validatedData['status'] === 'Selesai') {
                    Mail::to($submission->user->email)->send(new SubmissionCompletedUserNotification($submission));
                }
                // Mengupdate data untuk Submission Type 5
                $submissionIzinPraktik = SubmissionIzinPraktik::where('submission_id', $submission->id)->first();
                foreach ($scanFiles as $scanFile) {
                    if ($request->hasFile($scanFile)) {
                        $file = $request->file($scanFile);
                        // Hapus gambar lama dari penyimpanan jika ada
                        $oldPath = $submissionIzinPraktik->{$scanFile};
                        if ($oldPath && Storage::exists($oldPath)) {
                            Storage::delete($oldPath);
                        }

                        // Simpan gambar baru dengan path yang sama
                        $path = $file->store('public/images/' . $scanFile . '/' . $submission->user_id . '/' . $submission->id);
                        $validatedData[$scanFile] = $path;
                    }
                }
                unset($validatedData['status']);
                unset($validatedData['surat_keluar']);
                $submissionIzinPraktik->update($validatedData);
                break;
            case 6:
                // Validasi data yang diterima dari form
                $validatedData = $request->validate([
                    'praktik_ke' => 'required|in:1,2,3',
                    'tujuan_surat' => 'required|in:Pembuatan SIP,Perpanjangan SIP,Pindah Alamat SIP',
                    'alumni_drg' => 'required|max:50',
                    'tahun_lulus' => 'required|numeric|digits:4',
                    'str' => 'required|max:25',
                    'valid_str' => 'required|date',
                    'serkom' => 'required|max:25',
                    'npa' => 'required|max:11',
                    'cabang_pdgi' => 'required|max:40',
                    'alamat_fakes1' => 'sometimes',
                    'jadwal_praktik1' => 'sometimes',
                    'surat_praktik1' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'alamat_fakes2' => 'sometimes',
                    'jadwal_praktik2' => 'sometimes',
                    'surat_praktik2' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'alamat_fakes3' => 'sometimes',
                    'jadwal_praktik3' => 'sometimes',
                    'surat_praktik3' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_serkom' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_str' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_surat_sehat' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'scan_surat_kolegium' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'surat_mkekg' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                    'status' => 'required|in:Diproses,Selesai,Ditolak',
                    'surat_keluar' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                ]);
                $scanFiles = [
                    'surat_praktik1',
                    'surat_praktik2',
                    'surat_praktik3',
                    'scan_serkom',
                    'scan_str',
                    'scan_surat_sehat',
                    'scan_surat_kolegium',
                    'surat_mkekg',
                ];
                // Mengupdate submission sesuai dengan validasi dan request
                if ($request->hasFile('surat_keluar')) {
                    $file = $request->file('surat_keluar');
                    // Hapus gambar lama dari penyimpanan jika ada
                    $oldPath = $submission->surat_keluar;
                    if ($oldPath && Storage::exists($oldPath)) {
                        Storage::delete($oldPath);
                    }

                    // Simpan gambar baru dengan path yang sama
                    $path = $file->store('public/images/surat_keluar/' . $submission->user_id . '/' . $submission->id);
                    $submission->update(['surat_keluar' => $path]);
                }
                // Mengupdate submission sesuai dengan validasi dan request
                $submission->update([
                    'status' => $validatedData['status'],
                    'updated_by' => auth()->user()->id,
                ]);
                if ($validatedData['status'] === 'Selesai') {
                    Mail::to($submission->user->email)->send(new SubmissionCompletedUserNotification($submission));
                }
                // Mengupdate data untuk Submission Type 4
                $submissionIzinPraktik = SubmissionIzinPraktik::where('submission_id', $submission->id)->first();
                foreach ($scanFiles as $scanFile) {
                    if ($request->hasFile($scanFile)) {
                        $file = $request->file($scanFile);
                        // Hapus gambar lama dari penyimpanan jika ada
                        $oldPath = $submissionIzinPraktik->{$scanFile};
                        if ($oldPath && Storage::exists($oldPath)) {
                            Storage::delete($oldPath);
                        }

                        // Simpan gambar baru dengan path yang sama
                        $path = $file->store('public/images/' . $scanFile . '/' . $submission->user_id . '/' . $submission->id);
                        $validatedData[$scanFile] = $path;
                    }
                }
                unset($validatedData['status']);
                unset($validatedData['surat_keluar']);
                $submissionIzinPraktik->update($validatedData);
                break;
            case 7:
                $validatedData = $request->validate([
                    'npa' => 'required|max:11',
                    'mutasi_ke' => 'required|max:40',
                    'alasan_mutasi' => 'required|max:255',
                    'status' => 'required|in:Diproses,Selesai,Ditolak',
                    'surat_keluar' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                ]);
                if ($request->hasFile('surat_keluar')) {
                    $file = $request->file('surat_keluar');
                    // Hapus gambar lama dari penyimpanan jika ada
                    $oldPath = $submission->surat_keluar;
                    if ($oldPath && Storage::exists($oldPath)) {
                        Storage::delete($oldPath);
                    }

                    // Simpan gambar baru dengan path yang sama
                    $path = $file->store('public/images/surat_keluar/' . $submission->user_id . '/' . $submission->id);
                    $submission->update(['surat_keluar' => $path]);
                }
                // Mengupdate submission sesuai dengan validasi dan request
                $submission->update([
                    'status' => $validatedData['status'],
                    'updated_by' => auth()->user()->id,
                ]);
                if ($validatedData['status'] === 'Selesai') {
                    $user = $submission->user;
                    $user->syncRoles('user');
                    Mail::to($submission->user->email)->send(new SubmissionCompletedUserNotification($submission));
                }
                // Mengupdate data untuk Submission Type 7
                $submissionMutasi = SubmissionMutasi::where('submission_id', $submission->id)->first();
                unset($validatedData['status']);
                unset($validatedData['surat_keluar']);
                $submissionMutasi->update($validatedData);
                break;
            case 8:
                $validatedData = $request->validate([
                    'npa' => 'required|max:11',
                    'nama_univ' => 'required|max:40',
                    'status' => 'required|in:Diproses,Selesai,Ditolak',
                    'surat_keluar' => 'sometimes|mimes:png,jpg,jpeg,pdf|max:1024',
                ]);
                if ($request->hasFile('surat_keluar')) {
                    $file = $request->file('surat_keluar');
                    // Hapus gambar lama dari penyimpanan jika ada
                    $oldPath = $submission->surat_keluar;
                    if ($oldPath && Storage::exists($oldPath)) {
                        Storage::delete($oldPath);
                    }

                    // Simpan gambar baru dengan path yang sama
                    $path = $file->store('public/images/surat_keluar/' . $submission->user_id . '/' . $submission->id);
                    $submission->update(['surat_keluar' => $path]);
                }
                // Mengupdate submission sesuai dengan validasi dan request
                $submission->update([
                    'status' => $validatedData['status'],
                    'updated_by' => auth()->user()->id,
                ]);
                if ($validatedData['status'] === 'Selesai') {
                    Mail::to($submission->user->email)->send(new SubmissionCompletedUserNotification($submission));
                }
                // Mengupdate data untuk Submission Type 8
                $submissionPpdgs = SubmissionPpdgs::where('submission_id', $submission->id)->first();
                unset($validatedData['status']);
                unset($validatedData['surat_keluar']);
                $submissionPpdgs->update($validatedData);
                break;
            default:
                return redirect()->route('submission.index')->with('error', 'Invalid submission type.');
        }

        return redirect()->route('submission.indexall')->with('success', 'Data berhasil diperbarui.');
    }

/**
 * Remove the specified resource from storage.
 */
// public function destroy(string $id)
// {
//     // Temukan submission berdasarkan ID
//     $submission = Submission::findOrFail($id);

//     // Cek apakah pengguna saat ini memiliki hak untuk menghapus submission ini
//     if (Auth::user()->hasRole('admin')) {
//         abort(403, 'Unauthorized access');
//     }

//     // Hapus semua data terkait submission
//     $submission->delete();

//     // Redirect ke halaman sebelumnya dengan pesan sukses
//     return redirect()->route('submission.indexall')->with('success', 'Submission berhasil dihapus.');
// }
}
