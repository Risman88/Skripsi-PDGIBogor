<?php

namespace App\Http\Controllers;

use App\Models\ZoomMeeting;
use App\Models\Payments;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $dateThirtyDaysAgo = Carbon::now()->subDays(30);
        $now = Carbon::now();
        $WawancaraMendatangUser = ZoomMeeting::where('untuk_id', Auth::id())->where('start_time', '>', $now)->orderBy('start_time', 'asc')->get();
        $WawancaraMendatangAdmin = ZoomMeeting::where('dibuat_oleh', Auth::id())->where('start_time', '>', $now)->orderBy('start_time', 'asc')->get();
        $PengajuanDiprosesUser = Submission::where('user_id', Auth::id())->where('status', 'Diproses')->count();
        $PembayaranBelumdibayarUser = Payments::where('user_id', Auth::id())->where('status', 'Belum Dibayar')->count();
        $TotalPembayaranMenungguKonfirmasi = Payments::where('status', 'Menunggu konfirmasi')->count();
        $TotalPengajuanSedangdiproses = Submission::where('status', 'Diproses')->count();
        $TotalPengajuan30hari = Submission::where('created_at', '>=', $dateThirtyDaysAgo)->count();
        $totalPengajuan = Submission::count();

        return view('dashboard', compact('WawancaraMendatangUser', 'WawancaraMendatangAdmin', 'PengajuanDiprosesUser', 'PembayaranBelumdibayarUser', 'TotalPembayaranMenungguKonfirmasi', 'TotalPengajuanSedangdiproses', 'TotalPengajuan30hari', 'totalPengajuan'));
    }
}
