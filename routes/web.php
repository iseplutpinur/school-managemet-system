<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

// user
use App\Http\Controllers\Backend\UserController;

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
    return view('auth.login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('admin.index');
})->name('dashboard');

Route::get('admin/logout', [AdminController::class, 'logout'])->name('admin.logout');


// user management all route
Route::get('user/view', [UserController::class, 'userView'])->name('user.view');
Route::get('user/add', [UserController::class, 'userAdd'])->name('user.add');
