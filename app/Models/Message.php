<?php
/**
 * @copyright 杭州融远信息科技有限公司
 * @author     xieqiyong66@gmail.com
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = "message";
    public function receive()
    {
        return $this->hasOne("App\\Models\\User",'id','receive_id');
    }
    public function send()
    {
        return $this->hasOne("App\\Models\\User",'id','send_id');
    }
}
