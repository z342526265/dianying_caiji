<?php

//获取最新更新页的所以电影链接并把相关数据保存进数据库
function get_detail($link, $db) {

	//echo '开始<br/>';
	//获取最新更新页面的内容
	$url = str_replace('href=', 'http://www.f1dy.net', $link);

	// echo $url . '<br/>';

	$lines_array = file($url);
	// $content_arr = array_slice($lines_array, 200, 80);
	$content_str = join($lines_array, '');

	//获取电影名称
	$title_arr = array();
	$title_reg = '/(《.*》)剧情简介/';
	
	preg_match_all($title_reg, $content_str, $title_arr);
	$title = $title_arr[1][0];
	
	echo $title."<br/>";
	echo "TTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTT";

	//先替换掉\n，再进行匹配
	$content_str = preg_replace('/\n/', '', $content_str);
	
	//替换掉剧情简介之前和之后5行的内容
	$content_str = preg_replace('/.*<!--剧情简介 begin-->(.*?<br \/>){4,5}/', "", $content_str);

	//替换掉剧情简介之后的内容
	$content_str = preg_replace('/<!--剧情简介 end-->.*/', '', $content_str);
	
	
	//获取图片地址
	//正则表达式匹配图片地址
	$image_reg = '/http[^(影片截图)(简介)><]*?\.(jpg|png|jpeg|gif|bmp)/';

	//匹配出链接,放入数组$out_arr；
	$image_arr = array();
	preg_match_all($image_reg, $content_str, $image_arr);
	print_r($image_arr);
	echo "================================================================================";
	$url_str = join(',', $image_arr[0]);
	
	
	//替换掉影片截图部分，只保留文字部分作为简介内容
	$content_str = preg_replace('/[^(<\/p>)]*影片截图.*/', '', $content_str);
	
	//替换掉 <span style="color:blue;">◎IMDB链接 这些内容
	$content_str = preg_replace('/<span style="color:blue;">◎IMDB链接.*?<br \/>/', '', $content_str);
	

	// echo $content_str."<br/>";

	//获取文字信息
	// $wenzi = strip_tags($content_str);

	$wenzi = $content_str;

	

	//写入文件夹data，每个电影一个文件，文件名为电影名称

	$data_handle = fopen("./data/" . $title . ".txt", "w+");
	fwrite($data_handle, $url_str . "\n\r");
	fwrite($data_handle, $wenzi);

	//下载图片，图片保存在文件夹images中，每个电影一个文件夹，文件夹名称为电影名称，文件夹内图片名称为图片url最后一个'/'之后的部分

	//替换掉特殊字符
	$wenzi = str_replace('user', '', $wenzi);
	//user 必须替换掉，否则mysql报错。
	// $wenzi = str_replace("\n", '', $wenzi);
	// $wenzi = str_replace("\r", '', $wenzi);
	// $wenzi = str_replace(" ", '', $wenzi);
	// $wenzi = str_replace("	", '', $wenzi);

	//保存到数据库
	$wenzi = mysql_real_escape_string($wenzi);
	$url_str = mysql_real_escape_string($url_str);
	$title = mysql_real_escape_string($title);

	$dataArray = array('description' => $wenzi, 'image_url' => $url_str, 'title' => $title);
	//寻找是否有同名的电影即title相同，如果有，则更新。
	$get_sql = "select * from moives where title = '$title'";
	$one = $db -> get_one($get_sql);
	if (empty($one)) {
		$db -> insert('moives', $dataArray);
	} else {
		$db -> update('moives', $dataArray, "title = '$title'");
	};

	$new_one = $db -> get_one($get_sql);

	// print_r($new_one[id]);
	// echo "<br/>";
	// echo "0000000000000000000000000000";
	//下载相关图片，图片跟路径images,每个电影一个文件夹，文件夹名称为电影在数据库中id，图片名称为url最后一个“/”后面买的内容。
	//在images目录下创建文件，文件夹名称为 新记录的id
	$image_folder = "./images/$new_one[id]";
	mkdir($image_folder);
	// echo $url_str . "<br/>";

	$image_url_arr = split(",", $url_str);
	print_r($image_url_arr);
	echo "<br/>";
	foreach ($image_url_arr as $key => $value) {
		echo $value . "====----------=======" . "<br/>";
		// echo "<br/>";
		//获取每个图片url最后一个"/"后面的内容
		$image_name = strrchr($value, '/');
		$image_name = str_replace('/', "", $image_name);
		if ($image_name) {
			echo $image_name . '<br/>';
			//下载图片
			download_image($value, $image_folder, $image_name);
		}
	}

}
?>

