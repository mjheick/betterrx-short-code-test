<?php

use Illuminate\Support\Facades\Route;

/* Serving some files */
Route::get('/', function() {
	$filename = public_path('frontend.php');
	require_once($filename);
	return;
});

Route::get('/{file}', function ($file) {
	$filename = public_path($file);
	if (file_exists($filename)) {
		return file_get_contents($filename);
	} else {
		return abort(404);
	}
});

Route::get('/search/{by}/{query}/{page}', function ($by, $query, $page) {
	
});