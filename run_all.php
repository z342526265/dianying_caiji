<?php

header("Content-type:text/html;charset=utf-8");
// require ("./config.db.php");
require ("./db.php");
require ("./get_links.php");
require ("./get_detail.php");
require ("./download_images.php");

set_time_limit($db_config["time_limit"]);

$db = new DB;

$i = 1;
while ($i < 10002) {

	$link_sql = "select * from moive_urls where (is_caiji = 0 or is_caiji is null) limit 1";

	//获取所以url地址
	$links = $db -> get_all($link_sql);
	echo "<br/>";

	//去重
	// $links = array_unique($links);

	//测试专用,用获取的links的前5个元素
	// $links = array_slice($links,0,5);
	// print_r($links);
	// echo "<br/>";

	foreach ($links as $key => $value) {
		echo $value['moive_url'] . "<br/>";
		echo "第" . $i . "个电影<br/>";
		get_detail($value['moive_url'], $db);
		$value['is_caiji'] = 1;
		$dataArray = array('is_caiji'=>1);
		// $dataArray = $value[]
		$condition = "moive_url = '$value[moive_url]'";
		echo $condition;
		$db -> update('moive_urls', $dataArray, $condition);
	}
	$i++;

}

// echo "<br/>";

// echo "The page is " . $i . "<br />";
// $i++;
?>