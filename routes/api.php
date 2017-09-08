<?php

Route::post('/incidents', 'IncidentsController@store');
Route::get('/incidents', 'IncidentsController@index');
Route::get('/stations', 'StationsController@index');
Route::post('/stations/near', 'StationsController@findNear');