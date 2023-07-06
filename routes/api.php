<?php

use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\ProjectMemberController;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\AuthController;
use App\Models\ProjectMember;
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

Route::prefix('v1')->middleware('throttle:60,1', 'auth:sanctum')->group(function () {


    Route::middleware(['checkrole:admin'])->group(function () {
        // Rutas para el rol de administrador
        Route::get('projects', [ProjectController::class, 'index']);
        Route::post('projects', [ProjectController::class, 'store']);
        Route::get('projects/{project}', [ProjectController::class, 'show']);
        Route::put('projects/{project}', [ProjectController::class, 'update']);
        Route::delete('projects/{project}', [ProjectController::class, 'destroy']);
    });

    Route::middleware(['checkrole:admin,user'])->group(function () {
        // Rutas para el rol de usuario
        Route::get('tasks', [TaskController::class, 'index']);
        Route::post('tasks', [TaskController::class, 'store']);
        Route::get('tasks/{task}', [TaskController::class, 'show']);
        Route::put('tasks/{task}', [TaskController::class, 'update']);
        Route::delete('tasks/{task}', [TaskController::class, 'destroy']);

        Route::get('project_member', [ProjectMemberController::class, 'index']);
        Route::post('project_member', [ProjectMemberController::class, 'store']);
        Route::get('project_member/{project_member}', [ProjectMemberController::class, 'show']);
        Route::put('project_member/{project_member}', [ProjectMemberController::class, 'update']);
        Route::delete('project_member/{project_member}', [ProjectMemberController::class, 'destroy']);
    });

});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
