<?php

namespace App\Http\Controllers;

use Pusher\Pusher;
use Illuminate\Http\Request;

class PusherController extends Controller
{


    public function index()
    {
        // Menampilkan halaman chat
        return view('welcome'); // Ganti dengan view yang sesuai
    }
  
    public function broadcast(Request $request)
    {
        // Handle CORS untuk development
        // if ($request->isMethod('OPTIONS')) {
        //     return response()->json('OK', 200, [
        //         'Access-Control-Allow-Origin' => '*',
        //         'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS',
        //         'Access-Control-Allow-Headers' => 'Content-Type, X-CSRF-TOKEN, Accept'
        //     ]);
        // }

        // Validasi input
        $request->validate([
            'message' => 'required|string|max:1000',
            'sender' => 'required|string|max:100',
            'event' => 'required|string|max:100',
        ]);

     $channel = 'my-channel';
    $event = $request->input('event');
    $message = $request->input('message');
    $sender = $request->input('sender');
    $browserId = $request->input('browserId');

        try {
            // Initialize Pusher
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                [
                    'cluster' => env('PUSHER_APP_CLUSTER'),
                    'useTLS' => true,
                ]
            );

            // Data yang akan dikirim
            $data = [
                'message' => $message,
        'sender' => $sender,
        'browserId' => $browserId,
        'timestamp' => now()
            ];

            // Broadcast ke channel
            $pusher->trigger($channel, $event, $data);

            return response()->json([
                'status' => 'success',
                'message' => 'Message broadcasted successfully'
            ], 200, [
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS',
                'Access-Control-Allow-Headers' => 'Content-Type, X-CSRF-TOKEN, Accept'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to broadcast message: ' . $e->getMessage()
            ], 500, [
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS',
                'Access-Control-Allow-Headers' => 'Content-Type, X-CSRF-TOKEN, Accept'
            ]);
        }
    }
}