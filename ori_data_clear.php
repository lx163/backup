<?php 
/*
功能：对采集到的数据，进行清洗，使用php做一些正则的处理，mysql本身对正则的支持不是很好。
远程连接，直接对虚拟机中的数据库进行操作，爽感！


正则表达式，记得括号<p>? 和(<p>)?是有大区别的！！！

 */
$table = 'Data_Content_1588';//设置要清洗的表
$sql = "select * from {$table} where content like '%更多资讯%'";	//自定义sql语句
$pre_arr = array(//定义正则语句
	"/<span>，更多资讯欢迎在线咨询.*/",
	);
$rep_arr = array(//定义替换语句
	"</p>",
	);
/*以上是自定义部分*/
$conn = new mysqli("10.211.55.4","root","root","liuxue");
if($conn->connect_error){
	die('数据库连接错误:'.$conn->connect_error);
}
$conn->query("set names 'utf8'");
//数据库名称搞错了，一直生怕是数据库连接不上，搞得都快怀疑人生了。。。
//查询是很慢的，注意看浏览器的状态圈圈，加载完了再下结论，搞得都快怀疑人生了。。。。
$re = $conn->query($sql);
// var_dump($re);
if($re->num_rows == 0){die('没有查询出数据！！！！！');}

while($row = $re->fetch_array()){	//	自定义正则和替换的内容	
    $id = $row['Id'];
	$con = preg_replace($pre_arr,$rep_arr, $row['content']); 

	$s = $conn->query("update {$table} set content = '{$con}' where Id = {$id}");
	// sql语句中，字符串类型的变量要加引号
    //var_dump($s)
    if($s){echo '.';}else{die('sql语句失败');}
}


 ?>