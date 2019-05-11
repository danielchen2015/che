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
            ->field(['title', 'company', 'mobile', 'telno', 'weixinimg1', 'weixinimg2', 'adimg1', 'adimg2', 'adimg3', 'adimg4'])
            ->limit(1)->select();

        if (!empty($returnData)) {
            return json_decode(json_encode($returnData[0], true));
        } else {
            return null;
        }

    }

}