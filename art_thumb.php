<?php 
/*

 art_前缀，表示对zy_article表进行操作。
 功能：给zy_article表的缩略图（thumb）字段赋值。
 算法：/img/thumb 文件夹下生成1000张缩略图，随机选一张，只要thumb为空，就赋值。
 说明：缩略图全部是.jpg格式
*/

function myreaddir($dir) {
$handle=opendir($dir);
$i=0;
while($file=readdir($handle)) {
if (strpos($file,'.jpg')!==false) {
$list[$i]=$file;
$i=$i+1;
}
}
closedir($handle); 
return $list;
}

$list = myreaddir('../ci/img/thumb');//设置缩略图文件夹

// var_dump($list);

$conn = new mysqli('localhost','root','root','zhiyue');
$conn->query("set names utf8");

$re = $conn->query("select aid from zy_article where thumb=''");

while($row=$re->fetch_array()){

	$r = array_rand($list,1);
	$thumb = str_replace('.jpg', '', $list[$r]);//去掉.jpg后缀，以数字作为存储。
	$aid = $row['aid'];
    // echo $thumb.'+'.$aid.'   ';

	$conn->query("update zy_article set thumb = '{$thumb}' where aid = {$aid}");
	echo '.';
}


 ?>