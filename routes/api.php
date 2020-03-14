<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * @var Authantication_Routes
 **/
Route::post('/register'     ,'UserController@register'  );
Route::post('/login'        ,'UserController@login'     );
Route::post('/uploadimage'  ,'UserController@uploadimge');



/**
 * @var Car_Model_Routes
 **/
Route::get('/showCarModel','Car\CarController@showCarModel');


/**
 * @var Car_For_Sell_Routes
 **/
Route::middleware('auth:api')
->post('/addCarForSell','Car\CarController@addCarForSell');
Route::get('/showCarsForSell','Car\CarController@showCarsForSell');


/**
 * @var SpareParts_Routes
 **/
Route::middleware('auth:api')
->post('/addSparePart','Car\SparePartController@addSparePart');
Route::get('/showSparePart','Car\SparePartController@showSparePart');


/**
 * @var CarPrice_Routes
 **/
Route::middleware('auth:api')
->post('/addCarPrice','Car\CarController@addCarPrice');
Route::get('/showCarPrice','Car\CarController@showCarPrice');


/**
 * @var Groups_Routes
 **/
Route::get('/showGroups','Group\GroupController@showGroups');

Route::get('/showPosts/{id}','Group\GroupController@showPosts');
Route::middleware('auth:api')
->post('/addPost','Group\GroupController@addPost');

Route::get('/showReplies/{id}','Group\GroupController@showReplies');
Route::middleware('auth:api')
->post('/addReply','Group\GroupController@addReply');

Route::middleware('auth:api')
->post('/addLike','Group\GroupController@addLike');



/**
 * @var Groups_Routes
 **/
Route::middleware('auth:api')
->post('/addM_Center','Maintenance\MaintenanceController@addM_Center');




Route::get('/test','Car\CarController@test');