<?php

use Pusher\Pusher;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PusherController;

// Route untuk menampilkan halaman chat
Route::get('/', function () {
    return view('welcome'); // atau view yang berisi HTML chat Anda
});

// Route untuk broadcast pesan
Route::post('/broadcast', [PusherController::class, 'broadcast']);

// Route untuk testing manual (opsional)
Route::get('/send', function () {
    $pusher = new Pusher(
        env('PUSHER_APP_KEY'),
        env('PUSHER_APP_SECRET'),
        env('PUSHER_APP_ID'),
        [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true,
        ]
    );
    
    $data = [
        'message' => 'Hello from server!',
        'sender' => 'Server',
        'timestamp' => now()
    ];
    
    $pusher->trigger('my-channel', 'my-event', $data);
    
    return response()->json(['status' => 'Message sent from server']);
});