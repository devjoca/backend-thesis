<?php

Auth::routes();

Route::get('/', 'MapController@index');

Route::group(['prefix' => 'persons'], function () {
    Route::get('/', 'PersonsController@index');

    Route::get('/create', 'PersonsController@create');
    Route::post('/store', 'PersonsController@store');
    Route::post('/delete', 'PersonsController@delete');

    Route::get('/{person_id}/photo', 'PersonsController@showPhoto');
    Route::post('/{person_id}/photo/store', 'PersonsController@storePhoto');

    Route::get('/search', 'PersonsController@search');
    Route::post('/detect', 'PersonsController@detect');

    Route::get('/train', 'PersonsController@train');
    Route::get('/train-status', 'PersonsController@trainStatus');
});

Route::get('/person-group/store', function() {
    $response = Zttp\Zttp::withHeaders(['Ocp-Apim-Subscription-Key' => env('AZURE_KEY')])
               ->put('https://eastus2.api.cognitive.microsoft.com/face/v1.0/persongroups/person-data', [
                    'name' => 'Personas Registradas',
                ]);

    return $response->json();
});
