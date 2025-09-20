<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BetController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\TeamController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/predictions', [BetController::class, 'showPredictions'])->name('predictions');
    Route::get('/bets/create', [BetController::class, 'create'])->name('bets.create');
    Route::post('/bets', [BetController::class, 'store'])->name('bets.store');

    // Rutas de Ligas
    Route::resource('leagues', LeagueController::class);

    // Rutas de Equipos
    Route::resource('teams', TeamController::class);

    // Rutas del flujo de creación de partidos
    Route::prefix('matches/create')->name('matches.create.')->group(function () {
        Route::get('/', [App\Http\Controllers\MatchCreatorController::class, 'index'])->name('index');
        Route::get('/step1', [App\Http\Controllers\MatchCreatorController::class, 'step1'])->name('step1');
        Route::post('/step1', [App\Http\Controllers\MatchCreatorController::class, 'storeStep1'])->name('step1.store');
        Route::get('/step2', [App\Http\Controllers\MatchCreatorController::class, 'step2'])->name('step2');
        Route::post('/step2', [App\Http\Controllers\MatchCreatorController::class, 'storeStep2'])->name('step2.store');
        Route::get('/step3', [App\Http\Controllers\MatchCreatorController::class, 'step3'])->name('step3');
        Route::post('/step3', [App\Http\Controllers\MatchCreatorController::class, 'storeStep3'])->name('step3.store');
        Route::get('/step4', [App\Http\Controllers\MatchCreatorController::class, 'step4'])->name('step4');
        Route::post('/step4', [App\Http\Controllers\MatchCreatorController::class, 'storeStep4'])->name('step4.store');
        Route::get('/step5', [App\Http\Controllers\MatchCreatorController::class, 'step5'])->name('step5');
        Route::post('/step5', [App\Http\Controllers\MatchCreatorController::class, 'storeStep5'])->name('step5.store');
        Route::get('/analyze', [App\Http\Controllers\MatchCreatorController::class, 'analyze'])->name('analyze');
        Route::post('/confirm', [App\Http\Controllers\MatchCreatorController::class, 'confirm'])->name('confirm');
    });

    // API para obtener equipos por liga
    Route::get('/api/teams-by-league', [App\Http\Controllers\MatchCreatorController::class, 'getTeamsByLeague'])->name('api.teams-by-league');
});

require __DIR__.'/auth.php';
