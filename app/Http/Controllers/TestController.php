<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
class TestController extends Controller
{
    public function hello(){
        //echo __METHOD__;
        echo 11;
    }
    public function redis1(){
        $key='name2';
        $val1=Redis::get($key);
        var_dump($val1);echo '</br>';
        echo '$val1'.$val1;
    }
    public function sing1(){
        $key='1910';
        $data='hello world';
        $sing=sha1($data.$key);
        echo "要发送的数据：".$data;echo '</br>';
        echo "发送前生成的签名：".$sing;echo  '<hr>';

        $b_url='http://www.1910.com/secret?data='.$data.'&sing='.$sing;
        echo $b_url;
    }
    public function secret(){
        echo '<pre>';print_r($_GET);echo '</pre>';
        //验证签名
        $key='1910';
        $data=$_GET['data'];  //接受到数据
        $sing=$_GET['sing'];  //接受到的签名
        $local_sing=sha1($data.$key);
        echo "本地计算的签名：".$local_sing;echo  '<hr>';
        if ($sing==$local_sing){
            echo "验签通过";
        }else{
            echo "验签失败";
        }
    }
}
