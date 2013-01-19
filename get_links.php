<?php

//获取最新更新页的所以电影链接
function get_links($page) {
	//获取最新更新页面的内容
	$url = 'http://www.f1dy.net/index.php?s=video/lists/id/$page.html';
	$lines_array = file($url);
	// echo $lines_array;
	//转换成字符串
	$lines_string = implode('', $lines_array);

	//正则表达式匹配页面电影详情地址
	$reg = '/href=\"\/detail\/.*\.html\"/';
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
		$links = str_replace('"', '', $arr);
		// $links = $arr;
		return $links;
	}
}

// print_r(get_links());

?>

