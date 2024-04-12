<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

// ホーム画面を表示
Route::get('/', [HomeController::class, 'showList'])->name('articles');
// ホーム画面/タグで分類して表示
Route::get('tag/{id}', [HomeController::class, 'showSortList'])->name('sortArticles');
// ホーム画面/ユーザーの記事を表示
Route::get('/myArticles/{user_id}', [HomeController::class, 'showOwnList'])->name('ownArticles');
// 新規記事作成画面を表示
Route::get('/create', [ArticleController::class, 'showCreate'])->name('create');
// 新規記事を保存
Route::post('/create/store', [ArticleController::class, 'exeStore'])->name('store');
// 記事詳細を表示
Route::get('/article/{id}', [ArticleController::class, 'showDetail'])->name('detail');
// 既存記事編集画面を表示
Route::get('/editor/{id}', [ArticleController::class, 'showEditor'])->name('edit');
// 既存記事を更新し保存
Route::post('/editor/update', [ArticleController::class, 'exeUpdate'])->name('update');
// 既存記事を削除
Route::post('/article/delete/{id}', [ArticleController::class, 'exeDelete'])->name('delete');
