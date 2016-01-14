<?php
header('Content-Type: text/html;charset=utf-8');
echo '<pre>';

//$str = '供应商简介@textarea';
$str = '状态@radio|1=是&0=否';
if(strpos($str,'@')===false){
//    $str
}else{
    $pattern  = '/(.*)@([a-z]*)\|?(.*)/';
    preg_match($pattern,$str,$result);
    var_dump($result);
}