<?php

Route::group(['namespace'=>"blog"],function(){
	Route::get('/',"IndexController@index");
});

