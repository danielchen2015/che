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
     *     tags={"5-地区部分接口"},
     *     operationId="getprovince",
     *     summary="4.1-获取省份信息",
     *     description="获取省份信息(为小程序使用)",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response="200",
     *         description="JSON格式",
     *         @SWG\Schema(ref="#/definitions/ApiResponse")
     *     ),
     *     security={{"petstore_auth":{"write:getprovince", "read:getprovince"}}}
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
     *     path="/api/areas/getcity?proviceid=110000",
     *     tags={"5-地区部分接口"},
     *     operationId="getcity",
     *     summary="4.2-根据省id获取市信息",
     *     description="获取市信息(为小程序使用)",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response="200",
     *         description="JSON格式",
     *         @SWG\Schema(ref="#/definitions/ApiResponse")
     *     ),
     *     security={{"petstore_auth":{"write:getcity", "read:getcity"}}}
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
     *     tags={"5-地区部分接口"},
     *     operationId="getarea",
     *     summary="4.3-根据市id获取地区信息",
     *     description="获取地区信息(为小程序使用)",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response="200",
     *         description="JSON格式",
     *         @SWG\Schema(ref="#/definitions/ApiResponse")
     *     ),
     *     security={{"petstore_auth":{"write:getarea", "read:getarea"}}}
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