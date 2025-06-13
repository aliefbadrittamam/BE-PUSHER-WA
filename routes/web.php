<?php

use Pusher\Pusher;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\PusherController;

// Route::get('/', function () {
//     $pusher = new Pusher(
//         env('PUSHER_APP_KEY'),
//         env('PUSHER_APP_SECRET'),
//         env('PUSHER_APP_ID'),
//         [
//             'cluster' => env('PUSHER_APP_CLUSTER'),
//             'useTLS' => true,
//         ]
//     );
//     $data = ['message' => 'Hello, adit'];
//     $pusher->trigger('my-channel', 'my-event', $data);
//     // return view(view: 'welcome');
// });

Route::get('/', action: [PusherController::class, 'index']);
// make for method receive
Route::get('/broadcast', [PusherController::class, 'broadcast']);
Route::get('/receive', [PusherController::class, 'receive']);