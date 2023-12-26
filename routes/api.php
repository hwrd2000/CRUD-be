<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\DepartmentController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Manage employee
Route::resource('employees', EmployeeController::class);
Route::get('employees', [EmployeeController::class, 'index']);
Route::post('employees', [EmployeeController::class, 'store']);
Route::get('employees/{id}', [EmployeeController::class, 'show']);
Route::get('employees/{id}/edit', [EmployeeController::class, 'edit']);
Route::put('employees/{id}/edit', [EmployeeController::class, 'update']);
Route::delete('employees/{id}/delete', [EmployeeController::class, 'destroy']);


//Manage department
Route::resource('departments', DepartmentController::class);
Route::get('departments', [DepartmentController::class, 'index']);
Route::post('departments', [DepartmentController::class, 'store']);
Route::get('departments/{id}', [DepartmentController::class, 'show']);
Route::get('departments/{id}/edit', [DepartmentController::class, 'edit']);
Route::put('departments/{id}/edit', [DepartmentController::class, 'update']);
Route::delete('departments/{id}/delete', [DepartmentController::class, 'destroy']);


//Manage project
Route::resource('projects', ProjectController::class);
Route::get('projects', [ProjectController::class, 'index']);
Route::post('projects', [ProjectController::class, 'store']);
Route::get('projects/{id}', [ProjectController::class, 'show']);
Route::get('projects/{id}/edit', [ProjectController::class, 'edit']);
Route::put('projects/{id}/edit', [ProjectController::class, 'update']);
Route::delete('projects/{id}/delete', [ProjectController::class, 'destroy']);

