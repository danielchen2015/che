<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\5\7 0007
 * Time: 22:22
 */

namespace app\admin\controller;


use think\Controller;
use think\Exception;
use think\Request;

class Vehicle extends Controller
{
    public function vlist(Request $request){
        try {
            $model = new \app\admin\model\Vehicle();
            $returnData = $model->vehiclelist();
            if (!empty($returnData)) {

            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }

        $this->assign('vehiclelist', $returnData);
        print_r($returnData);

        return view("list");
    }
}