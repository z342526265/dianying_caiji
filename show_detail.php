<?php
header("Content-type:text/html;charset=utf-8");
// require ("./get_links.php");
require ("./db.php");
// echo "kkkkkkkkkkkkkkk";


$db = new DB;
$sql = "SELECT id,title,image_url,description FROM moives LIMIT 15; ";
$data = $db->get_all($sql);
foreach ($data as $key => $value) {
	// $db -> write_log($value['description']);
	// $db -> write_log($value['image_url']);
	// print_r($value);
	echo $value['title'];
	echo $value['description'];
	// $folder_name = $value['id'];
	$image_folder = "./images/$value[id]";
	foreach (split(",",$value['image_url']) as $key => $value) {
		$image_name = strrchr($value,'/');
		$image_name = str_replace('/', "", $image_name);
		$image_url = $image_folder."/".$image_name;
		
		echo "<image src=$image_url />";
	}
	// echo $value['description'];
	// echo $value['description'];
}
?>

