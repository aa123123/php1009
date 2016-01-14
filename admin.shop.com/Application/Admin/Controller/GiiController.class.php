<?php


namespace Admin\Controller;


use Think\Controller;

class GiiController extends Controller
{
       public function index(){
           if(IS_POST){
               header('Content-Type:text/html;charset=utf-8;');
               //根据传递过来的表名,通过表名找到表
                $table_name = I('post.table_name');
               //生成thinkphp规范名称
               $name = parse_name($table_name,1);
               //得到注释
               $sql = "select  TABLE_COMMENT from information_schema.`TABLES`  where TABLE_SCHEMA = '".C('DB_NAME')."' and TABLE_NAME = '{$table_name}'";
               $model = M();
               $rows = $model->query($sql);
               $meta_title = $rows[0]['table_comment'];

               //查询表中字段信息
               $sql = "show full columns from ".$table_name;
               $fields = $model->query($sql);
               //对firlds处理
               foreach($fields as $k=>&$field){
                   if($field['field']=='id'){
                       unset($fields[$k]);
                   }
                   $comment = $field['comment'];
                   if(strpos($comment,'@')!==false) {
                       $pattern  = '/(.*)@([a-z]*)\|?(.*)/';
                       preg_match($pattern,$comment,$result);
                       $field['comment']= $result[1];
                       $field['field_type']= $result[2];
                       if(!empty($result[3])){
                           parse_str($result[3],$option_values);
                           $field['option_values']= $option_values;
                       }
                   }
               }
                unset($field);
               // 定义模板目录
               defined('TPL_PATH') or define('TPL_PATH',ROOT_PATH.'Template/');
               //生成代码
               ob_start();
               require TPL_PATH.'Controller.tpl';

               $controller_content = "<?php\r\n".ob_get_clean();

                $controller_path = APP_PATH.'Admin/Controller/'.$name.'Controller.class.php';
                file_put_contents($controller_path,$controller_content);


               //生成模型
               ob_start();//再次开启缓存
               require TPL_PATH.'Model.tpl';
               $model_content = "<?php\r\n".ob_get_clean();
                $model_path = APP_PATH.'Admin/Model/'.$name.'Model.class.php';
               file_put_contents($model_path,$model_content);

               //>>生成edit
               ob_start();//再次开启ob缓存
               require TPL_PATH.'edit.tpl';
               $edit_content = ob_get_clean();
               $edit_dir = APP_PATH.'Admin/View/'.$name;
               if(!is_dir($edit_dir)){ //如果存放视图文件是否存在,如果不存在就创建
                   mkdir($edit_dir,0777,true);
               }
               $edit_path = $edit_dir.'/edit.html';
               file_put_contents($edit_path,$edit_content);

               //>>生成index
               ob_start();//再次开启ob缓存
               require TPL_PATH.'index.tpl';
               $index_content = ob_get_clean();
               $index_dir = APP_PATH.'Admin/View/'.$name;
               if(!is_dir($index_dir)){ //如果存放视图文件是否存在,如果不存在就创建
                   mkdir($index_dir,0777,true);
               }
               $index_path = $index_dir.'/index.html';
               file_put_contents($index_path,$index_content);



           }else{
                  $this->assign('meta_title','代码生成器');
                  $this->display('index');
           }

       }
}