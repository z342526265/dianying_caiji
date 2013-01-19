<?php
function download_image($url, $folder, $pic_name) {
	// echo $url . "<br/>";
	// echo $folder . "<br/>";
	// echo $pic_name . "<br/>";
	
	set_time_limit(24 * 60 * 60);
	//限制最大的执行时间
	$destination_folder = $folder ? $folder . '/' : '';
	//文件下载保存目录
	$newfname = $destination_folder . $pic_name;
	//文件PATH
	$file = fopen($url, 'rb');
	// echo $file . "<br/>";
	if ($file) {
		$newf = fopen($newfname, 'wb');
		// echo $newf;
		// echo "<br/>";
		if ($newf) {
			while (!feof($file)) {
				fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
			}
		}
		if ($file) {
			fclose($file);
		}
		if ($newf) {
			fclose($newf);
		}
	}
}
?>