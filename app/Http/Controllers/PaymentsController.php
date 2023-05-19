<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentDoneNotification;
use App\Mail\PaymentFailNotification;
use Illuminate\Support\Facades\Storage;
use App\Mail\UploadProofPaymentNotification;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $unpaidAndPendingPayments = $user->payments()
            ->whereIn('status', ['belum dibayar', 'menunggu konfirmasi'])
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'unpaid_and_pending_page');

        $completedPayments = $user->payments()
            ->where('status', 'lunas')
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'completed_page');

        return view('payments.index', compact('unpaidAndPendingPayments', 'completedPayments'));
    }

    public function indexall(Request $request)
    {
        $user = Auth::user();
        if ($user->hasAnyRole('admin', 'bendahara')) {
            $search = $request->input('search', '');
            $query = Payments::query();

            if ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%');
                });
            }

            $pendingPayments = (clone $query)->where('status', 'menunggu konfirmasi')
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], 'pending_page');

            $unpaidPayments = (clone $query)->where('status', 'belum dibayar')
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], 'unpaid_page');

            $completedPayments = $query->where('status', 'lunas')
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], 'completed_page');

            return view('payments.indexall', compact('pendingPayments', 'unpaidPayments', 'completedPayments', 'search'));
        } else {
            abort(403, 'Unauthorized access');
        }
    }

    public function upload(Request $request, Payments $payment)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $oldPath = $payment->bukti_pembayaran;
            if ($oldPath && Storage::exists($oldPath)) {
                Storage::delete($oldPath);
            }
            $path = $file->store('public/images/bukti_pembayaran/' . $payment->user_id . '/' . $payment->id);

            $payment->update([
                'bukti_pembayaran' => $path,
                'status' => 'Menunggu konfirmasi',
            ]);
            $bendaharas = User::role('bendahara')->get();
            foreach ($bendaharas as $bendahara) {
                Mail::to($bendahara->email)->send(new UploadProofPaymentNotification($payment));
            }
        }

        return redirect()->route('payments.index')->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu konfirmasi.');
    }

    public function changeStatus(Request $request, $id)
    {
        $payment = Payments::findOrFail($id);
        $status = $request->input('status');

        if ($status == 'Lunas') {
            $jangka_iuran = $payment->jangka_iuran;
            if ($jangka_iuran) {
                $user = $payment->user;
                $now = Carbon::now();

                // Jika iuran_at null, set nilai iuran_at ke waktu saat ini
                if (!$user->iuran_at) {
                    $user->iuran_at = $now;
                }

                // Jika iuran_until null, set nilai iuran_until ke waktu saat ini
                if (!$user->iuran_until) {
                    $user->iuran_until = $now;
                }

                // Tambahkan jangka_iuran ke iuran_until
                $user->iuran_until = Carbon::parse($user->iuran_until)->addDays($payment->jangka_iuran);
                $user->save();
            }
            Mail::to($payment->user->email)->send(new PaymentDoneNotification($payment));
        }
        if ($status == 'Belum dibayar') {
            Mail::to($payment->user->email)->send(new PaymentFailNotification($payment));
        }

        $payment->status = $status;
        $payment->updated_by = auth()->user()->id;
        $payment->save();

        return redirect()->route('payments.indexall')->with('success', 'Status pembayaran berhasil diubah.');
    }
    /**
     * Show the form for creating a new resource.
     */

     public function bayarIuran(Request $request)
     {
         // Konversi pilihan bulan ke jumlah hari dan jumlah pembayaran
         if ($request->bulan == 3) {
             $jenis_pembayaran = 'Pembayaran Iuran PDGI Kota Bogor 3 bulan';
             $jangkaIuran = 90;
             $jumlahPembayaran = 90000;
         } elseif ($request->bulan == 6) {
             $jenis_pembayaran = 'Pembayaran Iuran PDGI Kota Bogor 6 bulan';
             $jangkaIuran = 180;
             $jumlahPembayaran = 180000;
         } elseif ($request->bulan == 12) {
             $jenis_pembayaran = 'Pembayaran Iuran PDGI Kota Bogor 1 Tahun';
             $jangkaIuran = 365;
             $jumlahPembayaran = 350000;
         } elseif ($request->bulan == 24) {
             $jenis_pembayaran = 'Pembayaran Iuran PDGI Kota Bogor 2 Tahun';
             $jangkaIuran = 730;
             $jumlahPembayaran = 700000;
         }

         $payment = new Payments([
             'user_id' => Auth::id(),
             'jenis_pembayaran' => $jenis_pembayaran,
             'jangka_iuran' => $jangkaIuran,
             'jumlah_pembayaran' => $jumlahPembayaran,
             'nama_bank' => 'BCA',
             'nomor_rekening' => '7380537707',
             'nama_rekening' => 'Rini Utari Anggraeni, drg',
             'status' => 'Belum dibayar',
         ]);

         $payment->save();

         return redirect()->route('payments.index')->with('success', 'Silahkan melakukan pembayaran iuran dan unggah bukti bayar');
     }
}
