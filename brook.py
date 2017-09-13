# -*- coding: utf-8 -*-
"""
余弦相似性算法beta2.0(本次修改主要是通过只计算主干词语来提高相关性，去掉无用的停止词)
用于计算两个文本字符串的相似度
需要用到结巴分词, 算法耗时取决于字典(或者缓存字典)的加载时间
因此字典不宜过大，使用默认的字典就可以了
因为不需要进行精确的分词只是做相似度计算而已
如果需要使用自定义词典，那么可以在分词之前使用
jieba.load_userdict(ditname) 加入自定义词典
如果要屏蔽掉烦人的, 结巴的初始化输出显示:
Building prefix dict from the default dictionary ...
Loading model from cache /var/folders/h9/5172d1757k90s7p3ngzzgllm0000gn/T/jieba.cache
Loading model cost 0.410 seconds.
Prefix dict has been built succesfully.
这些东西, 那么可以打开jieba的__init__.py 文件删除掉对应的信息或者将输出写入文件等(自行处理)
算法参考文档: http://baike.baidu.com/item/%E4%BD%99%E5%BC%A6%E7%9B%B8%E4%BC%BC%E5%BA%A6
作者: brooks
MQQ: 76231607
"""
from jieba import posseg
import math
import time


def simicos(str1, str2):
    # 对两个要计算的字符串进行分词, 使用隐马尔科夫模型(也可不用)
    # 由于不同的分词算法, 所以分出来的结果可能不一样
    # 也会导致相似度会有所误差, 但是一般影响不大
    cut_str1 = [w for w, t in posseg.lcut(str1) if 'n' in t or 'v' in t]
    cut_str2 = [w for w, t in posseg.lcut(str2) if 'n' in t or 'v' in t]
    # 列出所有词
    all_words = set(cut_str1 + cut_str2)
    # 计算词频
    freq_str1 = [cut_str1.count(x) for x in all_words]
    freq_str2 = [cut_str2.count(x) for x in all_words]
    # 计算相似度
    sum_all = sum(map(lambda z, y: z * y, freq_str1, freq_str2))
    sqrt_str1 = math.sqrt(sum(x ** 2 for x in freq_str1))
    sqrt_str2 = math.sqrt(sum(x ** 2 for x in freq_str2))
    return sum_all / (sqrt_str1 * sqrt_str2)


if __name__ == '__main__':
    case1 = "法国留学签证预约时间"
    case2 = "法国留学签证审核时间"
    start = time.time()
    similarity = simicos(case1, case2)
    end = time.time()
    print
    print "耗时: %.3fs" % (end - start)
    print "相似度: %.3f" % similarity
