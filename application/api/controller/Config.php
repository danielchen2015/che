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

class Config extends Base
{
    /**
     * @SWG\Get(
     *     path="/api/Config/info",
     *     tags={"2-系统配置管理部分接口"},
     *     operationId="info",
     *     summary="2.1-获取系统配置信息",
     *     description="获取系统配置信息(为小程序使用)。获取系统广告位，微信二维码，手机号，联系方式。",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response="200",
     *         description="添加成功",
     *         @SWG\Schema(ref="#/definitions/ApiResponse")
     *     ),
     *     security={{"petstore_auth":{"write:info", "read:info"}}}
     * )
     */
    public function info(Request $request)
    {
        try {
            $model = new \app\api\model\Config();
            $returnData = $model->configInfo();
            if (!empty($returnData)) {
                return Response::create(['resultCode' => 200, 'resultMsg' => $returnData], 'json', 200);
            } else {
                return Response::create(['resultCode' => 202, 'resultMsg' => '无系统配置信息！'], 'json', 200);
            }
        } catch (Exception $e) {
            return Response::create(['resultCode' => 4000, 'resultMsg' => $e->getMessage()], 'json', 400);
        }

    }

}