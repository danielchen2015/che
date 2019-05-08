<?php
/**
 * Created by daniel.
 * User: daniel
 * Date: 2019/1/14
 * Time: 下午6:16
 */
namespace sunlightlease;

/**
 * @SWG\Definition(type="object",description="通用返回结果对象")
 */
class ApiResponse
{
    /**
     * @SWG\Property(example="G00000010")
     * @var string
     */
    public $resultId;

    /**
     * @SWG\Property(enum={"000000", "999990", "999999", "600100", "650100", "650200", "100001", "100002"},example="000000")
     * @var string[]
     */
    public $resultCode;

    /**
     * @SWG\Property(example="结果信息")
     * @var string
     */
    public $resultMsg;

    /**
     * @SWG\Property(example={"pageNumber":"1","pageSize":"1","totalRecords":"16"})
     * @var object
     */
    public $pageReturn;

    /**
     * @SWG\Property(example={json结构体})
     * @var object
     */
    public $list;
}