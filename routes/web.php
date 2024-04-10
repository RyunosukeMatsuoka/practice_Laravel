<?php

use App\Http\Controllers\ConduitController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ConduitController::class, 'showList'])->name('articles');

Route::get('/editor', [ConduitController::class, 'showEditor']);

Route::post('/editor/store', [ConduitController::class, 'exeStore'])->name('store');

Route::get('/article/{id}', [ConduitController::class, 'showDetail'])->name('detail');
