<?php 

/*

实现的功能：

1、zy_keyword表中的关键词，在迅搜中（zy_keyword索引）搜索，把搜索结果的ID放到zy_keyword表的rela字段。
2、搜索结果取前50个
------------------- 
搜索的返回值是一个XSDocumentd的对象，取值方式：
取字段  $doc->title 或者 $doc['title']
取其他参数
	$doc->percent() 取百分比

----
迅搜操作：
bin/xs-ctl.sh restart
第一步：建立配置文件，在sdk/php/app/ 里面建立 http://www.xunsearch.com/tools/iniconfig
第二步：导入数据 util/Indexer.php --source=mysql://root:root@localhost/zhiyue --sql="select aid,title,content from zy_article" --project=zy_article
第三步：生成本地测试框架 util/SearchSkel.php demo /path/to/web

 */

require_once '/soft/xunsearch/sdk/php/lib/XS.php';
$xs = new XS('zy_keyword');

$conn = new mysqli("localhost","root","root","zhiyue");
if($conn->connect_error){
	die("连接失败".$conn->connect_error);
}
$words = $conn->query("select word from zy_keyword");

/*逐行处理关键词*/ 

 while($row = $words->fetch_array()){
 	// setFuzzy() 设置模糊搜索
 	$docs = $xs->search->setFuzzy()->setLimit(20)->setQuery($row[0])->search();

	$list_arr = array();
	$list_arr_name = array();

	//把搜索结果的id值压入数组
	foreach($docs as $doc):
		if($doc->word != $row[0]){
			array_push($list_arr,$doc->kid);
			array_push($list_arr_name,$doc->word);

		}		
	endforeach;
	$list = implode(',',$list_arr);//数组拆成字符串
	$list_name = implode(',',$list_arr_name);

    // 搜索结果不为0的，加入数据库
	if($list){
		// echo $row[0];var_dump($list);
		$conn->query("update zy_keyword set rela ='{$list}',rela_name = '{$list_name}' where word = '{$row[0]}'");
	}
	echo $row[0].' '.count($list_arr).'<br>';
 }
 ?>