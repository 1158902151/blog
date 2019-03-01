<?php
/**
 * @copyright 杭州融远信息科技有限公司
 * @author     xieqiyong66@gmail.com
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    public function users()
    {
        return $this->hasOne('App\\Models\\User','id','uid');
    }

    public function comments()
    {
        return $this->hasMany('App\\Models\\Comment','content_id','id');
    }
}
