<?php

	require("./db.php");
	
	$create_table_sql = "
	DROP DATABASE IF EXISTS moives;
	CREATE TABLE moives (
  id int(11) NOT NULL AUTO_INCREMENT,
  description text NOT NULL,
  title varchar(255),
  image_url text,
  PRIMARY KEY (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8";

	$db = new DB;
	$db -> query($create_table_sql);

	
 
?>