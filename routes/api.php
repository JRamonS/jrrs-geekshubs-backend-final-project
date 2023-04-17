<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\UserController;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('/', function () {
    return view('welcome');
});

//Users by Admin
Route::group([
    'middleware' => ['auth:sanctum', 'isAdmin']
], function () {
    Route::get('/users', [UserController::class, 'getAllUsers']);
    Route::delete('/users/{id}', [UserController::class, 'deleteUser']);
});

//AllAppointments by Admin
Route::get('/appointments', [AppointmentController::class, 'getAllAppointments'])->middleware(['auth:sanctum', 'isAdmin']);

// AUTH
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    
});

//Pets Register and See by User
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::post('/pets', [PetController::class, 'registerPet']);
    Route::get('/pets', [PetController::class, 'getPetsByUser']);
});

//Appointment CRUD by User and Pet Already Register
Route::group([
    'middleware' => 'auth:sanctum'
], function () {
    Route::get('/appointment', [AppointmentController::class, 'getAppointmentsByUser']);
    Route::post('/appointment', [AppointmentController::class, 'createAppointment']);
    Route::put('/appointment', [AppointmentController::class, 'updateAppointment']);
    Route::delete('/appointment', [AppointmentController::class, 'deleteAppointment']);
});



