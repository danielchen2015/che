<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\5\8 0008
 * Time: 2:31
 */

namespace app\api\model;

use think\Db;
use Wxxcx\WXBizDataCrypt;

class User extends Base
{
    public $OK = 0;
    public $IllegalAesKey = -41001;
    public $IllegalIv = -41002;
    public $IllegalBuffer = -41003;
    public $DecodeBase64Error = -41004;

    private $appid;
    private $sessionKey;

    /**
     * @param $data
     * 用户信息添加
     */
    public function userAdd($data)
    {
        $returnData = Db::table('che_user')
            ->field(['userid', 'roleid', 'username'])
            ->where('openid', '=', $data['openid'])
            ->where('mobileno', '=', $data['mobileno'])
            ->order('userid desc')->limit(1)->select();

        if (!empty($returnData)) {
            return 3;           //当此用户存在时，返回3
        } else {
            return Db::table('che_user')->data($data)->insert();
        }
    }

    /**
     * @param $openid
     * @param $mobileno
     * 返回用户数据信息
     */
    public function userInfo($openid, $mobileno)
    {
        $returnData = Db::table('che_user')
            ->field(['userid', 'roleid', 'username', 'password', 'openid', 'mobileno', 'createtime', 'updatetime'])
            ->whereOr('openid', '=', $openid)
            ->whereOr('mobileno', '=', $mobileno)
            ->order('userid desc')->limit(1)->select();

        if (!empty($returnData)) {
            return json_decode(json_encode($returnData[0], true));
        } else {
            return null;
        }

    }

    /**
     * 发送HTTP请求方法
     * @param string $url 请求URL
     * @param array $params 请求参数
     * @param string $method 请求方法GET/POST
     * @return array $data  响应数据
     */
    function http($url, $params, $method = 'GET', $header = array(), $multi = false)
    {
        $opts = array(
            CURLOPT_TIMEOUT => 30,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER => $header
        );
        /* 根据请求类型设置特定参数 */
        switch (strtoupper($method)) {
            case 'GET':
                $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
                break;
            case 'POST':
                //判断是否传输文件
                $params = $multi ? $params : http_build_query($params);
                $opts[CURLOPT_URL] = $url;
                $opts[CURLOPT_POST] = 1;
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
            default:
                throw new Exception('不支持的请求方式！');
        }
        /* 初始化并执行curl请求 */
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $data = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ($error) throw new Exception('请求发生错误：' . $error);
        return $data;
    }

    /**
     * @param $encryptedData
     * @param $iv
     * @param $sessionKey
     * @param $appid
     * @return mixed|null
     */
    public function wxdecode($encryptedData, $iv, $sessionKey, $appid)
    {
        $this->sessionKey = $sessionKey;
        $this->appid = $appid;

        $data = null;
        $errCode = $this->decryptData($encryptedData, $iv, $data);
        //echo $data;
        //return json(['data'=>$data]);
        $data = json_decode($data);

        if ($errCode == 0) {
            //print($data . "\n");
            //dump($data);
            return $data;
        } else {
            //print($errCode . "\n");
            //dump($errCode);
            return $errCode;
        }

    }

    /**
     * 检验数据的真实性，并且获取解密后的明文.
     * @param $encryptedData string 加密的用户数据
     * @param $iv string 与用户数据一同返回的初始向量
     * @param $data string 解密后的原文
     *
     * @return int 成功0，失败返回对应的错误码
     */
    public function decryptData($encryptedData, $iv, &$data)
    {
        if (strlen($this->sessionKey) != 24) {
            return $this->IllegalAesKey;
        }
        $aesKey = base64_decode($this->sessionKey);

        if (strlen($iv) != 24) {
            return $this->IllegalIv;
        }
        $aesIV = base64_decode($iv);

        $aesCipher = base64_decode($encryptedData);

        $result = openssl_decrypt($aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

        $dataObj = json_decode($result);
        if ($dataObj == NULL) {
            return $this->IllegalBuffer;
        }
        if ($dataObj->watermark->appid != $this->appid) {
            return $this->IllegalBuffer;
        }
        $data = $result;
        return $this->OK;
    }

}