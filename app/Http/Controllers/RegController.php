<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\P_usersModel;

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
            echo 'Password is valid!';
            echo "<script type='text/javascript'>alert('登录成功');</script>";
        } else {
            echo "<script type='text/javascript'>alert('用户名密码错误，请重新登录');</script>";
            return view('reception/login');
        }
    }
}
