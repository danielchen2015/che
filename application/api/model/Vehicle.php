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

        return Db::table('che_vehicle')->data($data)->insert();

    }
    /**
     * @param $data
     * 车辆信息
     */
    public function vehicleinfo($data)
    {
        $returnData = Db::table('che_vehicle')
            ->where('id', '=', $data['id'])
            ->select();

        if (!empty($returnData)) {
            return json_decode(json_encode($returnData[0], true));
        } else {
            return null;
        }

    }
}