<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\P_usersModel;
use Illuminate\Support\Facades\Cookie;
class regController extends Controller
{
    public function reg(){
        return view('reception/reg');
    }
    public function regdo(Request $request){

        $post=request()->except('_token');
        $post['reg_time']=time();
        $user=P_usersModel::where('user_name',$post['user_name'])->first();
        if ($user){
            echo "<script type='text/javascript'>alert('用户名存在');</script>";
            return view('reception/reg');
        }
        $user1=P_usersModel::where('email',$post['email'])->first();
        if ($user1){
            echo "<script type='text/javascript'>alert('邮箱存在');</script>";
            return view('reception/reg');
        }
        //dd($post);
        if($post['password']!=$post['passwords']){
            echo "<script type='text/javascript'>alert('密码不一致');</script>";
            return view('reception/reg');
        }
        $post['password']=password_hash($post['password'], PASSWORD_BCRYPT);
        $user=P_usersModel::create($post);
        if ($user) {
            return view('reception/login');
        }
    }
    public function login(){
        return view('reception/login');
    }
    public function logindo(){
        $post=request()->except('_token');
        //dd($post);
        $user=P_usersModel::where('user_name',$post['user_name'])->first();
        //dd($user);

        if (password_verify($post['password'],$user['password'])) {
            //echo 'Password is valid!';
//            setcookie('uid',$user->user_id,time()+3600,'/');
//            setcookie('name',$user->user_name,time()+3600,'/');

            Cookie::queue('uid',$user->user_id,60);
            Cookie::queue('name',$user->user_name,60);
            header('Refresh:2,url=/user/create');
            echo "登录成功";
//            echo "<script type='text/javascript'>alert('登录成功');</script>";
           return redirect('user/create');
        } else {
            echo "<script type='text/javascript'>alert('用户名密码错误，请重新登录');</script>";
            return view('reception/login');
        }
    }
    public function create(){
//        if (isset($_COOKIE['uid'])&&isset($_COOKIE['name'])){
//
//            return view('reception.create');
//        }else{
//            //echo 'wei登录';
//            return redirect('user/login');
//        }
        //判断用户是否登录 ,判断是否有 uid 字段
        echo '<pre>';print_r($_COOKIE);echo '</pre>';
        if(Cookie::has('uid'))
        {
            //已登录
            return view('reception.create');
        }else{
            //未登录
            return redirect('/user/login');
        }

    }
}
