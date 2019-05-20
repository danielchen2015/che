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
use think\Response;

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
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="Json格式",
     *         required=true,
     *         type="string",
     *         @SWG\Property(example={"username" : "用户姓名","openid": "小程序获取的openid","mobileno": "小程序获取到的用户手机号"})
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
            return Response::create(['resultCode' => 4000, 'resultMsg' => '请求参数错误！'], 'json', 400);
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
                return Response::create(['resultCode' => 200, 'resultMsg' => '添加用户成功！'], 'json', 200);
            } else if ($returnData == 3) {
                return Response::create(['resultCode' => 201, 'resultMsg' => '此用户已经存在！'], 'json', 200);
            } else {
                return Response::create(['resultCode' => 202, 'resultMsg' => '添加用户失败！'], 'json', 200);
            }
        } catch (Exception $e) {
            return Response::create(['resultCode' => 4000, 'resultMsg' => $e->getMessage()], 'json', 400);
        }

    }

    /**
     * @SWG\Get(
     *     path="/api/User/info?openid={openid}&mobileno={mobileno}",
     *     tags={"1-用户管理部分接口"},
     *     operationId="info",
     *     summary="1.2-获取用户信息",
     *     description="获取用户信息(为小程序使用)。openid和mobileno两者传一个即可。",
     *     consumes={"application/json"},
     *     @SWG\Parameter(
     *         name="openid",
     *         in="query",
     *         description="openid",
     *         required=false,
     *         format="string",
     *     ),
     *     @SWG\Parameter(
     *         name="mobileno",
     *         in="query",
     *         description="手机号",
     *         required=false,
     *         format="string",
     *     ),
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
        $openid = $request->param('openid');
        $mobileno = $request->param('mobileno');
        if (empty($openid) && empty($mobileno)) {
            return Response::create(['resultCode' => 4000, 'resultMsg' => '请求参数错误！'], 'json', 400);
        }

        try {

            $model = new \app\api\model\User();
            $returnData = $model->userInfo($openid, $mobileno);

            if (!empty($returnData)) {
                return Response::create(['resultCode' => 200, 'resultMsg' => $returnData], 'json', 200);
            } else {
                return Response::create(['resultCode' => 202, 'resultMsg' => '此用户信息不存在！'], 'json', 200);
            }
        } catch (Exception $e) {
            return Response::create(['resultCode' => 4000, 'resultMsg' => $e->getMessage()], 'json', 400);
        }

    }

    /**
     * @SWG\Get(
     *     path="/api/User/loginWxxcx?code={code}&encryptedData={encryptedData}&iv={iv}",
     *     tags={"1-用户管理部分接口"},
     *     operationId="loginWxxcx",
     *     summary="1.3-获取用户信息",
     *     description="获取用户信息(为小程序使用)。code\encryptedData\iv。",
     *     consumes={"application/json"},
     *     @SWG\Parameter(
     *         name="code",
     *         in="query",
     *         description="code",
     *         required=false,
     *         format="string",
     *     ),
     *     @SWG\Parameter(
     *         name="encryptedData",
     *         in="query",
     *         description="encryptedData",
     *         required=false,
     *         format="string",
     *     ),
     *     @SWG\Parameter(
     *         name="iv",
     *         in="query",
     *         description="iv",
     *         required=false,
     *         format="string",
     *     ),
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response="200",
     *         description="添加成功",
     *         @SWG\Schema(ref="#/definitions/ApiResponse")
     *     ),
     *     security={{"petstore_auth":{"write:loginWxxcx", "read:loginWxxcx"}}}
     * )
     */
    public function loginWxxcx(Request $request)
    {
        $code = $request->param('code');
        $encryptedData = $request->param('encryptedData');
        $iv = $request->param('iv');

        $appid = "wx393bffa0355c7f37";
        $secret = "ea0bbaa3913fa7d74abf7430f249d34a";
        //appid={$appid}&secret={$secret}&js_code={$code}&grant_type=authorization_code
        $param = array(
            'appid' => $appid,
            'secret' => $secret,
            'js_code' => $code,
            'grant_type' => 'authorization_code'
        );

        $model = new \app\api\model\User();
        //http函数为封装的请求函数
        $res = $model->http("https://api.weixin.qq.com/sns/jscode2session", $param, 'get');

        $arr = json_decode($res, true);

        $result = $model->wxdecode($encryptedData, $iv, $arr['session_key'], $appid);

        //return json($result);
        if ($result) {
            return Response::create(['resultCode' => 000, 'resultMsg' => $result], 'json', 200);
        } else {
            return Response::create(['resultCode' => 400, 'resultMsg' => -1], 'json', 200);
        }

    }


}