<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TokenModel extends Model
{
    protected $table = 'p_tokens';
    protected $primaryKey = 'id';
    // 关闭时间戳
    public $timestamps = false;
}
