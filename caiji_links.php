<?php

header("Content-type:text/html;charset=utf-8");

//采集链接，保存进数据库

//创建表 urls,用来保存电影地址链接
require ("./db.php");
$db = new DB;

$table_name = "urls";
$sql = "DROP DATABASE IF EXISTS $table_name;
	CREATE TABLE $table_name (
  id int(11) NOT NULL AUTO_INCREMENT,
  url varchar(255),
  PRIMARY KEY (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8";

$i = 1;
while ($i <= 534) {
	$links = get_links($i);
	$i++;
	foreach ($links as $key => $value) {
		$dataArray = array("url" => $value);
		$db -> insert($table_name, $dataArray);
	}

}
?>