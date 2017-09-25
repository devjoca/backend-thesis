<?php

Auth::routes();

Route::get('/', 'MapController@index');

Route::group(['prefix' => 'person'], function () {
    Route::get('/', 'PeopleController@index');

    Route::get('/create', 'PeopleController@create');
    Route::post('/store', 'PeopleController@store');
    Route::post('/delete', 'PeopleController@delete');

    Route::get('/{person_id}/photo', 'PeopleController@showPhoto');
    Route::post('/{person_id}/photo/store', 'PeopleController@storePhoto');

    Route::get('/search', 'PeopleController@search');
    Route::post('/detect', 'PeopleController@detect');

    Route::get('/train', 'PeopleController@train');
    Route::get('/train-status', 'PeopleController@trainStatus');
});

Route::group(['middleware' => 'auth'], function() {
    Route::get('/comisarias', 'StationsController@list');
    Route::get('/comisarias/{station_id}/atenciones', 'StationsController@listOfCriminalActs');
    Route::get('/comisarias/{station_id}/puntos-conflicto', 'StationsController@hotspots');
});

Route::get('/person-group/store', function() {
    $response = Zttp\Zttp::withHeaders(['Ocp-Apim-Subscription-Key' => env('AZURE_KEY')])
               ->put('https://eastus2.api.cognitive.microsoft.com/face/v1.0/persongroups/person-data', [
                    'name' => 'Personas Registradas',
                ]);

    return $response->json();
});
