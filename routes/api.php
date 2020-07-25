<?php

use App\Http\Controllers\API\Module\ProjectModuleController;
use App\Http\Controllers\API\Project\ProjectController;
use App\Http\Controllers\API\Project\ProjectStatusController;
use App\Http\Controllers\API\Requirement\RequirementAttachmentController;
use App\Http\Controllers\API\Requirement\RequirementCommentController;
use App\Http\Controllers\API\Requirement\RequirementController;
use App\Http\Controllers\API\User\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function() {
    Route::apiResource('projects', ProjectController::class);
    Route::any('project-statuses', ProjectStatusController::class);
    Route::apiResource('modules.requirements', RequirementController::class)->shallow();
    Route::resource('requirements.comments', RequirementCommentController::class)
        ->only(['index', 'store', 'destroy'])->shallow();
    Route::resource('requirements.attachments', RequirementAttachmentController::class)
        ->only(['index', 'store']);
    Route::apiResource('projects.modules', ProjectModuleController::class)->shallow();
    Route::resource('users', UserController::class)->only([
       'index', 'show'
    ]);

});

