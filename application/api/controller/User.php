<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\5\8 0008
 * Time: 2:30
 */

namespace app\api\controller;

use think\Exception;
use think\Request;

class User extends Base
{
    /**
     * @SWG\Post(
     *     path="/api/User/add",
     *     tags={"1-用户管理部分接口"},
     *     operationId="add",
     *     summary="1.1-添加用户",
     *     description="添加用户(为小程序使用)。",
     *     consumes={"application/json"},
     *     @SWG\Property(example={
     *     "username" : "用户姓名",
     *     "openid": "小程序获取的openid",
     *     "mobileno": "小程序获取到的用户手机号"
     *      ),
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response="200",
     *         description="添加成功",
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
            return Response::create(['code' => 4000, 'msg' => '请求参数错误！'], 'json', 400);
        }

        try {
            $params = array();
            $params['username'] = $inputData->username;
            $params['password'] = md5("123456");
            $params['roleid'] = 1;
            $params['openid'] = $inputData->openid;
            $params['mobileno'] = $inputData->mobileno;
            $params['createtime'] = time();
            $model = new \app\api\model\User();
            $returnData = $model->userAdd($params);
            if ($returnData == 1) {
                return Response::create(['code' => 200, 'msg' => '添加用户成功！'], 'json', 200);
            }
        } catch (Exception $e) {
            return Response::create(['code' => 4000, 'msg' => $e->getMessage()], 'json', 400);
        }

    }

}