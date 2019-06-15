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
    public function vlist(Request $request)
    {
        $data = $request->post('args');

        try {
            $model = new \app\admin\model\Vehicle();

            $returnData = $model->vehiclelist($data);
            if (!empty($returnData)) {

            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }

        $this->assign('vehiclelist', $returnData);
        //print_r($returnData);

        //return view("list");
        // 渲染模板输出
        return $this->fetch('list');
    }

    public function vehicleinfo(Request $request)
    {
        try {
            $model = new \app\admin\model\Vehicle();
            $id = $request->get("id");
            $returnData = $model->vehicleinfo($id);
            $provinceinfo = $model->province();
            $cityinfo = $model->city($returnData['loc_province']);
            $areainfo = $model->area($returnData['loc_city']);


        } catch (Exception $ex) {
            return $ex->getMessage();
        }
        $returnData['vehicleimgs'] = json_decode($returnData['vehicleimgs'], true);
        //print_r($returnData);
        $this->assign('year', range(2000, 2020, 1));
        $this->assign('month', range(1, 12, 1));
        $temparr[] = ["id" => 1, "name" => "待审核"];
        $temparr[] = ["id" => 2, "name" => "审核通过"];
        $temparr[] = ["id" => 3, "name" => "审核不通过"];
        $temparr[] = ["id" => 4, "name" => "已售"];
        $this->assign('vestatus', $temparr);
        $this->assign('vehicleinfo', $returnData);
        $this->assign('provinceinfo', $provinceinfo);
        $this->assign('cityinfo', $cityinfo);
        $this->assign('areainfo', $areainfo);
        //print_r($provinceinfo);
        //exit;
        //print_r($returnData);

        return view("vehicleinfo");
    }

    public function modifyvehile(Request $request)
    {
        $data = $request->post();
        if ($request->isPost()) {
            //获取表单POST的值
            $params = array();
            $id = $data['id'];
            foreach ($data['data'] as $key => $value) {
                $params[$key] = $value;
            }
            $params["vehicleimgs"] = json_encode($params["vehicleimgs"], 320);
            // print_r($params);
            // exit;
            //unset($params['id']);


            try {
                $model = new \app\admin\model\Vehicle();
                $model->updatevehicleinfo($id, $params);
                $this->redirect('admin/vehicle/vlist');

            } catch (Exception $ex) {
                return $ex->getMessage();
            }
        }
    }

    /**
     * @param Request $request
     * @return string
     * 删除车辆信息
     */
    public function deleteVehicle(Request $request)
    {
        $vehicleId = $request->param("id");
        if (!empty($vehicleId)) {
            //获取表单POST的值
            $params = array();
            $id = $vehicleId;

            try {
                $model = new \app\admin\model\Vehicle();
                $model->deleteVehicle($id);
                $this->redirect('admin/vehicle/vlist');

            } catch (Exception $ex) {
                return $ex->getMessage();
            }
        }
    }
}