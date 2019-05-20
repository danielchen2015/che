<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\5\6 0006
 * Time: 22:17
 */

namespace app\admin\controller;

use think\Controller;

class Base extends Controller
{
    protected $userid;

    public function __construct()
    {
        parent::__construct();
        $this->userid = session('userid');
        if (!$this->userid) {
            $this->redirect('/index.php/admin/User/login');
        }
        $this->assign('userid', session('userid'));
        $this->assign('username', session('username'));
        $this->assign('roleid', session('roleid'));

    }

}