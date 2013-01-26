<?php
header("Content-type:text/html;charset=utf-8");

// require ("./config.db.php");
require ("./db.php");
require ("./get_links.php");

set_time_limit($db_config["time_limit"]);

//采集链接，保存进数据库

//创建表 urls,用来保存电影地址链接
// require("./config.db.php");

// $create_table_sql = "
// DROP DATABASE IF EXISTS moive_urls;
// CREATE TABLE moive_urls (
// id int(11) NOT NULL AUTO_INCREMENT,
// moive_url varchar(255),
// PRIMARY KEY (id)
// ) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
//
// $db = new DB;
// $db -> query($create_table_sql);

$db = new DB;
//
// $table_name = "urls";
// $sql = "
// CREATE TABLE urls (
// id int(11) NOT NULL AUTO_INCREMENT,
// url text,
// PRIMARY KEY (id)
// ) ENGINE=MyISAM  DEFAULT CHARSET=utf8";

// $db ->query($sql);

$i = 203;
while ($i <= 534) {
	echo $i . "<br/>";
	$links = get_links($i);
	print_r($links);
	$i++;
	$links = array_unique($links);
	print_r($links);
	foreach ($links as $key => $value) {
		$sql = "select * from moive_urls where moive_url = '$value'";
		$one = $db -> get_one($sql);
		print_r($one);
		echo "=========<br/>";
		// if(!empty($one)){
			// echo "不空<br/>";
		// }else{
			// echo "空";
		// };
		
		if(!empty($one)) {
			$dataArray = array("moive_url" => $value);
			$db -> insert("moive_urls", $dataArray);
		}

	}
	// $i++;

}
?>