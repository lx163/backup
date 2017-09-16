<?php 
/*
 功能：给zy_article表加上随机的推荐院校（school）值，院校是当前国家下的。

 说明：根据国家字段（ctry）添加学校（school），所以，运行这个脚本的前提是先要有国家字段。

 ori_add_ctry.php 添加国家字段。
 
 注意：有部分国家没有院校，所以脚本跑完，没有院校的国家，shool仍然是空的。
 */

$conn = new mysqli('localhost','root','root','zhiyue');
$conn->query("set names 'utf8'");


function rand_school($ctry){
	// $conn = new mysqli('localhost','root','root','zhiyue');
	// $conn->query("set names 'utf8'");
    global $conn;
	$sch_obj = $conn->query("select sid,zname from zy_school where ctry='{$ctry}' order by rand() limit 10");

	$sch_arr =array();

	while($row = $sch_obj->fetch_array()){
		
		array_push($sch_arr,$row['sid'].'||'.$row['zname']);
	}

	$sch = implode('@#', $sch_arr);

	return $sch;
}


$a = $conn->query("select aid,ctry from zy_article where school=''");
// echo $a->num_rows;die;

while($row = $a->fetch_array()){
	$aid = $row['aid'];
	$ctry = $row['ctry'];

	$school = rand_school($ctry);
	$conn->query("update zy_article set school='{$school}' where aid={$aid} ");
	echo '.';
}

 ?>