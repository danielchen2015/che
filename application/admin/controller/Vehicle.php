<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\5\7 0007
 * Time: 22:22
 */

namespace app\admin\controller;


use think\Controller;
use think\Exception;
use think\Request;

class Vehicle extends Controller
{
    public function vlist(Request $request){
        try {
            $model = new \app\admin\model\Vehicle();
            $returnData = $model->vehiclelist();
            if (!empty($returnData)) {

            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }

        $this->assign('vehiclelist', $returnData);
        //print_r($returnData);

        return view("list");
    }

    public function vehicleinfo(Request $request){
        try {
            $model = new \app\admin\model\Vehicle();
            $id=$request->get("id");
            $returnData = $model->vehicleinfo($id);

        } catch (Exception $ex) {
            return $ex->getMessage();
        }
        print_r($returnData);
        $this->assign('vehicleinfo', $returnData);
        //print_r($returnData);

        return view("vehicleinfo");
    }

    public function modifyvehile(Request $request){
        $data = $request->post();
        print_r($data);
       /* if ($request->isPost()) {
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
        }*/
    }
}