<?php

use App\Http\Controllers\ConduitController;
use Illuminate\Support\Facades\Route;

// ホーム画面を表示
Route::get('/', [ConduitController::class, 'showList'])->name('articles');
// ホーム画面/タグで分類して表示
Route::get('tag/{id}', [ConduitController::class, 'showSortList'])->name('sortArticles');
// 新規記事作成画面を表示
Route::get('/create', [ConduitController::class, 'showCreate'])->name('create');
// 新規記事を保存
Route::post('/create/store', [ConduitController::class, 'exeStore'])->name('store');
// 記事詳細を表示
Route::get('/article/{id}', [ConduitController::class, 'showDetail'])->name('detail');
// 既存記事編集画面を表示
Route::get('/editor/{id}', [ConduitController::class, 'showEditor'])->name('edit');
// 既存記事を更新し保存
Route::post('/editor/update', [ConduitController::class, 'exeUpdate'])->name('update');
// 既存記事を削除
Route::post('/article/delete/{id}', [ConduitController::class, 'exeDelete'])->name('delete');
