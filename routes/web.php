<?php

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
    return view('index');
});

Route::get('/users', function () {
    return view('users', [
        'users' => [
            [
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'example@host.name',
                'canPublishPosts' => true,
                'createdAt' => '2020-01-01 00:00:00'
            ]
        ]
    ]);
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});