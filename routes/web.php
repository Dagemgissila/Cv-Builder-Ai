<?php

use App\Http\Controllers\CvController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});
Route::post("/generate-cv", [CvController::class, "generateCv"])->name("cv.generate");
Route::post('/regenerate-cv', [CvController::class, 'regenerateCv'])->name('cv.regenerate');
Route::post('/generate-resume', [CvController::class, "GenerateResume"])->name("GenerateResume");