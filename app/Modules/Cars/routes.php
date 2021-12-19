<?php

Route::group(['middleware' => ['web'],'prefix' => 'cars', 'namespace' => 'App\Modules\Cars\Controllers'], function () {

	// get all cars from table car
	Route::get('/','CarsController@getCars');

	// get car by specic car id from table car
	Route::get('{id}','CarsController@getCarsByID');

	// inserting the record 
	Route::post('add','CarsController@insertCarRecord');

	// update record
	Route::post('update/{id}','CarsController@updateRecord');

	// delete record from BD
	Route::delete('{id}','CarsController@deleteCarByID');

});