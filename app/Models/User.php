<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/11/011
 * Time: 15:49
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = "admin_user";

    public $hidden = [
        "password"
    ];
}