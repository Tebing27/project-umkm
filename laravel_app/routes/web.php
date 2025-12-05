<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/auth/daftar', function () {
    return view('auth.daftar');
});

Route::get('/auth/masuk', function () {
    return view('auth.masuk');
});

Route::get('/users/dashboard', function () {
    return view('users.index');
});

Route::get('/users/lokasi', function () {
    return view('users.detail_lokasi');
});

Route::get('/users/lokasi/edit', function () {
    return view('users.input_lokasi');
});

Route::post('/users/lokasi/store', function () {
    return redirect('/users/lokasi');
});

Route::get('/users/toko', function () {
    return view('users.toko');
});

Route::get('/users/edit-toko', function () {
    return view('users.edit_toko');
});

Route::get('/users/setting', function () {
    return view('users.setting');
});

Route::get('/users/foto', function () {
    return view('users.kelola_foto');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/admin/users', function () {
    return view('admin.users');
});
Route::get('/admin/users/detail', function () {
    return view('admin.users.detail');
});
Route::get('/admin/setting', function () {
    return view('admin.setting');
});

Route::get('/toko', function () {
    return view('toko.index');
});

Route::get('/toko/detail', function () {
    return view('toko.detail');
});
