<?php

Route::group(['namespace'=>"blog"],function(){
	Route::get('/',"IndexController@index");
	Route::get('/articles/post/{id?}.html',"IndexController@detail");
});

