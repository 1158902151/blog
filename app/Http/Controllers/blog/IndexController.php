<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2019/2/27
 * Time: 14:48
 */
namespace App\Http\Controllers\blog;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller
{
	public function index(Request $request)
	{
		$pages = $request->input('page',1);
		$aic_list = Cache::get('aic_list_'.$pages);
		if(!$aic_list){
			$aic_list = Articles::where('uid',16)->paginate(5);
			Cache::put('aic_list',$aic_list,120);
		}
		return view('index',['aic_list'=>$aic_list]);
	}

	public function detail(Request $request)
	{
		$id = $request->id;
		$id = get_key_val($id);
		if(!$id){
			return redirect('/');
		}
		$detail = Articles::where('id',$id)->first();
		return view('detail',['detail'=>$detail,'title'=>$detail->title]);
	}
}