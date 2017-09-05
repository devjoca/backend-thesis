<?php

Route::post('/incidents', 'IncidentsController@store');
Route::get('/incidents', 'IncidentsController@index');