User
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {

    Route::middleware(['guest'])->group(function(){
        Route::get('login', function(){
            return view ('login');
            });
    Route::post('login', [AuthController::class, 'login']);
        
    });

    Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'auth'], function ($router) {
        Route::get('/admin', [AdminController::class, 'admin'])->name('admin.dashboard');
        Route::get('/admin/manage_users', [AdminController::class, 'manageUsers'])->name('admin.manage_users');
    });
    
    
    
    Route::get('register', function(){
        return view ('register');
        });

    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

});