<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2019/3/1
 * Time: 17:06
 */

namespace App\Http\Controllers\blog;


use App\Http\Controllers\Controller;

class CommonController extends Controller
{
	/**
	 * 返回数据
	 * @author xieqiyong
	 */
	public function info($data=null,$code=null,$msg=null)
	{
		$array = ['code'=>empty($code)?200:$code,'msg'=>empty($msg)?'操作成功':$msg,'data'=>$data];
		return response()->json($array);
	}
	/**
	 * 返回数据
	 * @author xieqiyong
	 */
	public function _error($code=null,$msg=null)
	{
		$array = ['code'=>empty($code)?400:$code,'msg'=>empty($msg)?'操作成功':$msg,'data'=>false];
		return response()->json($array);
	}
}