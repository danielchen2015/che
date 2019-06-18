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
        $returnData = Db::table('che_user')->where("openid", '=', $openid)->find();
        if (!empty($returnData)) {
            return $returnData;
        } else {
            return null;
        }

    }

    /**
     * @param $openid
     * 获取配置文件
     */
    public function getconfig()
    {
        $returnData = Db::table('che_config')->limit(1)->find();
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
        $returnData = Db::table('che_vehicle')
            ->where($data)
            ->order('id desc')
            ->select();

        if (!empty($returnData)) {
            $returnData[0]['contacttel'] = "15145062876";            //add by daniel
            return $returnData;
        } else {
            return null;
        }

    }

    /**
     * @param $data
     * @param int $pagesize
     * @param int $pagenumber
     * @return array|null|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function vehcilelist($data, $pagenumber = 0, $pagesize = 10)
    {
        $returnData = Db::table('che_vehicle')
            ->where($data)
            ->order('id desc')
            ->page($pagenumber, $pagesize)
            ->select();

        if (!empty($returnData)) {
            $returnData[0]['contacttel'] = "15145062876";            //add by daniel
            return $returnData;
        } else {
            return null;
        }
    }

    /**
     *
     * @param $data
     */
    public function vehicleCount($data)
    {
        $returnData = Db::name('che_vehicle')
            ->field('id')
            ->where($data);

        $count = $returnData->count('id');//获取列表总数量

        return $count;
    }

    /**
     * @param $data
     * 更新车辆状态
     */
    public function vehicleupdate($id, $status)
    {
        //print_r($data);
        //exit;
        $change['status'] = $status;
        if ($status == 2) {
            $maxcode = $this->getmaxcode();
            //print_r($maxcode);
            //exit;
            if (!empty($maxcode[0]['code'])) {
                $change['code'] = $maxcode[0]['code'] + 1;
            } else {
                $change['code'] = 10000;
            }

        }
        return Db::table('che_vehicle')
            ->where('id', '=', $id)
            ->update($change);


    }

    /**
     * 更新价格
     * @param $id
     * @param $price
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function vehiclePrice($id, $price)
    {
        $change['fixprice'] = $price;
        if ($price > 0) {
            return Db::table('che_vehicle')
                ->where('id', '=', $id)
                ->update($change);
        }else{
            return 0;
        }
    }

    /**
     * @param
     * 获取code最大值
     */
    public function getmaxcode()
    {

        return Db::table('che_vehicle')
            ->field('max(code) as code')
            ->select();


    }
}