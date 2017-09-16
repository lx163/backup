<?php 
/*
 功能：查询zy_article表，没有栏目(cid)的，加上随机的栏目(cid）
 说明：只给没有栏目的文章加，已经有栏目的不加。
 系统的栏目都是随机归类的，这一点没有做细。
 
 */

$conn = new mysqli('localhost','root','root','zhiyue');
$cat = $conn->query("select cid from zy_category");
$cat_arr = array();
while($row = $cat->fetch_array()){
	array_push($cat_arr,$row['cid']);
}


$art = $conn->query("select aid from zy_article where cid=0 ");

while($row = $art->fetch_array()){
	$aid = $row['aid'];
	$rand = array_rand($cat_arr);
	$cid = $cat_arr[$rand];
	$conn->query("update zy_article set cid={$cid} where aid={$aid}");
	echo '.';

}

 ?>