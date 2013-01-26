<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8" />

		<script language="javascript">
			// function ready() {

			function setCopy() {
				var txt = document.getElementById('content').innerHTML;
				// alert(txt);
				window.clipboardData.setData("Text", txt);
			}

			// alert(txt);
			// }
		</script>
	</head>

	<body>

		<div style="text-align:center;margin:0 auto ">

			<form action="index.php" method="post">
				电影名称:
				<input type="text" name="title" />
				<input type="submit" value="提交" />
			</form>
			<a href="index.php">返回</a>
			<input type="button" value="复制" onclick="setCopy()" />
			<br/>
			=======================================================================================================
		</div>

		<div id="content" style="margin-left: 100px">

			<!-- 		按名称搜索电影： -->
			<?php
			require_once ("./db.php");
			$title = $_POST["title"];
			$id = $_GET['id'];
			$db = new DB;
			if ($title) {
				$sql = $title ? "select * from moives where title like '%$title%' " : "";

				$records = $db -> get_all($sql);
				// print_r($records);

				foreach ($records as $key => $value) {
					// echo $value['title'];
					echo "<a href='index.php?id=$value[id]'>$value[title]</a><br/>";
					// echo $value['description'];
					//
					// $image_folder = "./images/$value[id]";
					// foreach (split(",",$value['image_url']) as $key => $value) {
					// $image_name = strrchr($value, '/');
					// $image_name = str_replace('/', "", $image_name);
					// $image_url = $image_folder . "/" . $image_name;
					//
					// echo "<image src=$image_url />";
					// }

				}
			} elseif ($id) {
				$sql = "select * from moives where id = '$id'";
				$record = $db -> get_one($sql);
				// echo $record['title'];
				
				$description = $record['description'];
				
				$description = preg_replace('/\n|\r/', '', $description);
				
				$description = preg_replace('/<a(\n|\r|.)*?<\/a>/', '', $description);
				
				// $description = preg_replace('/\"http.*?\"/', '', $description);
					
				echo $description;

				// $image_folder = "./images/$record[id]";

				//如果上线，在服务器上，则采用下面的路径
				// http://www.52xt.net/jj/zhuaqu
				$image_folder = "http://www.52xt.net/jj/zhuaqu/images/$record[id]";

				foreach (split(",",$record['image_url']) as $key => $value) {
					$image_name = strrchr($value, '/');
					$image_name = str_replace('/', "", $image_name);
					$image_url = $image_folder . "/" . $image_name;

					echo "<image src=$image_url style='border:0; margin:0; padding:0; max-width:900px; max-height:1000px;'/><br />";
				}

			} else {
				$sql = "select * from moives order by id desc limit 50 ";

				$records = $db -> get_all($sql);
				// print_r($records);

				foreach ($records as $key => $value) {
					echo "<a href='index.php?id=$value[id]'>$value[title]</a><br/>";
				}
			}
			?>
		</div>
	</body>
</html>