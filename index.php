<?php 
header("Content-Type:text/html;charset=utf-8");
// 
echo "콱봤가가가가가";

$a = "www.houdunwang.com234";
echo preg_match("/\.com[^\d]/",$a,$arr)?"튈토":"꼇튈토";
echo '<br>';
var_dump($arr);

 ?>