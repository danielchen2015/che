<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\5\7 0007
 * Time: 21:48
 */

namespace app\admin\controller;

use think\Controller;
use think\Exception;
use think\Request;

class User extends Controller
{
    public function login(Request $request)
    {
        $data = $request->post();
        if ($request->isPost()) {
            //获取表单POST的值
            $params = array();
            $params['username'] = $data['username'];
            $params['password'] = md5($data['password']);
            try {
                $model = new \app\admin\model\User();
                $returnData = $model->userLogin($params);
                if (!empty($returnData)) {
                    if ($returnData[0]['username'] == $data['username']) {
                        session('userid', $returnData[0]['userid']);
                        session('roleid', $returnData[0]['roleid']);
                        session('username', $returnData[0]['username']);
                        $this->redirect('admin/Index/index');
                    } else {
                        $this->error('用户名或密码错误！', 'admin/User/login');
                    }
                } else {
                    $this->error('用户名或密码错误！', 'admin/User/login');
                }
            } catch (Exception $ex) {
                return $ex->getMessage();
            }
        }

        return view('login');
    }

    /**
     * @param Request $request
     * @return Response
     * 注销
     */
    public function loginOut(Request $request)
    {
        session_start();
        session_destroy();
        $this->redirect('admin/User/login');

    }

    /**
     * @param Request $request
     * 个人中心
     */
    public function profile(Request $request)
    {
        $userid = session('userid');
        if (empty($userid)) {
            $this->redirect('/admin/User/login');
        }

        $data = $request->post();
        if ($request->isPost()) {
            //获取表单POST的值
            $params = array();
            $params['userid'] = $userid;
            $params['username'] = $data['username'];
            if (!empty($data['password'])) {
                $params['password'] = md5($data['password']);
            } else {
                $params['password'] = $data['password'];
            }
            $params['roleid'] = $data['roleid'];
            $params['mobileno'] = $data['mobileno'];
            try {
                $model = new \app\admin\model\User();
                $returnData = $model->userUpdate($params);
                if ($returnData == 1) {
                    $this->redirect('admin/User/profile');
                }
            } catch (Exception $ex) {
                return $ex->getMessage();
            }
        } else {
            try {
                $model = new \app\admin\model\User();
                $returnData = $model->userInfo($userid);
                if (!empty($returnData)) {

                }
            } catch (Exception $ex) {
                return $ex->getMessage();
            }

            $this->assign('profile', $returnData[0]);
        }

        return view('profile');
    }

}