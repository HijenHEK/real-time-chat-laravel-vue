<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/discussions', [DiscussionController::class, 'index'])->name('discussions');
Route::post('/discussions', [DiscussionController::class, 'store'])->name('discussions.store');
Route::get('/discussions/{discussion}', [DiscussionController::class, 'show'])->name('discussions.show');

Route::post('/messages/{id}', [MessageController::class, 'store'])->name('messages.store');

Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
Route::delete('/contacts', [ContactController::class, 'destroy'])->name('contacts.store');
