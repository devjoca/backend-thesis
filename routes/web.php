<?php

use Zttp\Zttp;

Route::get('/', function () {
    return redirect('persons');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/persons', 'PersonsController@index');
Route::get('/persons/create', 'PersonsController@create');
Route::post('/persons/store', 'PersonsController@store');
Route::post('/persons/delete', 'PersonsController@delete');
Route::get('/persons/{person_id}/photo', 'PersonsController@showPhoto');
Route::post('/persons/{person_id}/photo/store', 'PersonsController@storePhoto');
Route::get('/persons/search', 'PersonsController@search');
Route::post('/persons/detect', 'PersonsController@detect');
Route::get('/persons/train', 'PersonsController@train');
Route::get('/persons/train-status', 'PersonsController@trainStatus');

Route::get('/person-group/store', function() {
    $response = Zttp::withHeaders(['Ocp-Apim-Subscription-Key' => env('AZURE_KEY')])
               ->put('https://eastus2.api.cognitive.microsoft.com/face/v1.0/persongroups/person-data', [
                    'name' => 'Personas Registradas',
                ]);

    return $response->json();
});
