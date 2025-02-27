<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\LectureController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('courses', CourseController::class);
Route::apiResource('courses.modules', ModuleController::class);
Route::apiResource('modules.lectures', LectureController::class);
Route::get('/modules/{moduleId}/lectures', [LectureController::class, 'index']);
Route::post('/courses/{courseId}/modules/{moduleId}/lectures', [LectureController::class, 'store']);
