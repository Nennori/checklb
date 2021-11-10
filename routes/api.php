<?php

use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChecklistController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:refresh')->post('/refresh', [AuthController::class, 'refresh']);
Route::middleware(['auth.access:access', 'auth:refresh'])->delete('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:access')->group(function() {
    Route::get('/checklist', [ChecklistController::class, 'index']);
    Route::post('/checklist', [ChecklistController::class, 'store']);
    Route::put('/checklist/{checklist}', [ChecklistController::class, 'update']);
    Route::get('/checklist/{checklist}', [ChecklistController::class, 'show']);
    Route::delete('/checklist/{checklist}', [ChecklistController::class, 'destroy']);
    Route::post('/checklist/{checklist}/task', [TaskController::class, 'store']);
    Route::put('/checklist/task/{task}', [TaskController::class, 'update']);
    Route::delete('/checklist/task/{task}', [TaskController::class, 'destroy']);
});

