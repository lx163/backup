<?php 

/*

功能：给zy_article表加上keyword值。
keyword格式：“'kid||word'@#'kid||word'”,因为组成一个url需要这2个要素,使用时用两次explode进行数据分解。
算法：迅搜
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
----
shell脚本操作：
xs-restart.sh 重启xunsearch
xs-build-art.sh 建立文章索引，索引对象名称：zy_article（建立时会先清空之前的索引）
xs-build-kw.sh 建立关键词索引，索引对象名称：zy_keyword（建立时会先清空之前的索引）
 */

require_once '/soft/xunsearch/sdk/php/lib/XS.php';
$xs = new XS('zy_keyword');

$conn = new mysqli("localhost","root","root","zhiyue");
if($conn->connect_error){
	die("连接失败".$conn->connect_error);
}
$titles = $conn->query("select aid,title from zy_article");

/*逐行处理关键词*/ 

 while($row = $titles->fetch_array()){
 	// setFuzzy() 设置模糊搜索
 	
 	$docs = $xs->search->setFuzzy()->setLimit(10)->setQuery($row[1])->search();

	$keyword_arr = array();
	$keyword_arr_name = array();

	//把搜索结果的id值压入数组
	foreach($docs as $doc):
		if($doc->title != $row[1]){
			array_push($keyword_arr,$doc->kid.'||'.$doc->word);//||作为分隔符
			// array_push($list_arr_name,$doc->title);

		}		
	endforeach;
	$keyword = implode('@#',$keyword_arr);//数组拆成字符串,@#作为分隔符。
	// $list_name = implode(',',$list_arr_name);

    // 搜索结果不为0的，加入数据库
	if($keyword){
		// echo $row[0];var_dump($list);
		$conn->query("update zy_article set keyword ='{$keyword}' where aid = {$row[0]}");
	}
	echo $row[1].' '.count($keyword_arr).'<br>';
 }
 ?>