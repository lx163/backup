<?php 
/*

 脚本功能：把关键词表导入数据表中
1、导入两个字段
2、判断数据表是否已经存在相同的词


*/
// header('Content-type:text/html;charset:utf-8');
header("Content-type: text/html; charset=utf-8"); //这里记得charset后面是=，不是冒号

$conn = new mysqli("localhost","root","root","zhiyue");
if($conn->connect_error){
	die("连接失败".$conn->connect_error);
}
$conn->query("set names 'utf8'");
// $re = $conn->query($sql);
// while ($row = $re->fetch_array()) {
// 	echo $row[0];
// }
// $re = $conn->query("select * from zy_keyword where word like '%法国留学%'");
// echo $re->num_rows;

$key = file_get_contents('../word/fr6');//设置要导入的文件
$arr = explode("\n", $key);//这里用双引号，双引号有解析的作用
$count = 0;//计算新入库词的数量
foreach($arr as $line):
	$field = explode(" ",$line);//每一行按字段组成一个数组
	$re = $conn->query("select * from zy_keyword where word like '{$field[0]}'");
	if($re->num_rows == 0){//在表中搜索这个词，返回行数为0，表示表中无这个词，允许入库

		$conn->query("insert into zy_keyword (word,pri) values ('{$field[0]}','{$field[1]}')");
		$count++;
	}
	 // echo $field[0].'<br>';
	
endforeach;	

if(!$conn->connect_error){echo "导入成功条数:".$count;}

 ?>