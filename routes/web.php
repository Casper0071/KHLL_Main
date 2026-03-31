<?php

use Inertia\Inertia;

Route::get('/', fn() => Inertia::render('Dashboard'))->name('dashboard');
Route::get('/components', fn() => Inertia::render('Components'))->name('components');



