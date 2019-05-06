<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\5\6 0006
 * Time: 22:40
 */

namespace app\api\controller;


use think\Request;

class Index extends Base
{
    public function index(Request $request)
    {
        echo "in";
    }

}