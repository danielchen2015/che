<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\5\7 0007
 * Time: 22:00
 */

namespace app\admin\model;

use think\Db;

class User extends Base
{
    public function userLogin($data)
    {
        $returnData = Db::table('che_user')
            ->field(['userid', 'roleid','username'])
            ->where([
                ['username', '=', $data['username']],
                ['password', '=', $data['password']],
            ])
            ->order('userid desc')->limit(1)->select();

        if (empty($returnData)) {
            return null;
        } else {
            return $returnData;
        }

    }

    /**
     * @param $userid
     */
    public function userInfo($userid){
        $returnData = Db::table('che_user')
            ->field(['userid', 'roleid','username','password','openid','mobileno','createtime'])
            ->where([
                ['userid', '=', $userid],
            ])
            ->order('userid desc')->limit(1)->select();

        if (empty($returnData)) {
            return null;
        } else {
            return $returnData;
        }
    }

}