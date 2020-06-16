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
        //$info=GoodsModel::where(['goods_id'=>$goods_id])->get()->toArray();
        $info=GoodsModel::find($goods_id);
        print_r($info);
    }
}
