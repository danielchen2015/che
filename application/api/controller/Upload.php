<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\5\9 0009
 * Time: 12:53
 */

namespace app\api\controller;


class Upload extends Base
{
    /**
     * @SWG\Post(
     *     path="/api/Upload/uploadimg",
     *     tags={"4-车辆管理部分接口"},
     *     operationId="uploadimg",
     *     summary="4.1-添加图片",
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
     *     security={{"petstore_auth":{"write:uploadimg", "read:uploadimg"}}}
     * )
     */
    public function uploadimg(Request $request)
    {
        $base64_img = $request->post("img64");
        $up_dir = './upload/';//存放在当前目录的upload文件夹下
        if (!file_exists($up_dir)) {
            mkdir($up_dir, 0777);
        }
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_img, $result)) {
            $type = $result[2];
            if (in_array($type, array('pjpeg', 'jpeg', 'jpg', 'gif', 'bmp', 'png'))) {
                $new_file = $up_dir . date('YmdHis_') . '.' . $type;
                if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_img)))) {
                    $img_path = str_replace('../../..', '', $new_file);
                    $img_path = str_replace('.', '', $img_path);
                    //echo '图片上传成功</br>![](' .$img_path. ')';
                    return Response::create(['resultCode' => 200, 'resultMsg' => $img_path], 'json', 200);
                } else {
                    //echo '图片上传失败</br>';
                    return Response::create(['resultCode' => 200, 'resultMsg' => '图片上传失败'], 'json', 200);
                }
            } else {
                //文件类型错误
                //echo '图片上传类型错误';
                return Response::create(['resultCode' => 200, 'resultMsg' => '图片上传类型错误'], 'json', 200);
            }
        } else {
            //文件错误
            //echo '文件错误';
            return Response::create(['resultCode' => 200, 'resultMsg' => '文件错误'], 'json', 200);
        }
        //echo $imagebase64;
        //exit;
    }

}