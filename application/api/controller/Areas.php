<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\5\8 0008
 * Time: 2:31
 */

namespace app\api\controller;

use think\Exception;
use think\Request;
use think\Response;

class Areas extends Base
{
    /**
     * @SWG\Get(
     *     path="/api/areas/getprovince",
     *     tags={"4-地区部分接口"},
     *     operationId="getprovince",
     *     summary="4.1-获取省份信息",
     *     description="获取省份信息(为小程序使用)",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response="200",
     *         description="[{
     *           "Id": 110000,
     *          "Name": "北京市",
     *          "Pid": 0
     *          }]",
     *         @SWG\Schema(ref="#/definitions/ApiResponse")
     *     ),
     *     security={{"petstore_auth":{"write:info", "read:info"}}}
     * )
     */
    public function getprovince()
    {
        try {
            $model = new \app\api\model\Areas();
            $returnData = $model->province();
            if (!empty($returnData)) {
                return Response::create(['resultCode' => 200, 'resultMsg' => $returnData], 'json', 200);
            } else {
                return Response::create(['resultCode' => 202, 'resultMsg' => '无省信息！'], 'json', 200);
            }
        } catch (Exception $e) {
            return Response::create(['resultCode' => 4000, 'resultMsg' => $e->getMessage()], 'json', 400);
        }

    }
    /**
     * @SWG\Get(
     *     path="/api/areas/getprovince?proviceid=110000",
     *     tags={"4-地区部分接口"},
     *     operationId="getprovince",
     *     summary="4.2-根据省id获取市信息",
     *     description="获取市信息(为小程序使用)",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response="200",
     *         description="[{
     *          "id": 1,
     *          "cityid": "110100",
     *          "city": "北京市",
     *          "provinceid": "110000"
     *          }]",
     *         @SWG\Schema(ref="#/definitions/ApiResponse")
     *     ),
     *     security={{"petstore_auth":{"write:info", "read:info"}}}
     * )
     */
    public function getcity(Request $request)
    {
        $proviceid = $request->get("proviceid");
        if(empty($proviceid)){
            return Response::create(['resultCode' => 4000, 'resultMsg' => '请求参数错误！'], 'json', 400);
        }
        try {
            $model = new \app\api\model\Areas();
            $returnData = $model->city($proviceid);
            if (!empty($returnData)) {
                return Response::create(['resultCode' => 200, 'resultMsg' => $returnData], 'json', 200);
            } else {
                return Response::create(['resultCode' => 202, 'resultMsg' => '无省信息！'], 'json', 200);
            }
        } catch (Exception $e) {
            return Response::create(['resultCode' => 4000, 'resultMsg' => $e->getMessage()], 'json', 400);
        }

    }
    /**
     * @SWG\Get(
     *     path="/api/areas/getarea?cityid=110900",
     *     tags={"4-地区部分接口"},
     *     operationId="getarea",
     *     summary="4.3-根据市id获取地区信息",
     *     description="获取地区信息(为小程序使用)",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response="200",
     *         description="[
     *           {
     *          "id": 1,
     *          "areaid": "110101",
     *          "area": "东城区",
     *          "cityid": "110100"
     *          }]",
     *         @SWG\Schema(ref="#/definitions/ApiResponse")
     *     ),
     *     security={{"petstore_auth":{"write:info", "read:info"}}}
     * )
     */
    public function getarea(Request $request)
    {
        $cityid = $request->get("cityid");
        if(empty($cityid)){
            return Response::create(['resultCode' => 4000, 'resultMsg' => '请求参数错误！'], 'json', 400);
        }
        try {
            $model = new \app\api\model\Areas();
            $returnData = $model->area($cityid);
            if (!empty($returnData)) {
                return Response::create(['resultCode' => 200, 'resultMsg' => $returnData], 'json', 200);
            } else {
                return Response::create(['resultCode' => 202, 'resultMsg' => '无省信息！'], 'json', 200);
            }
        } catch (Exception $e) {
            return Response::create(['resultCode' => 4000, 'resultMsg' => $e->getMessage()], 'json', 400);
        }

    }

}