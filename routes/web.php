<?php

use App\Http\Controllers\CertificationController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\CvTemplateController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.manage');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/photo', [ProfileController::class, 'destroyPhoto'])->name('profile.photo.destroy');
    Route::post('/profile/deactivate', [ProfileController::class, 'deactivate'])->name('profile.deactivate');

    Route::get('/dashboard', function () {
        return match (strtolower((string) Auth::user()->role)) {
            'admin' => view('Admin.dashboard'),
            'client' => view('client.dashboard'),
            default => view('guest.dashboard'),
        };
    })->name('dashboard');

    Route::resource('cvs', CvController::class);
    Route::post('cvs/{cv}/duplicate', [CvController::class, 'duplicate'])->name('cvs.duplicate');
    Route::post('cvs/{cv}/default', [CvController::class, 'setDefault'])->name('cvs.default');
    Route::post('cvs/{cv}/toggle-public', [CvController::class, 'togglePublic'])->name('cvs.toggle-public');

    Route::resource('educations', EducationController::class);
    Route::resource('experiences', ExperienceController::class);
    Route::resource('skills', SkillController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('certifications', CertificationController::class);
    Route::resource('languages', LanguageController::class);

    Route::get('templates', [CvTemplateController::class, 'index'])->name('templates.index');
    Route::get('templates/{cvTemplate}', [CvTemplateController::class, 'show'])->name('templates.show');
});
