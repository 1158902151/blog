<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2019/2/27
 * Time: 14:48
 */
namespace App\Http\Controllers\blog;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
	public function index()
	{
		return view('index');
	}
}