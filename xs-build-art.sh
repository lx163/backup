#!/bin/sh
# 建立之前会先清空原索引
/soft/xunsearch/sdk/php/util/Indexer.php --clean --source=mysql://root:root@localhost/zhiyue --sql="select aid,title,content,ctry from zy_article" --project=zy_article
