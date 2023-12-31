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
        Route::get('projects-all', [ProjectController::class, 'getAllUsers']);
    });

    Route::middleware(['checkrole:admin,user-regular'])->group(function () {
        // Rutas para el rol de usuario
        Route::get('projects', [ProjectController::class, 'index']);
        Route::post('projects', [ProjectController::class, 'store']);
        Route::get('projects/{project}', [ProjectController::class, 'show']);
        Route::put('projects/{project}', [ProjectController::class, 'update']);
        Route::delete('projects/{project}', [ProjectController::class, 'destroy']);
        Route::get('projects-filters', [ProjectController::class, 'filters']);

        Route::get('tasks', [TaskController::class, 'index']);
        Route::post('tasks', [TaskController::class, 'store']);
        Route::get('tasks/{task}', [TaskController::class, 'show']);
        Route::put('tasks/{task}', [TaskController::class, 'update']);
        Route::delete('tasks/{task}', [TaskController::class, 'destroy']);
        Route::get('tasks-filters', [TaskController::class, 'filters']);

       /* Route::get('project_member', [ProjectMemberController::class, 'index']);
        Route::post('project_member', [ProjectMemberController::class, 'store']);
        Route::get('project_member/{project_member}', [ProjectMemberController::class, 'show']);
        Route::put('project_member/{project_member}', [ProjectMemberController::class, 'update']);
        Route::delete('project_member/{project_member}', [ProjectMemberController::class, 'destroy']);
        Route::get('project_member/{data}', [ProjectMemberController::class, 'filters']);*/
    });

});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
