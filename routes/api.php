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
Route::post('/adminLogin','UserController@adminLogin');
Route::post('/uploadimage'  ,'UserController@uploadimge');
Route::middleware('auth:api')
->get('/profile'  ,'UserController@profile');
Route::middleware('auth:api')
->post('/checkPassword'  ,'UserController@checkPassword');
Route::middleware('auth:api')
->post('/editProfile'  ,'UserController@editProfile');
Route::get('/search','Car\SparePartController@search');
Route::get('/usedCarForSellSearch','Car\CarController@usedCarForSellSearch');
Route::get('/newCarForSellSearch','Car\CarController@newCarForSellSearch');


/**
 * @var Car_Model_Routes
 **/
Route::get('/showCarModel','Car\CarController@showCarModel');


/**
 * @var Car_For_Sell_Routes
 **/
Route::middleware('auth:api')
->post('/addCarForSell','Car\CarController@addCarForSell');
Route::get('/showNewCars','Car\CarController@showNewCars');
Route::get('/showUsedCars','Car\CarController@showUsedCars');


/**
 * @var SpareParts_Routes
 **/
Route::middleware('auth:api')
->post('/addSparePart','Car\SparePartController@addSparePart');
Route::get('/showSparePart','Car\SparePartController@showSparePart');


/**
 * @var CarPrice_Routes
 **/
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
 * @var Maintenance_Routes
 **/
Route::get('/showM_Types','Maintenance\MaintenanceController@showM_Types');
Route::get('/showM_Centers','Maintenance\MaintenanceController@showM_Centers');
Route::middleware('auth:api')
->post('/addM_Center','Maintenance\MaintenanceController@addM_Center');




/**
 * @var Service_Routes
 **/
Route::get('/SolarPrice_Advertise','Service\ServiceController@SolarPrice_Advertise');
Route::get('/showNews','Service\ServiceController@shownews');
Route::get('/showOffers','Service\ServiceController@showOffers');
Route::middleware('auth:api')
->post('/addOffer','Service\ServiceController@addOffer');
Route::middleware('auth:api')
->post('/addReport','Service\ServiceController@addReport');
Route::get('/showNotification/{id}','Service\ServiceController@showNotification');






/**
 * @var Admin_Routes
 **/
Route::group(['middleware' => ['auth:api', 'admin:api']], function() {



Route::get('/getAllUsers','Car\CarController@getAllUsers');


/**
 * @var SpareParts_Routes
 **/
Route::get('/pendingSparePart','Car\SparePartController@pendingSparePart');
Route::put('/acceptOrRejectSP','Car\SparePartController@acceptOrRejectSP');


/**
 * @var Car_For_Sell_Routes
 **/
Route::get('/pendingNewCars','Car\CarController@pendingNewCars');
Route::get('/pendingUsedCars','Car\CarController@pendingUsedCars');
Route::put('/acceptOrRejectCar','Car\CarController@acceptOrRejectCar');


/**
 * @var Offers_Routes
 **/
Route::get('/pendingOffers','Service\ServiceController@pendingOffers');
Route::put('/acceptOrRejectOffer','Service\ServiceController@acceptOrRejectOffer');


/**
 * @var Maintenance_Routes
 **/
Route::get('/pendingM_Centers','Maintenance\MaintenanceController@pendingM_Centers');
Route::put('/acceptOrRejectMC','Maintenance\MaintenanceController@acceptOrRejectMC');

Route::get('/showReport','Service\ServiceController@showReport');

Route::post('/addNews','Service\ServiceController@addNews');

Route::post('/addCar','Car\CarController@addCar');
Route::post('/addCarModel','Car\CarController@addCarModel');
Route::post('/addCarPrice','Car\CarController@addCarPrice');
});