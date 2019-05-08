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
            ->field(['userid', 'roleid', 'username'])
            ->where([
                ['username', '=', $data['username']],
                ['password', '=', $data['password']],
                ['roleid', '=', 2],
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
    public function userInfo($userid)
    {
        $returnData = Db::table('che_user')
            ->field(['userid', 'roleid', 'username', 'password', 'openid', 'mobileno', 'createtime'])
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

    /**
     * @param $data
     * 更新
     */
    public function userUpdate($data)
    {
        //如果where条件是主键，还可以如下使用
        if (!empty($data['password'])) {
            return Db::table('che_user')
                ->where('userid', '=', $data['userid'])
                ->update(['password' => $data['password'], 'roleid' => $data['roleid'], 'mobileno' => $data['mobileno'], 'updatetime' => time()]);
        } else {
            return Db::table('che_user')
                ->where('userid', '=', $data['userid'])
                ->update(['roleid' => $data['roleid'], 'mobileno' => $data['mobileno'], 'updatetime' => time()]);
        }
    }

}