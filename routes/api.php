<?php

Route::post('/incidents', 'IncidentsController@store');
Route::get('/incidents', 'IncidentsController@index');
Route::post('/incidents/search', 'IncidentsController@search');
Route::get('/stations', 'StationsController@index');
Route::post('/stations/near', 'StationsController@findNear');
Route::post('/person/search', 'PeopleController@validateData');
Route::get('/person/{microsoftPersonId}', 'PeopleController@findByDocument');
Route::post('/criminalActs', 'CriminalActsController@store');