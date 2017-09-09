<?php 
/*
功能：对采集到的数据，进行清洗，使用php做一些正则的处理，mysql本身对正则的支持不是很好。
远程连接，直接对虚拟机中的数据库进行操作，爽感！


正则表达式，记得括号<p>? 和(<p>)?是有大区别的！！！

 */
$table = 'Data_Content_1587';//设置要清洗的表
$sql = "select * from {$table} where content like '%柳橙网每天%'";	//自定义sql语句

$conn = new mysqli("10.211.55.4","root","root","liuxue");
if($conn->connect_error){
	die('数据库连接错误:'.$conn->connect_error);
}
$conn->query("set names 'utf8'");
//数据库名称搞错了，一直生怕是数据库连接不上，搞得都快怀疑人生了。。。
//查询是很慢的，注意看浏览器的状态圈圈，加载完了再下结论，搞得都快怀疑人生了。。。。
$re = $conn->query($sql);
// var_dump($re);
if($re->num_rows == 0){die('没有查询出数据........');}

while($row = $re->fetch_array()){	//	自定义正则和替换的内容	
    $id = $row['Id'];
	$con = preg_replace("/(<p>)?(<strong>)?(<span>)?柳橙网每天.*<\/p>/", "</p>", $row['content']); 

	$r=$conn->query("update {$table} set content = '{$con}' where Id = 3848");
	// {$table}加单引号又是错的。。。咋整的？
    var_dump($r);
}


 ?>