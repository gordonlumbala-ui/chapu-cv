<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CertificationController;
use App\Http\Controllers\Api\CvController;
use App\Http\Controllers\Api\CvTemplateController;
use App\Http\Controllers\Api\EducationController;
use App\Http\Controllers\Api\ExperienceController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\MobileCvController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SkillController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user(),
        ]);
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'deactivate']);

    Route::get('/mobile/cv', [MobileCvController::class, 'show']);
    Route::post('/mobile/cv/sync', [MobileCvController::class, 'sync']);

    Route::apiResource('cvs', CvController::class);
    Route::apiResource('educations', EducationController::class);
    Route::apiResource('experiences', ExperienceController::class);
    Route::apiResource('skills', SkillController::class);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('certifications', CertificationController::class);
    Route::apiResource('languages', LanguageController::class);

    Route::get('/cv-templates', [CvTemplateController::class, 'index']);
    Route::get('/cv-templates/{cvTemplate}', [CvTemplateController::class, 'show']);
});
