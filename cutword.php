<?php 

require_once '/soft/xunsearch/sdk/php/lib/XS.php';
$xs = new XS('demo');
$tokenizer = new XSTokenizerScws;
$text = '法国留学生可以退税吗';
$text1 = '法国留学生可以退税么';

// $words = $tokenizer->getResult($text);
// print_r($words);

$tops = $tokenizer->getTops($text, 20);
foreach ($tops as $key) {
	echo $key['word'].'|';
}
echo '<br>';
$tops = $tokenizer->getTops($text1, 20);
foreach ($tops as $key) {
	echo $key['word'].'|';
}

 ?>