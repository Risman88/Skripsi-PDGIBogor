<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class ZoomAuthController extends Controller
{
    public function redirectToProvider()
    {
        $query = http_build_query([
            'client_id' => env('ZOOM_CLIENT_ID'),
            'redirect_uri' => env('ZOOM_REDIRECT_URI'),
            'response_type' => 'code',
            'scope' => 'meeting:write'
        ]);

        return Redirect::to('https://zoom.us/oauth/authorize?' . $query);
    }

    public function handleCallback(Request $request)
    {
        $response = Http::asForm()->post('https://zoom.us/oauth/token', [
            'grant_type' => 'authorization_code',
            'code' => $request->code,
            'redirect_uri' => env('ZOOM_REDIRECT_URI'),
            'client_id' => env('ZOOM_CLIENT_ID'),
            'client_secret' => env('ZOOM_CLIENT_SECRET'),
        ]);

        $accessToken = $response->json()['access_token'];
        session(['zoom_access_token' => $accessToken]);
        session(['zoom_logged_in' => true]);
            // Jika terdapat parameter 'search' pada URL
        if ($request->query('search')) {
        session(['zoom_search_query' => $request->query('search')]);
        }

        return redirect()->route('zoom_meetings.create');
    }
}
