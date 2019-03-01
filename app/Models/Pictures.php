<?php
/**
 * @copyright 杭州融远信息科技有限公司
 * @author     xieqiyong66@gmail.com
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pictures extends Model
{
    public function user()
    {
        return $this->hasOne('App\\Models\\User','id','uid');
    }

    public function comments()
    {
        return $this->hasMany('App\\Models\\Comment','content_id','id');
    }
}
