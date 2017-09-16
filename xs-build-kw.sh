#!/bin/sh
# 建立之前会先清空原索引
/soft/xunsearch/sdk/php/util/Indexer.php --clean --source=mysql://root:root@localhost/zhiyue --sql="select kid,word from zy_keyword" --project=zy_keyword
