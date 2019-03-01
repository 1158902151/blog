<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/3/003
 * Time: 21:21
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = "menu";

    public static function menu()
    {
        $data = self::where('pid',0)->get();
        return !empty($data)?$data->toArray():null;
    }

    public static function menus()
    {
        $data = self::where('pid','<>',0)->get();
        return !empty($data)?$data->toArray():null;
    }
}