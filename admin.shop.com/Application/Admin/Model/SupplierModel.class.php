<?php
namespace Admin\Model;


use Think\Model;

class SupplierModel extends BaseModel
{
// 每个表单都有自己的验证规则
protected $_validate = array(
array('name','require','供应商名称不能够为空'),
array('sort','require','排序不能够为空'),
array('status','require','是否显示不能够为空'),


);
}