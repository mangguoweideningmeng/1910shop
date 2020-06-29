<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class AccessFilter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request_uri=$_SERVER['REQUEST_URI'];
        //echo 'request_uri:'.$request_uri;echo '</br>';
        $url_hash=substr(md5($request_uri),5,10);
        $max=env('API_ACCESS_MAX');          //最大访问次数
        $expire=env('API_ACCESS_TIMEOUT');       //等待时间
        $time_last=env('API_ACCESS_TIME_LAST');  //间隔时间
        //echo '<pre>';print_r($_SERVER);echo '</pre>';die;
        $key='count_url_'.$url_hash;
        //echo 'redis key：'.$key;
        $total=Redis::get($key);
        if ($total>$max){
            $response=[
                'erron'=>50010,
                'msg'=>"请求过于频繁,请{$expire}秒后再试",
            ];
            //设置key的过期时间
            Redis::expire($key,$expire);
            //return response()->json($response);
            die( json_encode($response,JSON_UNESCAPED_UNICODE));
        }else{
            Redis::incr($key);
            Redis::expire($key,$time_last); //记录某个时间段内访问次数
        }

        return $next($request);
    }
}
