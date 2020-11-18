<?php

use App\Http\Controllers\API\History\RequirementHistoryController;
use App\Http\Controllers\API\Module\ProjectModuleController;
use App\Http\Controllers\API\Project\ProjectController;
use App\Http\Controllers\API\Project\ProjectStatusController;
use App\Http\Controllers\API\Requirement\RequirementAttachmentController;
use App\Http\Controllers\API\Requirement\RequirementCommentController;
use App\Http\Controllers\API\Requirement\RequirementController;
use App\Http\Controllers\API\Requirement\RequirementPriorityController;
use App\Http\Controllers\API\Requirement\RequirementStatusController;
use App\Http\Controllers\API\Requirement\RequirementTestCaseController;
use App\Http\Controllers\API\TestCase\TestCaseCommentController;
use App\Http\Controllers\API\TestCase\TestCaseLogController;
use App\Http\Controllers\API\User\UserController;
use App\Http\Controllers\Auth\MobileLoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Requirement\UpdateRequirementParentIdController;
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

Route::post('mobile-login', [MobileLoginController::class, 'login'])->name('mobile.login');
Route::post('mobile-register', [RegisterController::class, 'register'])->name('mobile.register');

Route::middleware(['auth:sanctum'])->group(function () {
//Route::middleware([])->group(function () {

    Route::post('mobile-logout', [MobileLoginController::class, 'logout'])->name('mobile.logout');
    // projects
    Route::apiResource('projects', ProjectController::class);

    Route::any('project-statuses', ProjectStatusController::class);

    // modules and requirements
    Route::resource('modules.requirements', RequirementController::class)->shallow()
        ->only(['store', 'show', 'update', 'destroy']);

    // modules and comments
    Route::resource('requirements.comments', RequirementCommentController::class)
        ->only(['index', 'store', 'destroy'])->shallow();

    // requirements and attachments
    Route::resource('requirements.attachments', RequirementAttachmentController::class)
        ->only(['index', 'store']);

    // project and modules
    Route::apiResource('projects.modules', ProjectModuleController::class)->shallow();

    // users
    Route::resource('users', UserController::class)->only([
        'index', 'show'
    ]);

    Route::resource('requirements.test-cases', RequirementTestCaseController::class)
        ->shallow()
        ->parameters([
            'requirements' => 'requirement', 'test-cases' => 'testCase'
        ]);

    Route::resource('test-cases.comments', TestCaseCommentController::class)->only([
        'index', 'store'
    ]);

    Route::get('test-cases/{testCase}/logs', TestCaseLogController::class);

    Route::any('requirement-statuses', RequirementStatusController::class);

    Route::any('requirement-priorities', RequirementPriorityController::class);

    Route::patch('requirements/{requirement}/update-parent-id', UpdateRequirementParentIdController::class);

    Route::get('requirements/{requirement}/histories', RequirementHistoryController::class);

});

