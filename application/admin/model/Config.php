<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\5\7 0007
 * Time: 22:23
 */

namespace app\admin\model;

use think\Db;

class Config extends Base
{
    /**
     * @return array|null|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function configInfo()
    {
        $returnData = Db::table('che_config')
            ->field(['title', 'company', 'mobile', 'telno', 'weixinimg1', 'weixinimg2', 'adimg1', 'adimg2', 'adimg3', 'adimg4'])->select();

        if (empty($returnData)) {
            return null;
        } else {
            return $returnData;
        }
    }

    /**
     * @param $data
     * 更新
     */
    public function configUpdate($data)
    {
        return Db::table('che_config')
            ->where('1', '=', 1)
            ->update(['title' => $data['title'], 'company' => $data['company'], 'mobile' => $data['mobile'], 'telno' => $data['telno'], 'weixinimg1' => $data['weixinimg1'], 'weixinimg2' => $data['weixinimg2'], 'adimg1' => $data['adimg1'], 'adimg2' => $data['adimg2'], 'adimg3' => $data['adimg3'], 'adimg4' => $data['adimg4']]);
    }

}