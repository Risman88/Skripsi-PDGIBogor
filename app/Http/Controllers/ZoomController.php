<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\ZoomMeeting;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\ZoomMeetingNotification;
use Illuminate\Support\Facades\Mail;


class ZoomController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        if ($user->hasAnyRole('admin', 'interview', 'superadmin')) {

            $users = User::all();
            return view('zoom.create', compact('users'));
        } else {
            abort(403, 'Unauthorized access');
        }
    }

    public function indexKehadiran(Request $request)
    {
        $user = Auth::user();

        // Pastikan user memiliki salah satu peran 'admin' atau 'interview'
        if ($user->hasAnyRole('admin', 'interview', 'superadmin')) {
            $now = Carbon::now();

            $zoomMeetings = ZoomMeeting::where('dibuat_oleh', $user->id)
                ->where('start_time', '<', $now) // Hanya Zoom Meeting yang sudah lewat
                ->orderBy('start_time', 'asc')
                ->paginate(5, ['*'], 'pastPage')
                ->withQueryString();

            return view('zoom.indexkehadiran', compact('zoomMeetings'));
        } else {
            abort(403, 'Unauthorized access');
        }
    }
    public function indexall(Request $request)
    {
        $user = Auth::user();
        if ($user->hasAnyRole('admin', 'interview', 'superadmin')) {
            $search = $request->input('search', '');
            $now = Carbon::now();

            $zoomMeetings = ZoomMeeting::query();

            if ($search) {
                $zoomMeetings = ZoomMeeting::whereHas('untuk', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                })->orderBy('start_time', 'asc');
            } else {
                $zoomMeetings = ZoomMeeting::orderBy('start_time', 'asc');
            }

            $zoomMeetingsUpcoming = $zoomMeetings->clone()->where('start_time', '>', $now)->paginate(5, ['*'], 'upcomingPage')->withQueryString();
            $zoomMeetingsPast = $zoomMeetings->clone()->where('start_time', '<', $now)->paginate(5, ['*'], 'pastPage')->withQueryString();

            return view('zoom.indexall', compact('zoomMeetingsUpcoming', 'zoomMeetingsPast', 'search'));
        } else {
            abort(403, 'Unauthorized access');
        }
    }
    public function index()
    {
        $userId = auth()->user()->id;
        $zoomMeetingsUpcoming = ZoomMeeting::where('untuk_id', $userId)
            ->where('start_time', '>', now())
            ->orderBy('start_time', 'asc')
            ->paginate(5, ['*'], 'upcoming_page');

        $zoomMeetingsPast = ZoomMeeting::where('untuk_id', $userId)
            ->where('start_time', '<=', now())
            ->orderBy('start_time', 'desc')
            ->paginate(5, ['*'], 'past_page');

        return view('zoom.index', compact('zoomMeetingsUpcoming', 'zoomMeetingsPast'));
    }
    public function store(Request $request)
    {
        $client = new Client();

        $accessToken = session('zoom_access_token');

        $response = $client->post('https://api.zoom.us/v2/users/me/meetings', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'topic' => $request->input('title'),
                'type' => 2,
                'start_time' => Carbon::parse($request->input('start_time'))->toIso8601String(),
                'duration' => $request->input('duration'),
                'timezone' => 'Asia/Jakarta',
            ],
        ]);

        $zoomMeetingData = json_decode((string) $response->getBody(), true);

        $zoomMeeting = new ZoomMeeting();
        $zoomMeeting->title = $request->input('title');
        $zoomMeeting->untuk_id = $request->input('untuk_id');
        $zoomMeeting->dibuat_oleh = auth()->user()->id;
        $zoomMeeting->description = $request->input('description');
        $zoomMeeting->start_time = $request->input('start_time');
        $zoomMeeting->duration = $request->input('duration');
        $zoomMeeting->zoom_meeting_id = $zoomMeetingData['id'];
        $zoomMeeting->password = $zoomMeetingData['password'];
        $zoomMeeting->link_zoom = $zoomMeetingData['join_url'];
        $zoomMeeting->save();

        $user = User::findOrFail($request->input('untuk_id'));

        Mail::to($user->email)->send(new ZoomMeetingNotification($zoomMeeting)); // Mengirim email notifikasi ke alamat email pengguna

        return redirect()->route('zoom_meetings.indexall')->with('success', 'Zoom meeting berhasil dibuat.');
    }
    public function updateAttendanceStatus(Request $request, ZoomMeeting $zoomMeeting)
    {
        // Pastikan user yang sedang login adalah pembuat meeting
        if (Auth::id() != $zoomMeeting->dibuat_oleh) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'status' => 'required|in:Hadir,Tidak Hadir',
        ]);

        $zoomMeeting->update(['status' => $request->status]);

        return redirect()->route('zoom.kehadiran')->with('success', 'Status kehadiran berhasil diperbarui.');
    }
    private function getZoomAccessToken()
    {
        return session('zoom_access_token');
    }
    // private function deleteZoomMeeting($meetingId)
    // {
    //     $client = new Client([
    //         'base_uri' => 'https://api.zoom.us/v2/',
    //         'headers' => [
    //             'Content-Type' => 'application/json',
    //             'Authorization' => 'Bearer ' . $this->getZoomAccessToken(),
    //         ],
    //     ]);

    //     try {
    //         $response = $client->delete("meetings/{$meetingId}");
    //         return json_decode($response->getBody(), true);
    //     } catch (RequestException $e) {
    //         if ($e->hasResponse()) {
    //             return json_decode($e->getResponse()->getBody(), true);
    //         }
    //     }
    // }

    // public function delete($id)
    // {
    //     $zoomMeeting = ZoomMeeting::findOrFail($id);

    //     // Hapus meeting dari akun Zoom
    //     $this->deleteZoomMeeting($zoomMeeting->zoom_meeting_id);

    //     // Hapus meeting dari basis data
    //     $zoomMeeting->delete();

    //     return redirect()->route('zoom_meetings.indexall')->with('success', 'Zoom meeting berhasil dihapus.');
    // }
}
