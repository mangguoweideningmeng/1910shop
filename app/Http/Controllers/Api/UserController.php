<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\P_usersModel;
use App\Model\TokenModel;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cookie;
class UserController extends Controller
{
    public function regdo(Request $request){
//        var_dump(111);die;
        $post=request()->except('_token');
        $post['reg_time']=time();
        $len=strlen($post['password']);
        if ($len<6){
            $response=[
                'errno'=>50001,
                'msg'=>"密码长度大于六位"
            ];
            return $response;
        }
        if ($post['password']!=$post['passwords']){
            $response=[
                'errno'=>50002,
                'msg'=>"两次密码不一致"
            ];
            return $response;
        }
        $user=P_usersModel::where('user_name',$post['user_name'])->first();
        if ($user){
            $response=[
                'errno'=>50003,
                'msg'=>"用户名以存在"
            ];
            return $response;
        }
        $user1=P_usersModel::where('email',$post['email'])->first();
        if ($user1){
            $response=[
                'errno'=>50004,
                'msg'=>"邮箱以存在"
            ];
            return $response;
        }
        $post['password']=password_hash($post['password'], PASSWORD_BCRYPT);
        $user=P_usersModel::create($post);
        if ($user) {
            $response=[
                'errno'=>0,
                'msg'=>"注册成功"
            ];

        }else{
            $response=[
                'errno'=>50005,
                'msg'=>"注册失败"
            ];
        }
        return $response;
    }
    public function logindo(Request $request){
        $user_name = $request->input('user_name');
        $password = $request->input('password');

        $user=P_usersModel::where('user_name',$user_name)->first();
        if (password_verify($password,$user['password'])) {
            //生成token
            $str=$user->user_id.$user->$user_name.time();
            $token=substr(md5($str),10,16).substr(md5($str),0,10);
//            $data=[
//                'uid'=>$user->user_id,
//                'token'=>$token,
//                 'expire'=>time()+7200
//            ];
//            TokenModel::insert($data);

            Redis::set($token,$user->user_id);
            //设置key过期时间 x秒
            Redis::expire($token,20);
            $response=[
                'erron'=>0,
                'msg'=>'ok',
                'token'=>$token
            ];
        } else {
            $response=[
                'erron'=>50006,
                'msg'=>'用户名或密码错误',
            ];

        }
        return $response;
    }
    public function create(){
        //判断用户是否登录 ,判断是否有 uid 字段
//        echo '<pre>';print_r($_COOKIE);echo '</pre>';
        $token=$_GET['token'];
        //验证token是否有效
        //$res=TokenModel::where(['token'=>$token])->first();
        $uid=Redis::get($token);
        if($uid)
        {
            //$uid=$res->uid;
            $user_info=P_usersModel::find($uid);
            //已登录
            echo "欢迎".$user_info->user_name."登录";
        }else{
            //未登录
            echo "请登录";
        }

    }
}
