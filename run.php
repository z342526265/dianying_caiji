<?php

header("Content-type:text/html;charset=utf-8");
require ("./db.php");
require ("./get_links.php");
require ("./get_detail.php");
require ("./download_images.php");

$i = 1;
while ($i <= 534) {
	$links = get_links($i);
	echo "<br/>";

	//去重
	$links = array_unique($links);

	$db = new DB;

	//测试专用,用获取的links的前5个元素
	// $links = array_slice($links,0,5);
	print_r($links);
	echo "<br/>";

	foreach ($links as $key => $value) {
		echo $value."<br/>";
		echo "第 $i 页 ；第" . $key . "个电影<br/>";
		get_detail($value, $db);
	}

	// echo "<br/>";

	echo "The page is " . $i . "<br />";
	$i++;
}
?>