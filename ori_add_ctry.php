<?php 

/*
功能：给采集数据中，没有获取到国家（ctry）字段的数据，加上国家字段。
算法：title中含有国家名称的，加上相应的别名。

 */

$conn = new mysqli("localhost",'root','root','zhiyue');
$re = $conn->query('select * from zy_ctry');
$ctry_arr = array();
while ($row=$re->fetch_array()) {

	array_push($ctry_arr,array($row['ctryname'],$row['ctry']));
}//打开zy_ctry表，获取国家+别名二维数组

$conn->close();

$table = 'data_content_1588';//设置要操作的数据表
$conn_vr = new mysqli('10.211.55.4','root','root','liuxue');//连接虚拟机
$re_vr = $conn_vr->query("select Id,title,ctry from {$table} where ctry=''");

while ($row=$re_vr->fetch_array()) {
	$title = $row['title'];
	$id = $row['Id'];

	foreach($ctry_arr as $c):
		if(strpos($title,$c[0]) !== false){//这里必须用!==false,避免在第0个位置找到字符串。
			$conn_vr->query("update {$table} set ctry='{$c[1]}' where Id = {$id}");
			echo ".";
			// echo $title.'+++'.$c[0];
			break;
		}
	endforeach;
}

 ?>

