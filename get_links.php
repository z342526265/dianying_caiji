<?php
set_time_limit($db_config["time_limit"]);
//获取最新更新页的所以电影链接
function get_links($page) {
	//获取最新更新页面的内容
	// $url = "http://www.f1dy.net/index.php?s=video/lists/id/$page.html";
	$url = "http://www.f1dy.net/index.php?s=video/lists/id/1/p/$page.html";
	echo "<br/>$url";
	$lines_array = file($url);
	// echo $lines_array;
	//转换成字符串
	$lines_string = implode('', $lines_array);
	
	
	
	//先替换掉\n，再进行匹配
	$lines_string = preg_replace('/\n/', '', $lines_string);
	
	//再替换掉\r，再进行匹配
	$lines_string = preg_replace('/\r/', '', $lines_string);
	
	//替换掉影片列表内容之前的内容
	$lines_string = preg_replace('/.*<!-- 影片列表内容 begin-->/', "", $lines_string);

	//替换掉影片列表内容之后的内容
	$lines_string = preg_replace('/<!-- 影片列表内容 end-->.*/', '', $lines_string);
	
	

	//正则表达式匹配页面电影详情地址
	// $reg = '/href=\"\/detail\/.*?\.html\"/';
	$reg = '/<h3><a href=\"\/detail\/.*?\.html\"/';
	// $reg = '/<a.*>/';
	// echo $reg;
	// echo "<br/>";

	//匹配出链接,放入数组$out_arr；
	$out_arr = array();
	// echo "==========<br/>";
	preg_match_all($reg, $lines_string, $out_arr);
	// echo $out_arr;
	// print_r($out_arr);
	$links = array();
	foreach ($out_arr as $arr) {
		// echo "---------<br/>";
		// echo $arr;
		//替换掉数组字符串中的双引号
		$arr = str_replace('"', '', $arr);
		$links = str_replace('<h3><a ', '', $arr);
		// $links = $arr;
		return $links;
	}
}

// print_r(get_links());

?>

