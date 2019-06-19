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
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="Json格式",
     *         required=true,
     *         type="string",
     *         @SWG\Property(example={
     *     "openid": "openid",
     *     "price" : "价格",
     *     "models": "车型",
     *     "boarddateyear": "上牌日期年份",
     *     "boarddatemonth": "上牌日期月份",
     *     "proddateyear": "出厂日期年份",
     *     "proddatemonth": "出厂日期月份",
     *     "realmileage": "真实里程",
     *     "condition": "车况描述",
     *     "contacttel": "联系电话",
     *     "vehicleimgs": "车辆照片json格式 ["/upload/20190511/JjTfWAF0DD.png","/upload/20190511/JjTfWAF0DD.png","/upload/20190511/JjTfWAF0DD.png","/upload/20190511/JjTfWAF0DD.png","/upload/20190511/JjTfWAF0DD.png","/upload/20190511/JjTfWAF0DD.png","/upload/20190511/JjTfWAF0DD.png","/upload/20190511/JjTfWAF0DD.png","/upload/20190511/JjTfWAF0DD.png","/upload/20190511/JjTfWAF0DD.png","/upload/20190511/JjTfWAF0DD.png"]",
     *     "weixinimg": "微信二维码地址",
     *     "guideprice": "新车指导价",
     *     "displacement": "汽车排量",
     *     "configuration": "车辆配置",
     *     "loc_province": "车辆所在地省份",
     *     "loc_city": "车辆所在地城市",
     *     "loc_area": "车辆所在地区域",
     *     "transfer_times": "过户次数",
     *     "fixprice": "一口价"
     *     "status": "状态(1:待审核, 2：在售, 3：审核未通过)",
     *     "popularity_index": "人气指数",
     *     "dial_index": "拨号指数",
     *     "score": "会员积分",
     *     "opr_user": "发布人员编号"})
     *     ),
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
            $openid = $inputData->openid;

            if (empty($openid)) {
                $openid = "omeHE5JMk-2slRyL9293hdAxGvGg";
            }

            $params['price'] = $inputData->price;
            $params['models'] = $inputData->models;
            $params['boarddateyear'] = $inputData->boarddateyear;
            $params['boarddatemonth'] = $inputData->boarddatemonth;
            $params['proddateyear'] = $inputData->proddateyear;
            $params['proddatemonth'] = $inputData->proddatemonth;
            $params['realmileage'] = $inputData->realmileage;
            $params['condition'] = $inputData->condition;
            $params['contacttel'] = $inputData->contacttel;
            $params['vehicleimgs'] = json_encode($inputData->vehicleimgs, JSON_UNESCAPED_SLASHES);
            $params['weixinimg'] = $inputData->weixinimg;
            $params['guideprice'] = $inputData->guideprice;
            $params['displacement'] = $inputData->displacement;
            $params['configuration'] = $inputData->configuration;
            $params['loc_province'] = $inputData->loc_province;
            $params['loc_city'] = $inputData->loc_city;
            $params['loc_area'] = $inputData->loc_area;
            $params['transfer_times'] = $inputData->transfer_times;
            $params['fixprice'] = 0;
            $params['status'] = 1;
            $params['popularity_index'] = rand(1, 100);
            $params['dial_index'] = rand(1, 100);
            $params['score'] = 0;
            $params['opr_datetime'] = time();
            //$params['opr_user'] = $inputData->opr_user;
            /*add code =0 不然没法插入数据*/
            $params['code'] = 0;

            $model = new \app\api\model\Vehicle();
            $userinfo = $model->getuserid($openid);
            if (empty($userinfo)) {
                //添加用户并获取此用户信息
                $user = array();
                $user['username'] = "user_";
                $user['password'] = md5("123456");
                $user['roleid'] = 1;
                $user['openid'] = $openid;
                $user['mobileno'] = "";
                $user['createtime'] = time();
                $usermodel = new \app\api\model\User();
                $returnData = $usermodel->userAdd($user);
                //获取用户信息
                $userinfo = $model->getuserid($openid);
            }
            // print_r($userinfo);
            //exit;
            if (empty($userinfo)) {
                $userinfo = $model->getuserid("omeHE5JMk-2slRyL9293hdAxGvGg");
                //return Response::create(['resultCode' => 202, 'resultMsg' => '没有该用户！'], 'json', 202);
            }
            $params['opr_user'] = $userinfo['userid'];
            //print_r($params);
            //exit;
            $returnData = $model->vehicleAdd($params);
            if ($returnData == 1) {
                return Response::create(['resultCode' => 200, 'resultMsg' => '添加车辆成功！'], 'json', 200);
            } else {
                return Response::create(['resultCode' => 202, 'resultMsg' => '添加车辆失败！'], 'json', 202);
            }
        } catch (Exception $e) {
            return Response::create(['resultCode' => 4000, 'resultMsg' => $e->getMessage()], 'json', 400);
        }
    }

    /**
     * @SWG\Get(
     *     path="/api/vehicle/getonevehicleinfo?id={id}&openid={openid}",
     *     tags={"3-车辆管理部分接口"},
     *     operationId="getonevehicleinfo",
     *     summary="3.2-获取车辆信息",
     *     description="获取车辆信息(为小程序使用)。可只传一个参数id，获取我发布的车辆也是在这里",
     *     consumes={"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         description="id",
     *         required=false,
     *         format="string",
     *     ),
     *     @SWG\Parameter(
     *         name="openid",
     *         in="query",
     *         description="openid",
     *         required=false,
     *         format="string",
     *     ),
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response="200",
     *         description="",
     *         @SWG\Schema(ref="#/definitions/ApiResponse")
     *     ),
     *     security={{"petstore_auth":{"write:getonevehicleinfo", "read:getonevehicleinfo"}}}
     * )
     */
    public function getonevehicleinfo(Request $request)
    {
        $openid = $request->get("openid");
        $id = $request->get("id");

        if (empty($id)) {
            return Response::create(['resultCode' => 4000, 'resultMsg' => '请求参数错误！'], 'json', 400);
        }
        try {
            $params = array();

            $model = new \app\api\model\Vehicle();

            $params["id"] = $id;
            $returnData = $model->vehicleinfo($params);

            $config = $model->getconfig();
            $returnData['weixinimg1'] = $config['weixinimg1'];
            $returnData['weixinimg2'] = $config['weixinimg2'];

            if (!empty($openid)) {
                $userinfo = $model->getuserid($openid);

                if (empty($userinfo)) {
                    return Response::create(['resultCode' => 202, 'resultMsg' => '没有该用户！'], 'json', 202);
                }

                if ($returnData['opr_user'] == $userinfo['userid']) {
                    $returnData['self'] = "yes";
                } else {
                    $returnData['self'] = "no";
                }

            } else {
                $returnData['self'] = "no";
            }
            //print_r($returnData);
            //exit;
            // if($returnData[''])
            if (!empty($returnData)) {
                return Response::create(['resultCode' => 200, 'resultMsg' => $returnData], 'json', 200);
            } else {
                return Response::create(['resultCode' => 202, 'resultMsg' => '获取车辆失败！'], 'json', 200);
            }
        } catch (Exception $e) {
            return Response::create(['resultCode' => 4000, 'resultMsg' => $e->getMessage()], 'json', 400);
        }
    }

    /**
     * @SWG\Get(
     *     path="/api/vehicle/getvehicleinfo?openid={openid}&pricefrom={pricefrom}&priceto={priceto}&timefrom={timefrom}&timeto={timeto}&models={models}&self=1",
     *     tags={"3-车辆管理部分接口"},
     *     operationId="getvehicleinfo",
     *     summary="3.3-获取车辆信息",
     *     description="获取车辆信息(为小程序使用)。可只传一个参数，获取我发布的车辆也是在这里",
     *     consumes={"application/json"},
     *     @SWG\Parameter(
     *         name="openid",
     *         in="query",
     *         description="openid",
     *         required=false,
     *         format="string",
     *     ),
     *     @SWG\Parameter(
     *         name="pricefrom",
     *         in="query",
     *         description="价格开始",
     *         required=false,
     *         format="string",
     *     ),
     *     @SWG\Parameter(
     *         name="priceto",
     *         in="query",
     *         description="价格截止",
     *         required=false,
     *         format="string",
     *     ),
     *     @SWG\Parameter(
     *         name="timefrom",
     *         in="query",
     *         description="时间开始",
     *         required=false,
     *         format="string",
     *     ),
     *     @SWG\Parameter(
     *         name="timeto",
     *         in="query",
     *         description="时间截止",
     *         required=false,
     *         format="string",
     *     ),
     *     @SWG\Parameter(
     *         name="models",
     *         in="query",
     *         description="车型",
     *         required=false,
     *         format="string",
     *     ),
     *     @SWG\Parameter(
     *         name="self",
     *         in="query",
     *         description="如果要查自己发布的 那就加这个参数 值为1 不加默认所有",
     *         required=false,
     *         format="string",
     *     ),
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
        $openid = $request->param("openid");
        $pricefrom = $request->param("pricefrom");
        $priceto = $request->param("priceto");
        $timefrom = $request->param("timefrom");
        $timeto = $request->param("timeto");
        $models = $request->param("models");
        $self = $request->param("self");
        $status = $request->param("status");

        if (!empty($self)) {
            if ($self == 1) {
                if (empty($openid)) {
                    return Response::create(['resultCode' => 4000, 'resultMsg' => '请先登录！'], 'json', 400);
                }
            }
        }
        try {
            $params = array();

            if (!empty($pricefrom)) {
                $params[] = ['price', '>', $pricefrom];
            }
            if (!empty($priceto)) {
                $params[] = ['price', '<', $priceto];
            }
            if (!empty($timefrom)) {
                $params[] = ['opr_datetime', '>', $timefrom];
            }
            if (!empty($timeto)) {
                $params[] = ['opr_datetime', '<', $timeto];
            }
            if (!empty($models)) {
                $params[] = ['models', 'like', '%' . $models . '%'];
            }

            $model = new \app\api\model\Vehicle();
            if (!empty($openid)) {
                $userinfo = $model->getuserid($openid);
                if ($self == 1) {
                    if ($userinfo['roleid'] == 2) {//管理员显示所有车辆
                        $params[] = ['status', 'in', '1'];
                    } else {
                        $params[] = ['status', 'in', '2, 4'];
                        $params[] = ['opr_user', '=', $userinfo['userid']];
                    }
                } else {
                    if (!empty($userinfo)) {
                        if ($userinfo['roleid'] == 2) {//管理员显示所有车辆
                            $params[] = ['status', 'in', '1, 2, 4'];
                        } else {
                            $params[] = ['status', 'in', '2, 4'];
                        }
                    }
                }
            } else {
                if (!empty($status)) {
                    $params[] = ['status', 'in', '2, 4'];
                }
            }
//            print_r($params);
//            exit;
            $returnData = $model->vehicleinfo($params);

            if (!empty($returnData)) {
                foreach ($returnData as &$item) {
                    $item['vehicleimgs'] = str_replace('[', '', $item['vehicleimgs']);
                    $item['vehicleimgs'] = str_replace(']', '', $item['vehicleimgs']);
                    $item['vehicleimgs'] = str_replace('"', '', $item['vehicleimgs']);
                    $item['vehicleimgs'] = str_replace('\\', '', $item['vehicleimgs']);
                    $item['vehicleimgs'] = stripslashes($item['vehicleimgs']);
                    $item['arr'] = explode(',', $item['vehicleimgs']);
                }
            }
            if (!empty($returnData)) {
                return Response::create(['resultCode' => 200, 'resultMsg' => $returnData], 'json', 200);
            } else {
                return Response::create(['resultCode' => 202, 'resultMsg' => '无车辆！'], 'json', 200);
            }
        } catch (Exception $e) {
            return Response::create(['resultCode' => 4000, 'resultMsg' => $e->getMessage()], 'json', 400);
        }
    }

    /**
     * @SWG\Get(
     *     path="/api/vehicle/getvehicleinfoNew?openid={openid}&pricefrom={pricefrom}&priceto={priceto}&timefrom={timefrom}&timeto={timeto}&models={models}&self=1",
     *     tags={"3-车辆管理部分接口"},
     *     operationId="getvehicleinfoNew",
     *     summary="3.3-获取车辆信息",
     *     description="获取车辆信息(为小程序使用)。可只传一个参数，获取我发布的车辆也是在这里",
     *     consumes={"application/json"},
     *     @SWG\Parameter(
     *         name="openid",
     *         in="query",
     *         description="openid",
     *         required=false,
     *         format="string",
     *     ),
     *     @SWG\Parameter(
     *         name="pricefrom",
     *         in="query",
     *         description="价格开始",
     *         required=false,
     *         format="string",
     *     ),
     *     @SWG\Parameter(
     *         name="priceto",
     *         in="query",
     *         description="价格截止",
     *         required=false,
     *         format="string",
     *     ),
     *     @SWG\Parameter(
     *         name="timefrom",
     *         in="query",
     *         description="时间开始",
     *         required=false,
     *         format="string",
     *     ),
     *     @SWG\Parameter(
     *         name="timeto",
     *         in="query",
     *         description="时间截止",
     *         required=false,
     *         format="string",
     *     ),
     *     @SWG\Parameter(
     *         name="models",
     *         in="query",
     *         description="车型",
     *         required=false,
     *         format="string",
     *     ),
     *     @SWG\Parameter(
     *         name="self",
     *         in="query",
     *         description="如果要查自己发布的 那就加这个参数 值为1 不加默认所有",
     *         required=false,
     *         format="string",
     *     ),
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response="200",
     *         description="",
     *         @SWG\Schema(ref="#/definitions/ApiResponse")
     *     ),
     *     security={{"petstore_auth":{"write:getvehicleinfoNew", "read:getvehicleinfoNew"}}}
     * )
     */
    public function getvehicleinfoNew(Request $request)
    {
        $openid = $request->param("openid");
        $pricefrom = $request->param("pricefrom");
        $priceto = $request->param("priceto");
        $timefrom = $request->param("timefrom");
        $timeto = $request->param("timeto");
        $models = $request->param("models");
        $self = $request->param("self");
        $status = $request->param("status");
        $page = $request->param('page');

        if (empty($page)) {
            return Response::create(['resultCode' => 4000, 'resultMsg' => '参数错误！'], 'json', 400);
        }

        if (!empty($self)) {
            if ($self == 1) {
                if (empty($openid)) {
                    return Response::create(['resultCode' => 4000, 'resultMsg' => '请先登录！'], 'json', 400);
                }
            }
        }
        try {
            $params = array();

            if (!empty($pricefrom)) {
                $params[] = ['price', '>', $pricefrom];
            }
            if (!empty($priceto)) {
                $params[] = ['price', '<', $priceto];
            }
            if (!empty($timefrom)) {
                $params[] = ['opr_datetime', '>', $timefrom];
            }
            if (!empty($timeto)) {
                $params[] = ['opr_datetime', '<', $timeto];
            }
            if (!empty($models)) {
                $params[] = ['models', 'like', '%' . $models . '%'];
            }

            $model = new \app\api\model\Vehicle();
            if (!empty($openid)) {
                $userinfo = $model->getuserid($openid);
                if ($self == 1) {
                    $params[] = ['opr_user', '=', $userinfo['userid']];
                } else {
                    if (!empty($userinfo)) {
                        if ($userinfo['roleid'] == 2) {//管理员显示所有车辆
                            $params[] = ['status', 'in', '1, 2, 4'];
                        } else {
                            $params[] = ['status', 'in', '2, 4'];
                        }
                    }
                }
            } else {
                if (!empty($status)) {
                    $params[] = ['status', 'in', '2, 4'];
                }
            }
//            print_r($params);
//            exit;
            $returnData = $model->vehcilelist($params, $page);

            $returnCount = $model->vehicleCount($params);

            if (!empty($returnData)) {
                foreach ($returnData as &$item) {
                    $item['vehicleimgs'] = str_replace('[', '', $item['vehicleimgs']);
                    $item['vehicleimgs'] = str_replace(']', '', $item['vehicleimgs']);
                    $item['vehicleimgs'] = str_replace('"', '', $item['vehicleimgs']);
                    $item['vehicleimgs'] = str_replace('\\', '', $item['vehicleimgs']);
                    $item['vehicleimgs'] = stripslashes($item['vehicleimgs']);
                    $item['arr'] = explode(',', $item['vehicleimgs']);
                }
            }
            if (!empty($returnData)) {
                return Response::create(['resultCode' => 200, 'resultMsg' => $returnData, 'resultCount' => ceil($returnCount / 10)], 'json', 200);
            } else {
                return Response::create(['resultCode' => 202, 'resultMsg' => '无车辆！', 'resultCount' => 0], 'json', 200);
            }
        } catch (Exception $e) {
            return Response::create(['resultCode' => 4000, 'resultMsg' => $e->getMessage(), 'resultCount' => 0], 'json', 400);
        }
    }

    /**
     * @SWG\Get(
     *     path="/api/vehicle/updatestatus?id={id}&status={status}",
     *     tags={"3-车辆管理部分接口"},
     *     operationId="updatestatus",
     *     summary="3.3-更新车辆状态",
     *     description="更新车辆状态。更新车辆状态,status=2是审核通过 status=3是审核不通过",
     *     consumes={"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         description="id",
     *         required=false,
     *         format="string",
     *     ),
     *     @SWG\Parameter(
     *         name="status",
     *         in="query",
     *         description="状态",
     *         required=false,
     *         format="string",
     *     ),
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response="200",
     *         description="更新成功",
     *         @SWG\Schema(ref="#/definitions/ApiResponse")
     *     ),
     *     security={{"petstore_auth":{"write:updatestatus", "read:updatestatus"}}}
     * )
     */
    public function updatestatus(Request $request)
    {
        $id = $request->get("id");
        $status = $request->get("status");

        if (empty($id)) {
            return Response::create(['resultCode' => 4000, 'resultMsg' => '请求参数错误！'], 'json', 400);
        }
        try {

            $model = new \app\api\model\Vehicle();
            //print_r($params);
            //exit;
            $returnData = $model->vehicleupdate($id, $status);
            return Response::create(['resultCode' => 200, 'resultMsg' => '状态更新成功！'], 'json', 200);
        } catch (Exception $e) {
            return Response::create(['resultCode' => 4000, 'resultMsg' => $e->getMessage()], 'json', 400);
        }
    }

    /**
     * 更新价格(一口价)
     * @param Request $request
     * @return Response
     */
    public function updatePrice(Request $request)
    {
        $id = $request->get("id");
        $price = $request->get("price");

        if (empty($id)) {
            return Response::create(['resultCode' => 4000, 'resultMsg' => '请求参数错误！'], 'json', 400);
        }
        try {

            $model = new \app\api\model\Vehicle();
            $returnData = $model->vehiclePrice($id, $price);
            return Response::create(['resultCode' => 200, 'resultMsg' => '一口价更新成功！'], 'json', 200);
        } catch (Exception $e) {
            return Response::create(['resultCode' => 4000, 'resultMsg' => $e->getMessage()], 'json', 400);
        }
    }

}