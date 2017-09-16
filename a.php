<?php 

$a = "'eric|88','jack|99','tom|77'";
$b = explode(',', $a);
// var_dump($b);
foreach ($b as $key) {
	$c = explode('|', $key);
	var_dump($c);
}

 ?>