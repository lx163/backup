<?php 
header("Content-Type:text/html;charset=utf-8");
// 
echo "��ð���������";

$a = "www.houdunwang.com234";
echo preg_match("/\.com[^\d]/",$a,$arr)?"ƥ��":"��ƥ��";
echo '<br>';
var_dump($arr);

 ?>