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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class IndexController extends Controller
{
	public function index(Request $request)
	{
		$pages = $request->input('page',1);
		$aic_list = Cache::get('aic_list_'.$pages);
		if(!$aic_list){
			$aic_list = Articles::where('uid',16)->where('is_top',1)->orderBy('id','DESC')->paginate(5);
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

	public function chat()
	{
		return view('chat',['title'=>'swoole聊天室']);
	}

	/**
	 * 回复评论
	 * @author xieqiyong
	 */
	public function view(Request $request)
	{
		$id      = $request->input('id','');
		if(!$id){
			return response()->json(['code'=>400,'msg'=>"参数缺失"]);
		}
		$res = DB::table('articles')->where('id',$id)->increment('view',1);
		if(!$res){
			return response()->json(['code'=>400,'msg'=>"回复失败"]);
		}
		return response()->json(['code'=>200,'msg'=>"回复成功"]);
	}

	public function sub(Request $request)
	{
		Redis::subscribe(['channel'], function ($message) {
			echo $message;
		});
	}

	public function push(Request $request)
	{
		$content = $request->contents;
		Redis::publish('channel', $content);
	}
}