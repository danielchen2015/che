<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 2019/5/8
 * Time: 12:45
 */

namespace app\api\controller;

use think\Response;
use think\Request;

use think\App;

class Vehicle extends Base
{
    public function __construct(App $app = null)
    {
        parent::__construct($app);
    }

    /**
     * @SWG\Post(
     *     path="/api/vehicle/add",
     *     tags={"3-车辆管理部分接口"},
     *     operationId="add",
     *     summary="3.1-添加车辆",
     *     description="添加车辆(为小程序使用)。",
     *     consumes={"application/json"},
     *     @SWG\Property(example={
     *     "price" : "价格",
     *     "models": "车型",
     *     "boarddateyear": "上牌日期年份"
     *     "boarddatemonth": "上牌日期月份"*
     *     "proddateyear": "出厂日期年份"
     *     "proddatemonth": "出厂日期月份"
     *     "realmileage": "真实里程"
     *     "condition": "车况描述"
     *     "contacttel": "联系电话"
     *     "vehicleimgs": "车辆照片json格式"
     *     "weixinimg": "微信二维码地址"
     *     "guideprice": "新车指导价"
     *     "displacement": "汽车排量"
     *     "configuration": "车辆配置"
     *     "loc_province": "车辆所在地省份"
     *     "loc_city": "车辆所在地城市"
     *     "loc_area": "车辆所在地区域"
     *     "transfer_times": "过户次数"
     *     "fixprice": "一口价"
     *     "status": "状态"
     *     "popularity_index": "人气指数"
     *     "dial_index": "拨号指数"
     *     "score": "会员积分"
     *     "opr_user": "发布人员编号"
     *      ),
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response="200",
     *         description="添加车辆成功",
     *         @SWG\Schema(ref="#/definitions/ApiResponse")
     *     ),
     *     security={{"petstore_auth":{"write:add", "read:add"}}}
     * )
     */
    public function add(Request $request)
    {
        $input = $request->getContent();
        $inputData = json_decode($input);
        if (empty($input)) {
            return Response::create(['resultCode' => 4000, 'resultMsg' => '请求参数错误！'], 'json', 400);
        }
        try {
            $params = array();
            $params['price'] = $inputData->price;
            $params['models'] = $inputData->models;
            $params['boarddateyear'] = $inputData->boarddateyear;
            $params['boarddatemonth'] = $inputData->boarddatemonth;
            $params['proddateyear'] = $inputData->proddateyear;
            $params['proddatemonth'] = $inputData->proddatemonth;
            $params['realmileage'] = $inputData->realmileage;
            $params['condition'] = $inputData->condition;
            $params['contacttel'] = $inputData->contacttel;
            $params['vehicleimgs'] = json_encode($inputData->vehicleimgs,JSON_UNESCAPED_SLASHES);
            $params['weixinimg'] = $inputData->weixinimg;
            $params['guideprice'] = $inputData->guideprice;
            $params['displacement'] = $inputData->displacement;
            $params['configuration'] = $inputData->configuration;
            $params['loc_province'] = $inputData->loc_province;
            $params['loc_city'] = $inputData->loc_city;
            $params['loc_area'] = $inputData->loc_area;
            $params['transfer_times'] = $inputData->transfer_times;
            $params['fixprice'] = $inputData->fixprice;
            $params['status'] = $inputData->status;
            $params['popularity_index'] = $inputData->popularity_index;
            $params['dial_index'] = $inputData->dial_index;
            $params['score'] = $inputData->score;
            $params['opr_datetime'] = time();
            $params['opr_user'] = $inputData->opr_user;
            /*add code =0 不然没法插入数据*/
            $params['code'] = 0;

            $model = new \app\api\model\Vehicle();
            //print_r($params);
            //exit;
            $returnData = $model->vehicleAdd($params);
            if ($returnData == 1) {
                return Response::create(['resultCode' => 200, 'resultMsg' => '添加车辆成功！'], 'json', 200);
            } else {
                return Response::create(['resultCode' => 202, 'resultMsg' => '添加车辆失败！'], 'json', 200);
            }
        } catch (Exception $e) {
            return Response::create(['resultCode' => 4000, 'resultMsg' => $e->getMessage()], 'json', 400);
        }
    }
    /**
     * @SWG\Post(
     *     path="/api/vehicle/getvehicleinfo",
     *     tags={"3-车辆管理部分接口，可只传一个参数，获取我发布的车辆也是在这里"},
     *     operationId="getvehicleinfo",
     *     summary="3.2-获取车辆信息",
     *     description="获取车辆信息(为小程序使用)。",
     *     consumes={"application/json"},
     *     @SWG\Property(example={
     *     "id" : "车辆id",
     *     "opr_user" : "发布人员编号"
     *      }),
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response="200",
     *         description="",
     *         @SWG\Schema(ref="#/definitions/ApiResponse")
     *     ),
     *     security={{"petstore_auth":{"write:getvehicleinfo", "read:getvehicleinfo"}}}
     * )
     */
    public function getvehicleinfo(Request $request)
    {
        $input = $request->getContent();
        $inputData = json_decode($input,true);
        if (empty($input)) {
            return Response::create(['resultCode' => 4000, 'resultMsg' => '请求参数错误！'], 'json', 400);
        }
        try {
            $params = array();
            foreach ($inputData as $key=>$value){
                if(!empty($value)) $params[$key] = $value;
            }

            $model = new \app\api\model\Vehicle();
            //print_r($params);
            //exit;
            $returnData = $model->vehicleinfo($params);
            if (!empty($returnData)) {
                return Response::create(['resultCode' => 200, 'resultMsg' => $returnData], 'json', 200);
            } else {
                return Response::create(['resultCode' => 202, 'resultMsg' => '获取车辆失败！'], 'json', 200);
            }
        } catch (Exception $e) {
            return Response::create(['resultCode' => 4000, 'resultMsg' => $e->getMessage()], 'json', 400);
        }
    }

}