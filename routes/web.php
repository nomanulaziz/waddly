<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DatatableController;

// datatables routes
Route::get('/users', [UsersController::class, 'index'])->name('users.index');
// Route::put('/users/{id}', [UsersController::class, 'update'])->name('users.update');
// Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('users.delete');

//server side datatables routes
Route::get('/users/data', [UsersController::class, 'getUsersData'])->name('users.data');
// Route to show the edit form
Route::get('/users/{id}/edit', [UsersController::class, 'edit'])->name('users.edit');
// Route to update the user
Route::post('/users/{id}', [UsersController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');


// Route::get('/', [JobController::class, 'index']);
Route::get('/', [JobController::class, 'index'])->name('jobs.index');
Route::get('jobs/data', [JobController::class, 'getJobs'])->name('jobs.data');

Route::get('/jobs/{id}/edit', [JobController::class, 'edit'])->name('jobs.edit'); // Route to show the edit form
Route::post('/jobs/{id}', [JobController::class, 'update'])->name('jobs.update'); // Route to update the job
Route::delete('/jobs/{id}', [JobController::class, 'destroy'])->name('jobs.destroy'); // Route to delete the job

Route::get('/jobs/create', [JobController::class, 'create'])->middleware('auth');
Route::post('/jobs', [JobController::class, 'store'])->middleware('auth');

Route::get('/search', SearchController::class);
Route::get('/tags/{tag:name}', TagController::class); // tags/frontend

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create']);
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [SessionController::class, 'create']);
    Route::post('/login', [SessionController::class, 'store']);
});


Route::delete('/logout', [SessionController::class, 'destroy'])->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
