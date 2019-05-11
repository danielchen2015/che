<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\5\7 0007
 * Time: 22:22
 */

namespace app\admin\controller;


use think\Request;

class Config extends Base
{
    public function setting(Request $request)
    {
        try {
            $model = new \app\admin\model\Config();
            $returnData = $model->configInfo();
            if (!empty($returnData)) {

            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }

        $this->assign('setting', $returnData[0]);

        return view('setting');
    }

    /**
     * @param Request $request
     */
    public function settingUpdate(Request $request)
    {
        $data = $request->post();
        if ($request->isPost()) {
            //获取表单POST的值
            $params = array();
            $params['title'] = $data['title'];
            $params['company'] = $data['company'];
            $params['mobile'] = $data['mobile'];
            $params['telno'] = $data['telno'];
            $params['weixinimg1'] = $data['weixinimg1'];
            $params['weixinimg2'] = $data['weixinimg2'];
            $params['adimg1'] = $data['adimg1'];
            $params['adimg2'] = $data['adimg2'];
            $params['adimg3'] = $data['adimg3'];
            $params['adimg4'] = $data['adimg4'];
            try {
                $model = new \app\admin\model\Config();
                $returnData = $model->configUpdate($params);
                $this->redirect('admin/Config/setting');
            } catch (Exception $ex) {
                return $ex->getMessage();
            }
        }
    }
}