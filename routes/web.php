<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Publieke routes
Route::get('/', fn() => Inertia::render('Home'))->name('Home');
Route::get('/HarmonieLentekrans', fn() => Inertia::render('HarmonieLentekrans'))->name('harmonieLentekrans');
Route::get('/OpleidingsOrkest', fn() => Inertia::render('OpleidingsOrkest'))->name('opleidingsOrkest');
Route::get('/Contact', fn() => Inertia::render('Contact'))->name('contact');
Route::get('/login', fn() => Inertia::render('Login'))->name('login');

//privacy policy route
Route::get('/privacy', fn() => Inertia::render('Juridisch/Privacy'))->name('privacy');
Route::get('/disclaimer', fn() => Inertia::render('Juridisch/Disclaimer'))->name('disclaimer');


// Agenda routes
Route::get('/agenda', fn() => Inertia::render('Agenda'))->name('agenda');
Route::get('/agenda/{id}', fn() => Inertia::render('AgendaDetail'))->name('agenda.detail');

// Admin routes (beschermd)
Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    Route::get('/', fn() => Inertia::render('admin/Dashboard'))->name('dashboard');
    Route::get('/Components', fn() => Inertia::render('admin/Components'))->name('components');
    Route::get('/agenda', fn() => Inertia::render('admin/Agenda'))->name('admin.agenda');
    Route::get('/information', fn() => Inertia::render('admin/Informatie'))->name('admin.information');
    Route::get('/users', fn() => Inertia::render('admin/Users'))->name('admin.users')->middleware('admin');
});
