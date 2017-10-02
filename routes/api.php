<?php

Route::post('/incidents', 'IncidentsController@store');
Route::get('/incidents', 'IncidentsController@index');
Route::post('/incidents/search', 'IncidentsController@search');
Route::get('/stations', 'StationsController@index');
Route::get('/stations/{station_id}', 'StationsController@find');
Route::post('/stations/near', 'StationsController@findNear');
Route::post('/person/search', 'PeopleController@validateData');
Route::get('/person/{microsoftPersonId}', 'PeopleController@findByDocument');
Route::post('/criminalActs', 'CriminalActsController@store');

Route::get('/v1/incidents', 'Api\IncidentsController@index')->middleware('auth:passport-api');