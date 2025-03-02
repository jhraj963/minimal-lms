<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\AuthController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('register', '_register');
    Route::post('login', '_login');
});

Route::apiResource('courses', CourseController::class);
Route::apiResource('courses.modules', ModuleController::class);
Route::apiResource('modules.lectures', LectureController::class);
Route::get('/modules/{moduleId}/lectures', [LectureController::class, 'index']);
Route::post('/courses/{courseId}/modules/{moduleId}/lectures', [LectureController::class, 'store']);
Route::prefix('courses/{course}')->group(function () {
    Route::get('modules', [ModuleController::class, 'index']);       // List modules
    Route::get('modules/{module}', [ModuleController::class, 'show']); // Fetch single module
    Route::post('modules', [ModuleController::class, 'store']);      // Create module
    Route::put('modules/{module}', [ModuleController::class, 'update']); // Update module
    Route::delete('modules/{module}', [ModuleController::class, 'destroy']); // Delete module
});
// Route::prefix('courses/{course}')->group(function () {
//     Route::prefix('modules/{module}')->group(function () {
//         Route::get('courses/{courseId}/modules/{moduleId}/lectures', [LectureController::class, 'index']);
//         Route::get('lectures/{lecture}', [LectureController::class, 'show']); // Fetch single lecture
//         Route::post('lectures', [LectureController::class, 'store']);      // Create lecture
//         Route::put('lectures/{lecture}', [LectureController::class, 'update']); // Update lecture
//         Route::delete('lectures/{lecture}', [LectureController::class, 'destroy']); // Delete lecture
//     });
// });
