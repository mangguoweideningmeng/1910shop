<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class P_usersModel extends Model
{
    protected $table = 'p_users';
    protected $primaryKey = 'user_id';
    // 关闭时间戳
    public $timestamps = false;
    // 黑名单
    //protected $guarded = ['passwords'];
    protected $fillable = ['user_name','email','password','reg_time'];

}
