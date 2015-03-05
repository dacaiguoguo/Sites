<html>
	<head>
		<title>iOS应用打包</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	</head>
	<body style="text-align:center">
		<p> start </p>
		<form name="form1" method="post" action=""> 
		<?php

			$filename ='data.json';
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

				$cmd = "./buildipa.sh $projectname $isworkspace $foldername $buildconfig";
				$url = system($cmd);
				echo "<script language=\"javascript\">";
				echo "location.href=\"http://localhost/~dacaiguo/buttons.html\"";
				echo "</script>";
				// var_dump($url);
				// echo "<script language=\"javascript\">";
				// echo "location.href=\"$url\"";
				// echo "</script>";
				// $connection = ssh2_connect('192.168.0.96', 22);// 先建立连接
				// if(!$connection){
				// 	echo 'connection errot'."<br />";;
				// } else {
				// 	echo 'connection success'."<br />";
				// }
				// if(!ssh2_auth_password($connection, 'root', 'admin508956')){
				// 	echo "can not ssh2_auth_password";
				// }
				//
				// $sftp = ssh2_sftp($connection);
				// if ($sftp){
				// 	$realpath = ssh2_sftp_realpath($sftp,'../opt/web/client/debugapps/iphone/640/debug/Lvmm.ipa');
				// 	if ($realpath){
				// 		echo "realpath:$realpath"."<br />";;
				// 		// $sendbol = ssh2_scp_send($connection, "/Users/dacaiguo/Documents/workplace/lvmama630/Lvmm.ipa", $realpath);  //上传文件
				//
				// 	} else {
				// 		echo 'error real path'."<br />";;
				// 	}
				// } else {
				// 	echo 'error $sftp '."<br />";;
				// }
			}


		?>
		<br />
		<input type="submit" name="Submit" value="提交" />
	</body>
</html>