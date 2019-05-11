<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\5\9 0009
 * Time: 12:53
 */

namespace app\api\model;


class Upload extends Base
{
    /**
     * @return string
     * Base64位转为图片
     */
    public function base64EncodeImage()
    {
        $image_file = "1.jpg";
        echo '<img src="' . $image_file . '"/>';
        $base64_image = '';
        $image_info = getimagesize($image_file);
        $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
        $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
        return $base64_image;
    }

    /*
     * 生成随机数
     * */
    function getRandomString($len, $chars=null)
    {
        if (is_null($chars)){
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        }
        mt_srand(10000000*(double)microtime());
        for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++){
            $str .= $chars[mt_rand(0, $lc)];
        }
        return $str;
    }

}