<?php

use Inertia\Inertia;




Route::get('/', fn() => Inertia::render('Home'))->name('Home');
Route::get('/HarmonieLentekrans', fn() => Inertia::render('HarmonieLentekrans'))->name('harmonieLentekrans');
Route::get('/OpleidingsOrkest', fn() => Inertia::render('OpleidingsOrkest'))->name('opleidingsOrkest');
Route::get('/Contact', fn() => Inertia::render('Contact'))->name('contact');


Route::get('admin', fn() => Inertia::render('admin/Dashboard'))->name('Dashboard');
Route::get('admin/Components', fn() => Inertia::render('admin/Components'))->name('components');
Route::get('admin/agenda', fn() => Inertia::render('admin/Agenda'))->name('components');
Route::get('admin/information', fn() => Inertia::render('admin/Informatie'))->name('components');


