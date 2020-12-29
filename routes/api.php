<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\AdminController;




Route::post('/login', [UserController::class, 'authenticate']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/change-password', [UserController::class, 'changePassword']);



// Admin api url
Route::group(['prefix' => 'user'], function () {
    
    Route::get('/authed-user', [UserController::class, 'getAuthenticatedUser']);
    Route::post('/create-contact', [ContactController::class, 'createContact']);
    Route::get('/my-contacts', [ContactController::class, 'myContacts']);
    Route::get('/my-contact/{id}', [ContactController::class, 'myContact']);
    Route::post('/update-contact/{id}', [ContactController::class, 'updateContact']);
    Route::post('/delete-contact/{id}', [ContactController::class, 'deleteContact']);

});


// Admin api url
Route::group(['prefix' => 'admin'], function () {

    Route::post('/create-user', [AdminController::class, 'createTheUser']);
    Route::get('/all-users', [AdminController::class, 'getTheUsers']);
    Route::get('/all-users/{id}', [AdminController::class, 'getTheUser']);
    Route::post('/update-user/{id}', [AdminController::class, 'updateTheUser']);
    Route::post('/delete-user/{id}', [AdminController::class, 'deleteTheUser']);

});

