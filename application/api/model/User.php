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
        return Db::table('che_user')->data($data)->insert();
    }

}