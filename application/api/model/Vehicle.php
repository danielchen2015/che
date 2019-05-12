<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\5\8 0008
 * Time: 2:31
 */

namespace app\api\model;
use think\Db;

class Vehicle extends Base
{
    /**
     * @param $data
     * 车辆信息添加
     */
    public function vehicleAdd($data)
    {
        //print_r($data);
        //exit;
        return Db::table('che_vehicle')->data($data)->insert();

    }
    /**
     * @param $openid
     * 获取用户信息
     */
    public function getuserid($openid)
    {
        //print_r($data);
        //exit;
        $returnData = Db::table('che_user')->where("openid", '=', $openid)->find();
        if (!empty($returnData)) {
            return $returnData;
        } else {
            return null;
        }

    }
    /**
 * @param $data
 * 车辆信息
 */
    public function vehicleinfo($data)
    {
        /* $leval=0;
         $parameter="";
         foreach ($data as $key=>$value){
             $leval++;
             $parameter=$key;
         }
         if($leval==1){
             $returnData = Db::table('che_vehicle')
                 ->where($parameter, '=', $data[$parameter])
                 ->select();
         }else{
             $returnData = Db::table('che_vehicle')
                 ->where('id', '=', $data['id'])
                 ->where('opr_user', '=', $data['opr_user'])
                 ->select();
         }*/
        $returnData = Db::table('che_vehicle')
            ->where($data)
            ->find();
        //print_r( $returnData);

        //$returnData[0][]=
        if (!empty($returnData)) {
            //$returnData['']
            return $returnData;
        } else {
            return null;
        }

    }
    /**
     * @param $data
     * 更新车辆状态
     */
    public function vehicleupdate($id,$status)
    {
        //print_r($data);
        //exit;
        return Db::table('che_vehicle')
            ->where('id','=',$id)
            ->update(['status'=>$status]);


    }
}