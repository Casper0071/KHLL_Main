<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Publieke routes
Route::get('/', fn() => Inertia::render('Home'))->name('Home');
Route::get('/HarmonieLentekrans', fn() => Inertia::render('HarmonieLentekrans'))->name('harmonieLentekrans');
Route::get('/OpleidingsOrkest', fn() => Inertia::render('OpleidingsOrkest'))->name('opleidingsOrkest');
Route::get('/Contact', fn() => Inertia::render('Contact'))->name('contact');

// Agenda routes
Route::get('/agenda', fn() => Inertia::render('Agenda'))->name('agenda');
Route::get('/agenda/{id}', fn() => Inertia::render('AgendaDetail'))->name('agenda.detail');

// Admin routes
Route::get('admin', fn() => Inertia::render('admin/Dashboard'))->name('dashboard');
Route::get('admin/Components', fn() => Inertia::render('admin/Components'))->name('components');
Route::get('admin/agenda', fn() => Inertia::render('admin/Agenda'))->name('admin.agenda');
Route::get('admin/information', fn() => Inertia::render('admin/Informatie'))->name('admin.information');
