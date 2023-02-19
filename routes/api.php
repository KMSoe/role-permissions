<?php

use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\StaffController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::get('/user', [AuthController::class, 'getUser'])->middleware('auth:api');
Route::post('/change-password', [AuthController::class, 'changePassword'])->middleware('auth:api');

Route::middleware(['auth:api'])->group(function () {
    // Dashboard
    Route::get('dashboard', DashboardController::class);

    // Staffs
    Route::resource('staffs', StaffController::class);
    Route::get('same-department-staffs', [StaffController::class, 'getByDepartment']);

    // Roles
    Route::resource('roles', RoleController::class);
    Route::get('role-list', [RoleController::class, 'roleList']);

    // Permissions
    Route::resource('permissions', PermissionController::class);
    Route::get('permission-list', [PermissionController::class, 'permissionList']);

});
