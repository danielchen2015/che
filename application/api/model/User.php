<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\5\8 0008
 * Time: 2:31
 */

namespace app\api\model;

use think\Db;

class User extends Base
{
    /**
     * @param $data
     * 用户信息添加
     */
    public function userAdd($data)
    {
        $returnData = Db::table('che_user')
            ->field(['userid', 'roleid', 'username'])
            ->where('openid', '=', $data['openid'])
            ->where('mobileno', '=', $data['mobileno'])
            ->order('userid desc')->limit(1)->select();

        if (!empty($returnData)) {
            return 3;           //当此用户存在时，返回3
        } else {
            return Db::table('che_user')->data($data)->insert();
        }
    }

    /**
     * @param $openid
     * @param $mobileno
     * 返回用户数据信息
     */
    public function userInfo($openid, $mobileno)
    {
        $returnData = Db::table('che_user')
            ->field(['userid', 'roleid', 'username', 'password', 'openid', 'mobileno', 'createtime', 'updatetime'])
            ->whereOr('openid', '=', $openid)
            ->whereOr('mobileno', '=', $mobileno)
            ->order('userid desc')->limit(1)->select();

        if (!empty($returnData)) {
            return json_decode(json_encode($returnData[0], true));
        } else {
            return null;
        }

    }

}