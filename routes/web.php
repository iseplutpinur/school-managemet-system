<?php
// utility
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

// model
use App\Models\User;

// controller
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\LoginController;

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

// home default
Route::get('/', function () {
    return view('auth.login');
});

// auth
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/login2', [LoginController::class, 'index'])->name('login2');
Route::post('/login', [LoginController::class, 'check_login'])->name('login.check_login');
Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');

Route::get('/home', function () {
    $user = Auth::user();
    $role = isset($user->role) ? $user->role : null;
    switch ($role) {
        case User::ROLE_ADMIN:
            return Redirect::route('admin.dashboard');
            break;

        default:
            return '';
            break;
    }
})->name('dashboard');

// user management all route
Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'verified', 'admin']], function () {
    Route::get('/dashboard', function () {
        return view('admin.index', ['page_attr' => ['title' => 'Dashboard']]);
    })->name('admin.dashboard');

    // user
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.user');
        Route::post('/', [UserController::class, 'store'])->name('admin.user.store');
        Route::delete('/', [UserController::class, 'delete'])->name('admin.user.delete');
        Route::put('/', [UserController::class, 'put'])->name('admin.user.put');
    });
});


// learn
Route::get('ajax-crud-datatable', [CompanyController::class, 'index'])->name('company');
Route::post('store-company', [CompanyController::class, 'store']);
Route::post('edit-company', [CompanyController::class, 'edit']);
Route::post('delete-company', [CompanyController::class, 'destroy']);
