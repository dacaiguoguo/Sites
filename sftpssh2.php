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
	$sendbol = ssh2_scp_send($connection, "/Users/dacaiguo/Sites/myzipfile.zip", "/opt/web/client/debugapps/myzipfile.zip", 0777);  //上传文件
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




$path = '123.html';
$date = date('Y-m-d_H.i.s');
$path .= '/'.$date;
$filename="/Users/dacaiguo/Sites/myzipfile.zip"; //文件名
ssh2_sftp_mchkdir($sftp,$path);
$path.='/new'.$filename;




$stream = fopen("ssh2.sftp://$sftp/opt/web/client/debugapps/dev.html", 'r');
echo '<br />';
if(!$stream){
	echo 'errot stream';
} else {
	echo 'success stream';
	echo file_get_contents("ssh2.sftp://$sftp/123.html");
}
// $fileContent = ssh2_scp_recv($connection, "ssh2.sftp://$sftp/opt/web/client/debugapps/dev.html", './filename');;
$fileContent = ssh2_scp_recv($connection, "ssh2.sftp://$sftp/123.html", './filename');;

echo '<br />';
echo ssh2_sftp_realpath($sftp,".");
echo '<br />';
if(!$fileContent){
	echo 'errot $fileContent';
} else {
	echo 'success $fileContent';
}
?>