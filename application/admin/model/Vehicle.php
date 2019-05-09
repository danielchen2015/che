<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\5\7 0007
 * Time: 22:23
 */

namespace app\admin\model;
use think\Db;

class Vehicle extends Base
{
    /**
     * @param Response $request
     * 用户列表
     */
   public function vehiclelist(){
       $returnData = Db::table('che_vehicle')
           ->order('id desc')->limit(1)->select();

       if (empty($returnData)) {
           return null;
       } else {
           return $returnData;
       }
   }

    /**
     * @param Response $request
     * 用户列表
     */
    public function vehicleinfo($id){
        $returnData = Db::table('che_vehicle')
            ->where(["id"=>$id])
            ->select()[0];

        if (empty($returnData)) {
            return null;
        } else {
            return $returnData;
        }
    }
}