<?php

use App\Http\Controllers\TextToSpeechController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TypeController;

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
Auth::routes();
Route::group(['middleware' => 'role'], function () {
    // Các route được nhóm vào đây
    Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index']);
    Route::resource('category', CategoryController::class);
    Route::resource('type', TypeController::class);
    Route::resource('book', \App\Http\Controllers\BookController::class);
    Route::resource('chapter', \App\Http\Controllers\ChapterController::class);
    Route::get('getchap/{id}', [\App\Http\Controllers\BookController::class, 'getchapter'])->name('getchap');
    Route::resource('user', \App\Http\Controllers\UserController::class);
});

Route::get('/', [\App\Http\Controllers\TrangChuController::class, 'index']);
Route::get('bookbycat/{id}', [\App\Http\Controllers\TrangChuController::class, 'getbookbyId'])->name('bookbycat');
Route::get('bookbytype/{id}', [\App\Http\Controllers\TrangChuController::class, 'getbookbytype'])->name('bookbytype');
Route::get('xemsach/{id}', [\App\Http\Controllers\TrangChuController::class, 'bookdetail'])->name('xemsach');
Route::get('xemnoidungsach/{id}', [\App\Http\Controllers\TrangChuController::class, 'chapterdetail'])->name('docsach');
Route::get('search', [\App\Http\Controllers\TrangChuController::class, 'search'])->name('timkiem');
Route::get('/search_suggestions', [\App\Http\Controllers\TrangChuController::class, 'searchSuggestions'])->name('search.suggestions');
Route::get('like/{id}', [\App\Http\Controllers\TrangChuController::class, 'like'])->name('like');
Route::get('user_profile/{id}', [\App\Http\Controllers\TrangChuController::class, 'profile'])->name('profile');
Route::patch('capnhatuser/{id}', [\App\Http\Controllers\TrangChuController::class, 'capnhatuser'])->name('capnhatuser');

Route::post('theodoi/{id}', [\App\Http\Controllers\TrangChuController::class, 'theodoi'])->name('theodoi');
Route::delete('botheodoi/{id}', [\App\Http\Controllers\TrangChuController::class, 'botheodoi'])->name('botheodoi');
