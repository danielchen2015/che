<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\5\8 0008
 * Time: 2:31
 */

namespace app\api\model;

use think\Db;

class Areas extends Base
{
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
    public function city($id)
    {
        $returnData = Db::table('cities')
            ->where("provinceid","=",$id)
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
    public function area($id)
    {
        $returnData = Db::table('areas')
            ->where("cityid","=",$id)
            ->select();

        if (!empty($returnData)) {
            return $returnData;
        } else {
            return null;
        }

    }

}