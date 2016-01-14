<?php
namespace Admin\Model;


use Think\Model;

class BrandModel extends BaseModel
{
// 每个表单都有自己的验证规则
    protected $_validate = array(
        array('name', 'require', '品牌名称不能够为空'),
        array('url', 'require', '品牌网址不能够为空'),
        array('logo', 'require', '品牌LOGO不能够为空'),
        array('sort', 'require', '排序不能够为空'),
        array('status', 'require', '状态不能够为空'),


    );
}