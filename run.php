<?php

header("Content-type:text/html;charset=utf-8");
// require ("./config.db.php");
require ("./db.php");
require ("./get_links.php");
require ("./get_detail.php");
require ("./download_images.php");

set_time_limit($db_config["time_limit"]);

$i = 1;
while ($i <= 1) {
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

		$sql = "select * from moive_urls where moive_url = '$value'";
		$one = $db -> get_one($sql);
		print_r($one);
		//如果已经存在这个地址，则略过,如果不存在，则下载，并把地址保存
		if (empty($one)) {
			get_detail($value, $db);
			$dataArray = array("moive_url" => $value,"is_caiji"=>1);
			$db -> insert("moive_urls", $dataArray);
		}else{
			echo "电影".$one["moive_url"]."已经存在！";
		}

		// echo $value."<br/>";
		// echo "第 $i 页 ；第" . $key . "个电影<br/>";

	}

	// echo "<br/>";

	// echo "The page is " . $i . "<br />";
	$i++;
}
?>