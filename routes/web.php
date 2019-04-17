<?php

Route::group(['namespace'=>"blog"],function(){
	Route::get('/',"IndexController@index");
	Route::get('/articles/post/{id?}.html',"IndexController@detail");
	Route::get('/swoole/chat',"IndexController@chat");
	Route::post('/article/view',"IndexController@view");
	Route::get('/message/sub',"IndexController@sub");
	Route::get('/message/push',"IndexController@push");
	Route::get('/article/lists',"IndexController@articleLists");
});

