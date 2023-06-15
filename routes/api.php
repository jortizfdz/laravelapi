<?php

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
Route::apiResource('books', App\Http\Controllers\BookController::class);
Route::get('books/list/all', [App\Http\Controllers\BookController::class, 'list'])->name('books.list');
Route::post('books/searchBy/all', [App\Http\Controllers\BookController::class, 'search'])->name('books.search');
Route::apiResource('addresses', App\Http\Controllers\AddressController::class);
Route::apiResource('authors', App\Http\Controllers\AuthorController::class);
Route::get('authors/list/all', [App\Http\Controllers\AuthorController::class, 'list'])->name('authors.list');
Route::apiResource('editorials', App\Http\Controllers\EditorialController::class);
Route::get('editorials/list/all', [App\Http\Controllers\EditorialController::class, 'list'])->name('editorials.list');
Route::apiResource('libraries', App\Http\Controllers\LibraryController::class);
Route::get('libraries/list/all', [App\Http\Controllers\LibraryController::class, 'list'])->name('libraries.list');

Route::post('login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return $user->createToken($request->device_name)->plainTextToken;
});
