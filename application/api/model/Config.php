<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\5\8 0008
 * Time: 2:31
 */

namespace app\api\model;

use think\Db;

class Config extends Base
{
    /**
     * @param $openid
     * @param $mobileno
     * 返回用户数据信息
     */
    public function configInfo()
    {
        $returnData = Db::table('che_config')
            ->field(['title', 'company', 'mobile', 'telno', 'weixinimg1', 'weixinimg2', 'adimg1', 'adimg2', 'adimg3', 'adimg4', 'adimg5'])
            ->limit(1)->select();

        if (!empty($returnData)) {
            $res = array(
                "title" => $returnData[0]["title"],
                "company" => $returnData[0]["company"],
                "mobile" => $returnData[0]["mobile"],
                "telno" => $returnData[0]["telno"],
                "weixinimg1" => $returnData[0]["weixinimg1"],
                "weixinimg2" => $returnData[0]["weixinimg2"],
                "arr" => array(
                    $returnData[0]["adimg1"],
                    $returnData[0]["adimg2"],
                    $returnData[0]["adimg3"],
                    $returnData[0]["adimg4"],
                    $returnData[0]["adimg5"]
                )
            );

            return json_decode(json_encode($res, true));

        } else {
            return null;
        }

    }

}