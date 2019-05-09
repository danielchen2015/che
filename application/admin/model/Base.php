<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\5\6 0006
 * Time: 22:18
 */

namespace app\admin\model;

use think\Model;

class Base extends Model
{
    /**
     * 获取config配置文件中文件上传 API接口服务器地址
     * @return api接口服务器地址 string
     * @author daniel
     * @date 2019/1/7
     */
    public function _getServerUrl()
    {
        return Config::get('app.file_server_url');
    }

}