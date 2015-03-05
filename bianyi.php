<html>
	<head>
		<title>iOS应用打包</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	</head>
	<body style="text-align:center">
		<h1>请选择编译项目</h1>
		<form name="form1" method="post" action=""> 
		<?php
		$filename ='dataauto.json';
		$jsonstring = file_get_contents($filename);
		$jsondecode = json_decode($jsonstring, true);

		for ($i= 0;$i< count($jsondecode); $i++) {
			$name = $jsondecode[$i]["name"];
			echo "<label> <input type='radio' name='radio' value='$i'> ${name} </label> <br />";
		}

		if($_POST) {
			$value = $_POST['radio'];

			$name = $jsondecode[$value]["name"];
			$projectname = $jsondecode[$value]["projectname"];
			$isworkspace = $jsondecode[$value]["isworkspace"];
			$foldername = $jsondecode[$value]["foldername"];
			$buildconfig = $jsondecode[$value]["buildconfig"];

			echo '<br />即将编译:',$name; 
			echo '<br />编译完成自动跳转至下载页面<br /><br /><br />';

			$cmd = "./buildtool.sh $projectname $isworkspace $foldername $buildconfig";
			$url = system($cmd);
			echo "<script language=\"javascript\">";
			echo "location.href=\"$url\"";
			echo "</script>";
		}
		?>
		<br />
		<input type="submit" name="Submit" value="提交" />
	</form> 
	</body>
</html>