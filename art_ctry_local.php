<?php 

/*
说明:这个工具一般不使用！！！
加国家字段的功能一般用于采集后的原始数据，这个脚本是服务器上运行的版本。

功能：给采集数据中，没有获取到国家（ctry）字段的数据，加上国家字段。
算法：title中含有国家名称的，加上相应的别名。如果不含国家名称的，随机加上国家。

 */

$conn = new mysqli("localhost",'root','root','zhiyue');
$re = $conn->query('select * from zy_ctry');
$ctry_arr = array();
while ($row=$re->fetch_array()) {

	array_push($ctry_arr,array($row['ctryname'],$row['ctry']));
}//打开zy_ctry表，获取国家+别名二维数组

$conn->close();

$table = 'zy_article';//设置要操作的数据表
$conn_vr = new mysqli('localhost','root','root','zhiyue');//连接虚拟机
$re_vr = $conn_vr->query("select aid,title,ctry from {$table} where ctry=''");

while ($row=$re_vr->fetch_array()) {

	$title = $row['title'];
	$aid = $row['aid'];

	foreach($ctry_arr as $c):
		if(strpos($title,$c[0]) !== false){//这里必须用!==false,避免在第0个位置找到字符串。
			$conn_vr->query("update {$table} set ctry='{$c[1]}' where aid = {$aid}");
			echo ".";
			// echo $title.'+++'.$c[0];
			break;
		}else{
			$rand = array_rand($ctry_arr);//array_rand()随机取数组的键
			$ctry_rand = $ctry_arr[$rand][1];
			$conn_vr->query("update {$table} set ctry='{$ctry_rand}' where aid = {$aid}");
			echo "+";
		}
	endforeach;
}

 ?>

