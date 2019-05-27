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
            ->order('id desc')->limit(1000)->select();

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
    /**
     * @param Response $request
     * 更新用户信息
     */
    public function updatevehicleinfo($id,$data){
        $returnData = Db::table('che_vehicle')
            ->where(["id"=>$id])
            ->update($data);

    }

    public function deleteVehicle($id){
        $returnData = Db::table('che_vehicle')
            ->where(["id"=>$id])
            ->delete();
    }
    /**
     * 返回省信息
     */
    public function province()
    {
        $returnData = Db::table('provinces')
            ->select();

        if (!empty($returnData)) {
            return $returnData;
        } else {
            return null;
        }

    }

    /**
     * 返回市信息
     */
    public function city($provinname)
    {
        $res = Db::table('provinces')
            ->field(['provinceid'])
            ->where('province','=',$provinname)//如果是等号，=可以省略
            ->find();//如果是主键查询，可省略上面where,这行写->find(20);

        $returnData = Db::table('cities')
            ->where("provinceid","=",$res['provinceid'])
            ->select();
        if (!empty($returnData)) {
            return $returnData;
        } else {
            return null;
        }

    }
    /**
     * 返回地区信息
     */
    public function area($cityname)
    {
        $res = Db::table('cities')
            ->field(['cityid'])
            ->where('city','=',$cityname)//如果是等号，=可以省略
            ->find();//如果是主键查询，可省略上面where,这行写->find(20);
        $returnData = Db::table('areas')
            ->where("cityid","=",$res['cityid'])
            ->select();

        if (!empty($returnData)) {
            return $returnData;
        } else {
            return null;
        }

    }
}