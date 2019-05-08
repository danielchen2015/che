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
     *     path="/api/vehicle/uploadimg",
     *     tags={"1-车辆管理部分接口"},
     *     operationId="add",
     *     summary="3.1-添加图片",
     *     description="添加图片(为小程序使用)。",
     *     consumes={"application/json"},
     *     @SWG\Property(example={
     *     "img64" : "base64位图片"
     *      ),
     *     produces={"application/json"},
     *     @SWG\Response(
     *     {
     *         response="200",
     *         description="/upload/20190508213746_.jpeg",
     *         @SWG\Schema(ref="#/definitions/ApiResponse")
     *     ),
     *     security={{"petstore_auth":{"write:add", "read:add"}}}
     * )
     */
    public function uploadimg(Request $request){
        $base64_img=$request->post("img64");

        $up_dir = './upload/';//存放在当前目录的upload文件夹下

        if(!file_exists($up_dir)){
            mkdir($up_dir,0777);
        }

        if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_img, $result)){
            $type = $result[2];
            if(in_array($type,array('pjpeg','jpeg','jpg','gif','bmp','png'))){
                $new_file = $up_dir.date('YmdHis_').'.'.$type;
                if(file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_img)))){
                    $img_path = str_replace('../../..', '', $new_file);
                    $img_path = str_replace('.', '', $img_path);
                    //echo '图片上传成功</br>![](' .$img_path. ')';
                    return Response::create(['resultCode' => 200, 'resultMsg' => $img_path], 'json', 200);

                }else{
                    //echo '图片上传失败</br>';
                    return Response::create(['resultCode' => 200, 'resultMsg' => '图片上传失败'], 'json', 200);

                }
            }else{
                //文件类型错误
                //echo '图片上传类型错误';
                return Response::create(['resultCode' => 200, 'resultMsg' => '图片上传类型错误'], 'json', 200);
            }

        }else{
            //文件错误
            //echo '文件错误';
            return Response::create(['resultCode' => 200, 'resultMsg' => '文件错误'], 'json', 200);
        }
        //echo $imagebase64;
        //exit;
    }

    /**
     * @SWG\Post(
     *     path="/api/User/add",
     *     tags={"1-用户管理部分接口"},
     *     operationId="add",
     *     summary="1.1-添加用户",
     *     description="添加用户(为小程序使用)。",
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
            $params['vehicleimgs'] = $inputData->vehicleimgs;
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

            $model = new \app\api\model\Vehicle();
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


    public function base64EncodeImage () {
        $image_file="1.jpg";

        echo '<img src="'.$image_file.'"/>';
        $base64_image = '';
        $image_info = getimagesize($image_file);
        $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
        $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
        return $base64_image;
    }
}