<?php 

header("Content-type:text/html;charset=utf-8");
require ("./db.php");
require ("./get_links.php");
require ("./get_detail.php");
require ("./download_images.php");


$links = get_links();
echo "<br/>";

//去重
$links=array_unique($links);

$db = new DB;




//测试专用,用获取的links的前5个元素
$links = array_slice($links,0,5);  
print_r($links);
echo "<br/>";

foreach ($links as $key => $value) {
	echo "<br/>第" . $key . "个电影";
	get_detail($value,$db);
}

echo "<br/>";



?>