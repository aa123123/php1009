<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/11
 * Time: 16:21
 */

namespace Admin\Controller;


use Think\Controller;

class BaseController extends Controller
{

    protected $model;

    public function _initialize()
    {
        $this->model = D(CONTROLLER_NAME);
    }

    public function index()
    {
        //创建模型对象

        //得到查询的关键字
        $keyword = I('get.keyword', '');
        $wheres = array();
        if (!empty($keyword)) {
            $wheres['name'] = array("like", "%{$keyword}%");
        }


        //查看数据库查询出状态大于-1数据
        $pageResult = $this->model->getPageResult($wheres);
        //分配数据
        $this->assign($pageResult);

        //将当前url地址保存到cookie中
        cookie('__forword__', $_SERVER['REQUEST_URI']);
        $this->assign('meta_title',$this->meta_title);
        //显示到视图页面
        $this->display('index');
    }

    public function changeStatus($id, $status = -1)
    {
        //创建模型对象
        //使用模型修改
        $result = $this->model->changeStatus($id, $status);
        if ($result !== false) {
            $this->success('操作成功!', cookie('__forword__'));
        } else {
            $this->error('操作失败!' . show_model_error($this->model));
        }
    }

    public function add()
    {
        if (IS_POST) {
            //创建模型对象
            //使用create
            if ($this->model->create() !== false) {
                //保存数据到数据库
                if ($this->model->add() !== false) {
                    $this->success('添加成功!', U('index'));
                    return;//防止下面代码执行
                }
            }
            $this->error('操作失败!' . show_model_error($this->model));
        } else {
            $this->assign('meta_title', '添加' . $this->meta_title);
            $this->display('edit');
        }
    }

    public function edit($id)
    {
        if (IS_POST) {
            //接受请求参数create
            if ($this->model->create() !== false) {
                //修改到数据库中
                if ($this->model->save() !== false) {
                    $this->success('操作成功', cookie('__forword__'));
                    return;
                }
            }
            $this->error('操作失败' . show_model_error($this->model));

        } else {
            //查询出ID对应数据
            $row = $this->model->find($id);
            //分配到页面
            $this->assign($row);
            //显示视图页面
            $this->assign('meta_title', '编辑' . $this->meta_title);
            $this->display('edit');
        }
    }


}