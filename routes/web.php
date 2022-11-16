<?php

use Illuminate\Support\Facades\Route;
use App\Jobs\CreateOrder;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/create-order/{id}/{queue}', function($id, $queue) {
    if (!in_array($queue, ['default-queue', 'another-queue'])) {
        return response()->json([
            'error_message' => "目前沒有提供 ${queue} Queue"
        ]);
    }

    CreateOrder::dispatch($id)->onQueue($queue);

    return response()->json([
        'status'    => 'done',
        'orderId'   => $id,
        'queue'     => $queue
    ]);
});
