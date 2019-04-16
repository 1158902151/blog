<?php
/**
 * @copyright 杭州
 * @author     xieqiyong66@gmail.com
 */

use Carbon\Carbon;
use App\Models\Area;
use Uuid as UUID;
use App\Models\Sms;
function isDebug()
{
    return env("APP_DEBUG");
}

function isLocal()
{
    return env('APP_ENV') === 'local' ?: false;
}

function isDev()
{
    return env('APP_ENV') === 'dev' ?: false;
}

function isProd()
{
    return env('APP_ENV') === 'prod' ?: false;
}

function moveFiles($files, $targetDir)
{
    is_dir($targetDir) || @mkdir($targetDir, 0777, true);
    $path = env("UPLOAD_DIR");
    foreach ($files as $value) {
        $temp = $path . $value;
        $newPath = $targetDir . "/" . $value;
        if(is_file($temp)){
            rename($temp, $newPath);
        }
    }
}

/**
 * @param bool $isMulti
 * @return array|null
 * 批量上传图片接口, 也可以单图片上传
 */
function uploadFile($isMulti = true)
{
    $files = Input::file("file");
    if(!$isMulti && count($files) > 1){
        return null;
    }
    if(isset($files)){
        $names = [];
        foreach ($files as $file) {
            if(!is_null($file) && $file->isValid()){
                $ext = $file->getClientOriginalExtension();
                $newName = Uuid::generate() . "." . $ext;
                $path = env("UPLOAD_DIR");
                $file->move($path, $newName);
                $names[] = $newName;
            }
        }
        return $names;
    }
    return null;
}

/**
 * @param $originName
 * @return string
 * 单图片上传
 */
function getUploadFileName($originName)
{
    $file = Input::file($originName);
    $ext = $file->getClientOriginalExtension();
    $newName = Uuid::generate() . "." . $ext;
    $path = env("UPLOAD_DIR");
    $file->move($path, $newName);
    return $newName;
}

// 获取新商品id
function build_item_no()
{
    $uniqId = strtoupper(dechex(date('y'))).date('m') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d',rand(0, 99));
    return $uniqId;
}

// 获取新优惠券id
function build_coupon_no($sufix = "")
{
    return strtoupper(base_convert(unique_id(), 10, 35) . base_convert($sufix, 10, 36));
}

function build_platform_coupon_no($sufix = "")
{
    return strtoupper('hq' . base_convert(unique_id(), 10, 36) . base_convert($sufix, 10, 36));
}

// 获取用户领取店铺优惠券的ID $index为第几张
function build_user_coupon_no($index)
{
    return build_coupon_no($index);
}

// 获取用户领取平台优惠券的ID $index为第几张
function build_user_platform_coupon_no($index)
{
    return build_platform_coupon_no($index);
}

// 获取新订单id
function build_order_no()
{
    return unique_id((intval(date('Y')) - 2018 + 1));
}

//默认最多16位 可加入前后缀，比如服务器，数据分区等进行分布式唯一
function unique_id($prefix = "", $sufix = "")
{
    $uniqId = $prefix . strtoupper(date('m') < 10 ? '0' . date('m') : date('m')).date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d',rand(0, 99)) . $sufix;
    return $uniqId;
}

function ErrorLog($error){
    $logName = 'logs/error/'. Carbon::today()->format('Y-m-d'). '.log';
    formatLog("Error", $error, get_caller_info(), $logName);
}

function InfoLog($info){
    $logName = 'logs/info/'. Carbon::today()->format('Y-m-d'). '.log';
    formatLog("Info", $info, get_caller_info(), $logName);
}

function CustomLog($logName, $str)
{
    Storage::append($logName, $str);
}

function formatLog($type, $info, $caller, $logName){
    $str = "\n";
    $str .= "------------------------------  " . $type . "  ------------------------------\n";
    $str .= "| Time		:	" . Carbon::now()->format("Y-m-d H:i:s") . "\n";
    $str .= "| Class	:	" . $caller["class"] . "\n";
    $str .= "| Func		:	" . $caller["func"] . "\n";
    $str .= "| Line		:	" . $caller["line"] . "\n";
    $str .= "| File		:	" . $caller["file"] . "\n";
    $str .= "| Content	:	\n| " . json_encode($info, JSON_UNESCAPED_UNICODE) . "\n";
    $str .= "---------------------------------------------------------------------";
    if($type == "Error"){
        Storage::append($logName, $str);
    }else if($type == "Info"){
        Storage::append($logName, $str);
    }
    $info['systemInfo'] = [
        'Class' => $caller["class"],
        'Func' => $caller["func"],
        'Line' => $caller["line"],
        'File' => $caller["file"],
    ];

    $otherInfo = [
        'extra' => $info,
        'level' => strtolower($type),
    ];
    if(!env('SENTRY_NEED_INFO_LOG',0)&&$type=='Info'){
        return true;
    }
    app('sentry')->captureMessage($logName,null,$otherInfo);

}

function get_caller_info() {
    $file = '';
    $func = '';
    $class = '';
    $line = -1;
    $trace = debug_backtrace();
    if (isset($trace[2])) {
        $file = $trace[1]['file'];
        $line = $trace[1]['line'];
        $func = $trace[2]['function'];
        if ((substr($func, 0, 7) == 'include') || (substr($func, 0, 7) == 'require')) {
            $func = '';
        }
    } else if (isset($trace[1])) {
        $file = $trace[1]['file'];
        $line = $trace[1]['line'];
        $func = '';
    }
    if (isset($trace[3]['class'])) {
        $class = $trace[3]['class'];
        $func = $trace[3]['function'];
        $file = $trace[2]['file'];
    } else if (isset($trace[2]['class'])) {
        $class = $trace[2]['class'];
        $func = $trace[2]['function'];
        $file = $trace[1]['file'];
    }
    // if ($file != '') $file = basename($file);
    return ["file" => $file, "func" => $func, "class" => $class, "line" => $line];
}

function chmodr($path, $filemode)
{
    if (!is_dir($path))
        return chmod($path, $filemode);

    $dh = opendir($path);
    while (($file = readdir($dh)) !== false)
    {
        if($file != '.' && $file != '..')
        {
            try{
                $fullpath = $path . DIRECTORY_SEPARATOR . $file;
                if(is_link($fullpath))
                    return FALSE;
                elseif(!is_dir($fullpath) && !chmod($fullpath, $filemode))
                    return FALSE;
                elseif(!chmodr($fullpath, $filemode))
                    return FALSE;
            }catch(\Exception $e){
                $log = ["msg" => "error occured when chmod", "path" => $fullpath];
                ErrorLog($log);
            }
        }
    }

    closedir($dh);

    if(chmod($path, $filemode))
        return TRUE;
    else
        return FALSE;
}

function isPlatformCoupon($couponId){
    $firstChar = substr($couponId, 0, 2);
    return $firstChar == env("PLATFORM_COUPON_PREFIX");
}

function verify_password($pw0, $pw1){
    return password_verify($pw0, $pw1);
}

function gen_password($pw){
    $options = [
        'cost' => 10
    ];
    return password_hash($pw, PASSWORD_BCRYPT, $options);
}

function micro(){
    return Carbon::now()->timestamp . Carbon::now()->micro;
}

function hashUid($str){
    return hash("sha1", $str);
}

function generateUid()
{
//    $userType = $userType ?? env("HEQIE");
//    return hashUid(uuid(). micro(). $userType);
}

// 随机生成一个用户昵称
function userNick()
{
    return 'love' . sprintf('%04d',rand(0, 1000)) . substr(base_convert(unique_id(), 10, 36), -4);
}

// 生成授权id
function nongCertNo()
{
    return 'love'. Carbon::now()->format('YmdHis'). Carbon::now()->micro. rand(100000000, 999999999);
}

function randomCode($len){
    $seed = [0,1,2,3,4,5,6,7,8,9];
    $code = '';
    for ($i=0; $i<$len; $i++) {
        $num = $seed[rand(0,9)];
        if($i == 0 && $num === 0){
            $num = 1;
        }
        $code .= $num;
    }
    return $code;
}

function genLoginKey($uid, $time){
    return md5($uid . $time . substr($uid, 0, 6) . substr($uid, -6));
}

function telephonePattern(){
    //return "/^1((3[0-9]|4[57]|5[0-35-9]|7[03678]|8[0-9])\\d{8}$)/";
    return "/^1[34578]\d{9}$/";
}

function getCityByTaoBao($ip)
{
    // ip 接口
    $url = "http://ip.taobao.com/service/getIpInfo.php?ip=" . $ip;
    // $urls = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=" . $ip;
    // 设置请求超时时间.
    $context = stream_context_create(array('http' => array('timeout' => 3)));
    if (!empty($ip = json_decode(@file_get_contents($url, 0, $context)))) {
        if ((string)$ip->code == '1') {
            return false;
        }
        $data = (array)$ip->data;
    } else {
        // $ip = json_decode(@file_get_contents($urls));
        // if ((string)$ip->ret == 0) {
        //     return false;
        // }
        // $data = array(
        //     'country' => $ip->country,
        //     'region' => $ip->province,
        //     'city' => $ip->city,
        //     'isp' => $ip->isp,
        // );
        $data = [];
    }
    return $data;
}

function my_array_flip(array $arr) {
    $res = [];
    foreach ($arr as $key => $value) {
        $res[(string)$value] = $key;
    }
    return $res;
}

function is_idcard( $id )
{
    $id = strtoupper($id);
    $regx = "/(^\d{15}$)|(^\d{17}([0-9]|X)$)/";
    $arr_split = array();
    if(!preg_match($regx, $id))
    {
        return FALSE;
    }
    if(15==strlen($id)) //检查15位
    {
        $regx = "/^(\d{6})+(\d{2})+(\d{2})+(\d{2})+(\d{3})$/";

        @preg_match($regx, $id, $arr_split);
        //检查生日日期是否正确
        $dtm_birth = "19".$arr_split[2] . '/' . $arr_split[3]. '/' .$arr_split[4];
        if(!strtotime($dtm_birth))
        {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    else      //检查18位
    {
        $regx = "/^(\d{6})+(\d{4})+(\d{2})+(\d{2})+(\d{3})([0-9]|X)$/";
        @preg_match($regx, $id, $arr_split);
        $dtm_birth = $arr_split[2] . '/' . $arr_split[3]. '/' .$arr_split[4];
        if(!strtotime($dtm_birth)) //检查生日日期是否正确
        {
            return FALSE;
        }
        else
        {
            //检验18位身份证的校验码是否正确。
            //校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。
            $arr_int = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
            $arr_ch = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
            $sign = 0;
            for ( $i = 0; $i < 17; $i++ )
            {
                $b = (int) $id{$i};
                $w = $arr_int[$i];
                $sign += $b * $w;
            }
            $n = $sign % 11;
            $val_num = $arr_ch[$n];
            if ($val_num != substr($id,17, 1))
            {
                return FALSE;
            } //phpfensi.com
            else
            {
                return TRUE;
            }
        }
    }

}
function clientIp()
{
    if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }elseif(isset($_SERVER['HTTP_ALI_CDN_REAL_IP'])){
        $ip = $_SERVER['HTTP_ALI_CDN_REAL_IP'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $ip_arr = explode(',', $ip);
    return $ip_arr[0];
}


function xml_to_array($source) {
    if(is_file($source)){ //传的是文件，还是xml的string的判断
        $xml_array=simplexml_load_file($source);
    }else{
        $xml_array=simplexml_load_string($source);
    }

    return object2array($xml_array);
}


function object2array($object) {
    $object =  json_decode( json_encode( $object),true);
    return  $object;
}

// 客户端环境
function clientEnv($userAgent=null) {

    if(empty($userAgent)){
        //临时方案
        return 3;
    }else{


        //$http_user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        $http_user_agent = strtolower($userAgent);

        $form_map = [
            'unknown' => 0,
            'android' => 1,
            'ios' => 2,
            'wap' => 3,
            'wechat' => 4,
            'alipay' => 5
        ];

        if (!empty($http_user_agent)) {
            // wechat
            if (strpos($http_user_agent, 'micromessenger') !== false) {
                return $form_map["wechat"];
                // app-ios
            } elseif (strpos($http_user_agent, 'baizu-ios') !== false) {
                return $form_map["ios"];
                // app-android
            } elseif (strpos($http_user_agent, 'baizu-android') !== false) {
                return $form_map["android"];
                // alipay
            } elseif (strpos($http_user_agent, 'alipayclient') !== false) {
                return $form_map["alipay"];
                // wap
            } else {
                return $form_map["wap"];
            }
        }

    }


}

/**
 * 计算距离当前时间
 * @param string $time
 * @author xieqiyong
 * @return string
 */
if(!function_exists('getNowTimeLength')) {
	function getNowTimeLength($time)
	{
		$str = "";
		$length = round((time() - $time)/(3600),2);
		if($length >= 24){
			$str = ceil($length/24).'天前';
			if($str >= 30){
				$patterns = "/\d+/";
				preg_match_all($patterns,$str,$arr);
				$str = floor($arr[0][0]/30).'个月前';
			}
		}
		if($length < 24 && $length >= 1){
			$str = round($length).'小时前';
		}
		if($length < 1){
			$str = ceil($length*60).'分钟前';
		}
		return $str;
	}
}

/**
 * 计算距离当前时间
 * @param string $time
 * @author xieqiyong
 * @return string
 */
if(!function_exists('sms_code')) {
    function sms_code($code,$phone,$type)
    {
        $sms = new Sms();
        $sms->insert(['code'=>$code,'phone'=>$phone,'type'=>$type,'ip'=>clientIp(),'created_at'=>date('Y-m-d H:i:s',time())]);
    }
}

/**
 * 模拟请求
 * @param string $url
 * @param array $header
 */
if (!function_exists('httpCurl')) {
	function httpCurl($url, $method = 'get', $data = '',$header=array())
	{
		$ch = curl_init();
		if(empty($header)){
			$header[] = "Content-type: text/xml"; // 改为数组解决
			$header[] = "application/json";
		}

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$temp = curl_exec($ch);
		return $temp;
	}
}
if (!function_exists('httpsCurl')) {
	function httpsCurl($method,$url,$headers,$host,$bodys){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_FAILONERROR, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		if (1 == strpos("$" . $host, "https://")) {
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		}
		curl_setopt($curl, CURLOPT_POSTFIELDS, $bodys);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$temp = curl_exec($curl);
		return $temp;
	}
}

/*
 * 设置加密信息
 * author  baoyun
 */
if (!function_exists('set_key_val')) {
	function set_key_val($value){
		return '' === $value ? '':$value.md5(clientIp().config('web.web_key').$value);
	}
}

/*
 * 解密信息
 * author  baoyun
 */
if (!function_exists('get_key_val')) {
	function get_key_val($key){
		if (!$key)return '';

		$md5 = substr($key, -32);
		$str = substr($key,0,-32);
		if ($md5 == md5(session_id().clientIp().config('web.web_key').$str)){
			return $str;
		}else{
			return '';
		}
	}
}
