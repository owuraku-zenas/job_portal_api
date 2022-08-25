<?php

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

Route::apiResource('jobs', JobsController::class);
Route::apiResource('resumes', ResumeController::class);
Route::apiResource('companies', CompanyController::class);
Route::apiResource('companies.resumes', CompanyResumeController::class);
Route::apiResource('users.jobs', CompanyResumeController::class);