<?php

use App\Http\Controllers\ConduitController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ConduitController::class, 'showList'])->name('articles');

Route::get('/create', [ConduitController::class, 'showCreate'])->name('create');

Route::post('/create/store', [ConduitController::class, 'exeStore'])->name('store');

Route::get('/article/{id}', [ConduitController::class, 'showDetail'])->name('detail');

Route::get('/editor/{id}', [ConduitController::class, 'showEditor'])->name('edit');

Route::post('/editor/update', [ConduitController::class, 'exeUpdate'])->name('update');
