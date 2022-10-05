<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyResumeController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\ResumeController;
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

/**
 * 
 * Auth Routes
 * 
 */
Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/signup', [AuthController::class, 'signup']);

    Route::group([
        'middleware' => 'auth:api',
    ], function () {
        Route::get('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'getUser']);
    });
});
/**
 * 
 * Application Routes
 */
Route::group([
    'middleware' => 'auth:api',
], function () {
    Route::apiResource('jobs', JobsController::class)->except([
        'index',
    ]);
    Route::get('/company/jobs', [JobsController::class, 'company_jobs']);
    Route::apiResource('resumes', ResumeController::class)->except([
        'index'
    ]);
    Route::get('user/resumes', [ResumeController::class, 'user_resumes']);
    Route::apiResource('companies', CompanyController::class);
    Route::apiResource('companies.resumes', CompanyResumeController::class);
    Route::apiResource('users.jobs', CompanyResumeController::class);
});

Route::get('/jobs', [JobsController::class, 'index']);
Route::get('/resumes', [JobsController::class, 'index']);
