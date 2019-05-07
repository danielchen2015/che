<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\5\7 0007
 * Time: 21:48
 */

namespace app\admin\controller;


use think\Request;

class User extends Base
{
    public function login(Request $request)
    {

        if ($request->isPost()) {

        }

        return view('login');
    }

}