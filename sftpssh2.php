<html>
	<head>
		<title>iOS应用打包</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	</head>
	<body style="text-align:center">
	<?php
	echo '<br />';	
	echo  "kaishi target....ooooo" ;
	echo '<br />';	
	
	?>

<?php

	echo  "kaishi target...." ;
	$cmd = "./buildipa.sh";
	$url = system($cmd);
	if($url != 1){
		echo '<br />';
		echo "not return 1";
		echo '<br />';	
	} else {
		echo " return 1";
		echo '<br />';	
	}

	$connection = ssh2_connect('192.168.0.96', 22);
	if(!$connection){
		echo 'errot';
	} else {
		echo 'success';
	}
	echo '<br />';
	if(!ssh2_auth_password($connection, 'root', 'admin508956')){
		echo "can not ssh2_auth_password";
	}

	$sftp = ssh2_sftp($connection);
	if(!$sftp){
		echo 'errot sftp';
	} else {
		echo 'success 22sftp';
		echo '<br />';
		$sendbol = ssh2_scp_send($connection, "/Users/dacaiguo/Documents/workplace/lvmama630/Lvmm.ipa", "/opt/web/client/debugapps/iphone/640/debug/Lvmm.ipa");  //上传文件
		if($sendbol ){
			ECHO  'yeyyyyy';
		} else {
			ECHO  'noooooo';
		}
	
		$recvFileBool = ssh2_scp_recv($connection, "/opt/web/client/debugapps/myzipfile.zip", "/Users/dacaiguo/Sites/myzipfilerevvvv.zip");
		// bool ssh2_scp_recv ( resource $session , string $remote_file , string $local_file )
	
		if($recvFileBool ){
			ECHO  '$recvFileBool yeyyyyy';
		} else {
			ECHO  '$recvFileBool noooooo';
		}
	
	}
?>
	</body>

</html>