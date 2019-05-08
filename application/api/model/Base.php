<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\5\6 0006
 * Time: 22:39
 */

namespace app\api\model;

use think\Model;

class Base extends Model
{
    protected $version='v1';//当前版本
    public function __construct()
    {
        parent::__construct();
        //权限验证
    }

}