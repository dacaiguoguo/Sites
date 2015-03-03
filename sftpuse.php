

<?php  
 
$config = array(
	'192.168.0.96',
	'root',
	'admin508956',
	22
) ;
class SftpAccess{
     
     
    // 初始配置为NULL
    private  $config =NULL ;
    // 连接为NULL 
    private  $conn = NULL;
 
     
    // 是否使用秘钥登陆 
    private $use_pubkey_file= false;
     
    // 初始化
    public function init($config){
		echo "config";
        $this->config = $config ; 
		if($config){
			echo $config['user'];
			
			
		} else {
			echo 'error';
		}
    }
     
     
    // 连接ssh ,连接有两种方式(1) 使用密码
    // (2)  使用秘钥 
    public function connect(){
         
        $methods['hostkey'] =  $use_pubkey_file ?  'ssh-rsa'  : [] ; 
        $con = ssh2_connect($this->config['host'], $this->config['port'], $methods);
        //(1) 使用秘钥的时候 
        if($use_pubkey_file){
        //  用户认证协议
             $rc = ssh2_auth_pubkey_file(
                $conn,
                $this->config['user'],
                $this->config['pubkey_file'],
                $this->config['privkey_file'],
                $this->config['passphrase']
			);
        }else{
            $rc = ssh2_auth_password( $conn, $this->conf_['user'],$this->conf_['passwd']);
             
        }
         
        return $rc ;  
    }
     
     
    // 传输数据  传输层协议,获得数据
       public function download($remote, $local){
            
            return ssh2_scp_recv($this->conn_, $remote, $local);
       }
        
      //传输数据  传输层协议,写入ftp服务器数据
      public function upload($remote, $local,$file_mode=0664){
           return ssh2_scp_send($this->conn_, $local, $remote, $file_mode);
             
      }
}

// $config  = [
//     "192.168.0.96",
//     "***",
// 	"22",
//     "/root/.ssh/id_rsa.pub",
// 	"/root/.ssh/id_rsa"
// ];
echo "hello world!";
$handle = new SftpAccess();
echo "hello me!";
$handle->init($config);
$rc = $handle->connect();
echo $handle->getData("/opt/web/client/debugapps/dev.html", "./");

?>