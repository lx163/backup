# encoding=utf-8
import sys
reload(sys)
sys.setdefaultencoding( "utf-8" )

import jieba
import jieba.analyse
jieba.load_userdict("./userdict.txt")
jieba.analyse.set_stop_words("./stopwords.txt")

f=open("a.txt","w")

for line in open("fr6"):
	seg_list = jieba.analyse.extract_tags(line,20)
	f.write("|".join(seg_list))
	f.write(" "+line)