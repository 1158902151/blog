<?php
/**
 * @copyright 杭州融远信息科技有限公司
 * @author     xieqiyong66@gmail.com
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function users()
    {
        return $this->hasOne('App\\Models\\User','id','create_id');
    }

}
