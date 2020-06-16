<?php

namespace App\Http\Controllers\Goods;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\GoodsModel;
class GoodsController extends Controller
{
    public function detail(){
        $goods_id=$_GET['id'];
        //echo $goods_id;
        //$info=GoodsModel::where(['goods_id'=>$goods_id])->get()->toArray();   //二维数组
        //$info=GoodsModel::find($goods_id);
        $info=GoodsModel::where(['goods_id'=>$goods_id])->first()->toArray();   //一维数组
        print_r($info);
    }
}
