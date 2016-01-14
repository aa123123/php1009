<extend name="Common/edit"/>

<block name="form">
    <div class="main-div">
        <form method="post" action="{:U()}">
            <table cellspacing="1" cellpadding="3" width="100%">
                <?php foreach($fields as $field):  ?>
                <tr>
                    <td class="label"><?php echo $field['comment']?></td>
                    <td>
                        <?php
                           //就是根据数据表字段的注解生成不同的表单元素
                            if(!isset($field['field_type'])){
                               //如果没有指定类型, 默认为text类型的表单元素
                               if($field['field']=='sort'){
                                 echo "<input type='text' name='{\$sort}' maxlength='60' value='{\$sort|default=20}' />";
                               }else{
                                 echo "<input type='text' name='{$field['field']}' maxlength='60' value='{\${$field['field']}}' />";
                               }

                            }elseif($field['field_type']=='textarea'){
                                //生成多行文本框
                               echo "<textarea  name='{$field['field']}' cols='60' rows='4'  >{\${$field['field']}}</textarea>";
                            }elseif($field['field_type']=='radio'){
                                //生成单选框
                                foreach($field['option_values'] as $k=>$v){
                                    echo "<input type='radio' class='{$field['field']}' name='{$field['field']}' value='{$k}'/> {$v}";
                                }
                            }elseif($field['field_type']=='file'){
                                 echo "<input type='file' name='{$field['field']}' maxlength='60'/>";
                            }


                        ?>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <?php endForeach; ?>

                <tr>
                    <td colspan="2" align="center"><br />
                        <input type="hidden" name="id" value="{$id}"/>
                        <input type="submit" class="button ajax-post" value=" 确定 " />
                        <input type="reset" class="button" value=" 重置 " />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</block>