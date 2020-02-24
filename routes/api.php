<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * @var Authanticatin_Routes
 **/
Route::post('/register','UserController@register');
Route::post('/login','UserController@login');



/**
 * @var Cars_Routes
 **/
Route::middleware('auth:api')->post('/addSparePart','Car\CarController@addSparePart');
Route::get('/showSparePart','Car\CarController@showSparePart');

Route::get('/test','Car\CarController@test');


