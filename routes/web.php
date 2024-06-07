<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [UserController::class, 'login'])->name('login');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/insertTeam', [UserController::class, 'insertTeam'])->name('insertTeam');
Route::post('/login', [UserController::class, 'doLogin'])->name('dologin');

//Admin
Route::get('/indexAdmin', [StepController::class, 'indexAdmin'])->name('indexAdmin');
Route::get('/search', [StepController::class, 'searchMultiMot'])->name('search');
Route::get('/runnerListStep/{id}', [StepController::class, 'RunnerByIdStep'])->name('runnerListStep');
Route::post('/insertStep', [StepController::class, 'insertStep'])->name('insertStep');
Route::post('/editStep', [StepController::class, 'editStep'])->name('editStep');
Route::post('/insertTimeRunner', [StepController::class, 'insertTimeRunner'])->name('insertTimeRunner');
Route::get('/rankingGByStep', [RankingController::class, 'indexRankingStep'])->name('rankingGByStep');
Route::get('/showRankingGByStep', [RankingController::class, 'showRankingByStep'])->name('showRankingGByStep');
Route::post('/showRankingGByCateg', [RankingController::class, 'RankingTeamByCategorie'])->name('showRankingGByCateg');
Route::get('/rankingGByTeam', [RankingController::class, 'RankingTeam'])->name('rankingGByTeam');
Route::get('/import1', function () {
    return view('pages.admin.importDonne');
})->name('import1');
Route::post('/importStepsResults', [ImportController::class, 'importStepsResults'])->name('importStepsResults');
Route::get('/import2', function () {
    return view('pages.admin.importPoint');
})->name('import2');
Route::post('/importPoint', [ImportController::class, 'importPoint'])->name('importPoint');
Route::post('/generateCategory', [CategoryController::class, 'generateCategories'])->name('generateCategory');
Route::get('/penalityList', [TeamController::class, 'getAllPenality'])->name('penalityList');
Route::post('/insertPenality',[TeamController::class,'insertPenality'])->name('insertPenality');
Route::delete('/deletePenality',[TeamController::class,'destroyPenality'])->name('deletePenality');
Route::get('/exportPDF', [TeamController::class, 'exportPDF'])->name('exportPDF');

//Team
Route::get('/indexTeam', [StepController::class, 'indexTeam'])->name('indexTeam');
Route::get('/listChronoRunner', [TeamController::class, 'getChronoRunnerById'])->name('listChronoRunner');
Route::get('/runnerList', [TeamController::class, 'RunnerByTeam'])->name('runnerList');
Route::post('/insertStepRunner', [StepController::class, 'insertStepRunner'])->name('insertStepRunner');
Route::get('/rankingGByStepTeam', [RankingController::class, 'indexRankingStepTeam'])->name('rankingGByStepTeam');
Route::get('/showRankingGByStepTeam', [RankingController::class, 'showRankingByStepTeam'])->name('showRankingGByStepTeam');
Route::get('/rankingGByTeamTeam', [RankingController::class, 'RankingTeamTeam'])->name('rankingGByTeamTeam');
Route::get('/searchTeam', [StepController::class, 'searchMultiMotTeam'])->name('searchTeam');
Route::post('/alea', [RankingController::class, 'RankingElea'])->name('alea');
//logout
Route::delete('/logout',[UserController::class,'logout'])->name('logout');
Route::get('/reinitialisation', [UserController::class, 'trun'])->name('reinitialisation');
