<?php

use Inertia\Inertia;




Route::get('/', fn() => Inertia::render('Home'))->name('Home');
Route::get('/harmonieLentekrans', fn() => Inertia::render('harmonieLentekrans'))->name('harmonieLentekrans');
Route::get('/opleidingsOrkest', fn() => Inertia::render('opleidingsOrkest'))->name('opleidingsOrkest');
Route::get('/components', fn() => Inertia::render('Components'))->name('components');


