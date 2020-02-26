<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * @var Authantication_Routes
 **/
Route::post('/register','UserController@register');
Route::post('/login','UserController@login');



/**
 * @var SpareParts_Routes
 **/
Route::middleware('auth:api')
->post('/addSparePart','Car\SparePartController@addSparePart');
Route::get('/showSparePart','Car\SparePartController@showSparePart');


/**
 * @var Cars_Routes
 **/
Route::middleware('auth:api')
->post('/addCar','Car\CarController@addCar');
Route::get('/showCarsForSell','Car\CarController@showCarsForSell');

Route::get('/showCarModel','Car\CarController@showCarModel');












Route::get('/test','Car\CarController@test');


