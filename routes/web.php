<?php

use App\Http\Controllers\ConduitController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ConduitController::class, 'showList']);

Route::get('/article', function () {
    return view('conduit.article');
});

Route::get('/editor', function () {
    return view('conduit.editor');
});
