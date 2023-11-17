<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientsController;
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
// membuat protecting routes
Route::middleware(['auth:sanctum'])->group(function () {
    // Get all Resource
    Route::get('/patients', [PatientsController::class, 'index']);
    // Add Resource
    Route::post('/patients', [PatientsController::class, 'store']);
    // Get Detail Resource
    Route::get('/patients/{id}', [PatientsController::class, "show"]);
    // Edit Resource
    Route::put('/patients/{id}', [PatientsController::class, 'update']);
    // Delete Resource
    Route::delete('/patients/{id}', [PatientsController::class, 'destroy']);

    // Search Resource by name
    Route::get('/patients/search/{name}', [PatientsController::class, 'search']);
    // Get Positive Resource
    Route::get('/patients/status/positive', [PatientsController::class, 'positive']);
    // Get Recovered Resource
    Route::get('/patients/status/recovered', [PatientsController::class, 'recovered']);
    // Get Dead Resource
    Route::get('/patients/status/dead', [PatientsController::class, 'dead']);
});


// membuat route untuk register dan login
Route::post('/register', [AuthController::class, "register"]);
Route::post('/login', [AuthController::class, "login"]);
