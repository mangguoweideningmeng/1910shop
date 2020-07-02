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
    //发送方
    public function sing1(){
        $key='1910';
        $data='hello world';
        $sing=sha1($data.$key);
        echo "要发送的数据：".$data;echo '</br>';
        echo "发送前生成的签名：".$sing;echo  '<hr>';

        $b_url='http://www.1910.com/secret?data='.$data.'&sing='.$sing;
        echo $b_url;
    }
    //接受方
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
    //发送方
    public function www(){
        $key='1910';
        $url="http://www.api.com/api/info";   //接口地址
        //向接口get方式发送数据
        $data='hello';
        //签名
        $sign=sha1($data.$key);
        $url=$url.'?data='.$data.'&sign='.$sign;
        //php发起网络请求
        $response=file_get_contents($url);
        echo $response;

    }
    //发送方
    public function sendData(){
        $url='http://www.api.com/test/receive?name=zhangsan&age=10'; //要调用的接口
        $response=file_get_contents($url);
        echo $response;
    }
    //发送post请求CURL
    public function postData(){
        //发送的数据
        $data=[
            'user_name'=>'wangwu',
            'user_age'=>333
        ];
        $url='http://www.api.com/test/receive-post';
        //post方式发送数据  CURL
        //1.实例化
        $ch=curl_init();
        //2.设置参数
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1); //使用post方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//发送数据
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); //通过变量接收响应
        //3.开启回话
        $response=curl_exec($ch);
        //检测错误
        $errno=curl_errno($ch);//错误码
        $errmsg=curl_errno($ch);
        if ($errno){
            var_dump($errmsg);die;
        }
        //4.关闭
        curl_close($ch);
        echo $response;
    }
    //对称加密
    public function encrypt1(){
        $data='长江长江，我是黄河！';  //待加密数据
        $method='AES-256-CBC';     //加密算法
        $key='1910api';            //加密秘钥
        $iv='1910hellohellohe';    //初始向量
        //加密数据
        $enc_data=openssl_encrypt($data,$method,$key,OPENSSL_RAW_DATA,$iv);
//        echo "解密数据：".$enc_data;echo '</br>';
        $sign=sha1($enc_data.$key);
        //组合post数据
        $post_data=[
            'data'=>$enc_data,
            'sign'=>$sign
        ];
        //讲加密数据post发送到api对端
        $url='http://www.api.com/test/decrypt1';
        //1.实例化
        $ch=curl_init();
        //2.设置参数
        curl_setopt($ch,CURLOPT_URL,$url);     //post地址
        curl_setopt($ch,CURLOPT_POST,1); //使用post方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);//发送数据
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); //通过变量接收响应
        //3.开启回话
        $response=curl_exec($ch);
        //检测错误
        $errno=curl_errno($ch);//错误码
        $errmsg=curl_errno($ch);
        if ($errno){
            var_dump($errmsg);die;
        }
        //4.关闭
        curl_close($ch);
        echo $response;
    }
    //非对称加密
    public function rsaeEncrypt1(){
        $data='天王盖地虎，你是母老虎！';  //待加密数据
        //使用公钥进行加密
        $key_content=file_get_contents(storage_path('keys/pub.key'));//获取公钥所在的路径（内容）
        $pub_key=openssl_get_publickey($key_content);  //openssl_get_publickey 读取公钥内容
        openssl_public_encrypt($data,$enc_data,$pub_key);   //公钥加密

        //解密
        $key_content=file_get_contents(storage_path('keys/priv.key'));//获取公钥所在的路径（内容）
        $priv_key=openssl_get_privatekey($key_content);  //获取私钥
        openssl_private_decrypt($enc_data,$dec_data,$priv_key);
        var_dump($dec_data);
    }
    public function rsaeEncrypt2(){
        $data='天王盖地虎！';  //待加密数据
        //使用公钥进行加密
        $key_content=file_get_contents(storage_path('keys/b_pub.key'));//获取公钥所在的路径（内容）
        $pub_key=openssl_get_publickey($key_content);  //openssl_get_publickey 读取公钥内容
        openssl_public_encrypt($data,$enc_data,$pub_key);   //公钥加密

        //base64转码 密文
        $base64_data=base64_encode($enc_data);
        //var_dump($enc_data);echo '<hr>';
        $url='http://www.api.com/get-a?data='.urlencode($base64_data);

        //接受响应
        $response=file_get_contents($url);
        $json_arr=json_decode($response,true);
        $base64_data2=$json_arr['data'];
        $enc_data=base64_decode($base64_data2);//密文
        //解密
        $key=openssl_get_privatekey(file_get_contents(storage_path('keys/a_priv.key')));
        openssl_private_decrypt($enc_data,$dec_data,$key);
        echo "解密结果：".$dec_data;
    }
    public function rsaSign()
    {
        $data = "天王盖地虎";
        //计算签名
        $key = openssl_get_privatekey( file_get_contents( storage_path('keys/a_priv.key') )  );
        openssl_sign($data,$sign,$key);

        $sign_str = urlencode(base64_encode($sign));
        //将数据和 签名一起发送  GET / POST
        $url = 'http://www.api.com/rsa/verify?data='.$data . '&sign='.$sign_str;

        $response = file_get_contents($url);
        echo $response;

    }
}
