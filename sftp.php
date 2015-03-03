<!--?php  
 
 
/**
php 中的sftp 使用教程 
Telnet、FTP、SSH、SFTP、SSL  
(一) ftp 协议简介 
 
    FTP(File Transfer Protocol,文件传输协议)是互联网上常用的协议之一，人们用FTP实现互连网上的文件传输。
如同其他的很多通讯协议，FTP通讯协议也采用客户机 / 服务器（Client / Server ）架构。用户可以通过各种不同的FTP客户端程序，
借助FTP协议，来连接FTP服务器，以上传或者下载文件FTP的命令传输和数据传输是通过不同的端口进行传输的
FTP是TCP/IP的一种具体应用，它工作在OSI模型的第七层，TCP模型的第四层上，即应用层，使用TCP传输而不是UDP，
这样FTP客户在和服 务器建立连接前就要经过一个被广为熟知的三次握手的过程，它带来的意义在于客户与服务器之间的连接是可靠的，
而且是面向连接，为数据的传输提供了可靠 的保证。
 
(二)ssh协议 
 
    ssh 的全称为 SecureShell   ,可以报所有的传输数据惊醒加密,这样'中间人'就不能获得我们传输的数据
同事,传输的数据是经过压缩的,可以加快传输的速度.ssh有很多功能,可以替代telnet 也可也为ftppop ,提供一个安全的通道 
 
   SSH协议框架中最主要的部分是三个协议：
  
* 传输层协议（The Transport Layer Protocol）提供服务器认证，数据机密性，信息完整性 等的支持；
* 用户认证协议（The User Authentication Protocol） 则为服务器提供客户端的身份鉴别；
* 连接协议（The Connection Protocol） 将加密的信息隧道复用成若干个逻辑通道，提供给更高层的应用协议使用； 
  各种高层应用协议可以相对地独立于SSH基本体系之外，并依靠这个基本框架，通过连接协议使用SSH的安全机制。
   
 (三)sftp 协议 
    使用SSH协议进行FTP传输的协议叫SFTP（安全文件传输）Sftp和Ftp都是文件传输协议。区别：sftp是ssh内含的协议（ssh是加密的telnet协议），
    只要sshd服务器启动了，它就可用，而且sftp安全性较高，它本身不需要ftp服务器启动。 sftp = ssh + ftp（安全文件传输协议）。由于ftp是明文传输的，
    没有安全性，而sftp基于ssh，传输内容是加密过的，较为安全。目前网络不太安全，以前用telnet的都改用ssh2(SSH1已被破解)。sftp这个工具和ftp用
    法一样。但是它的传输文件是通过ssl加密了的，即使被截获了也无法破解。而且sftp相比ftp功能要多一些，多了一些文件属性的设置
 
     
    */
     
 
 
         
// 注意这里只是为了介绍ftp ,并没有做验证 ;      
class ftp{
     
    // 初始配置为NULL
    private  $config =NULL ;
    // 连接为NULL 
    private  $conn = NULL;
     
    public function init($config){
      $this--->config = $config;    
    }
     
    // ftp 连接 
    public function connect(){
        return  $this->conn = ftp_connect($this->config['host'],$this->config['port'])); 
    }
     
     
    // 传输数据  传输层协议,获得数据 true or false 
   public function download($remote, $local,$mode = 'auto'){
       return $result = @ftp_get($this->conn, $localpath, $remotepath, $mode);
   }
    
   // 传输数据  传输层协议,上传数据 true or false 
   public function upload($remote, $local,$mode = 'auto'){
       return $result = @ftp_put($this->conn, $localpath, $remotepath, $mode);
   }
    
    
      // 删除文件  
    public function remove($remote){
      return  $result = @ftp_delete($this->conn_id, $file);
    }
    
     
}       
 
 
 
// 使用 
$config = array(
            'hostname' => 'localhost',
            'username' => 'root',
            'password' => 'root',
            'port' => 21
 
) ;
  
$ftp = new Ftp();
$ftp->connect($config);
$ftp->upload('ftp_err.log','ftp_upload.log');
$ftp->download('ftp_upload.log','ftp_download.log');
 
 
 
/*根据上面的三个协议写出基于ssh 的ftp 类
我们知道进行身份认证的方式有两种：公钥；密码 ;
(1) 使用密码登陆
(2) 免密码登陆也就是使用公钥登陆 
 
*/
 
class sftp{
     
     
    // 初始配置为NULL
    private  $config =NULL ;
    // 连接为NULL 
    private  $conn = NULL;
 
     
    // 是否使用秘钥登陆 
     private $use_pubkey_file= false;
     
    // 初始化
    public function init($config){
        $this->config = $config ; 
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
                $this->config['passphrase']) 
            );
        //(2) 使用登陆用户名字和登陆密码
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
       
      // 删除文件  
        public function remove($remote){
            $sftp = ssh2_sftp($this->conn_);
            $rc   = false;
 
        if (is_dir(ssh2.sftp://{$sftp}/{$remote})) {
            $rc = false ;
             
            // ssh 删除文件夹
            $rc = ssh2_sftp_rmdir($sftp, $remote);
            } else {
            // 删除文件
                $rc = ssh2_sftp_unlink($sftp, $remote);
            }
            return $rc;
             
        }
           
   
  
     
}
 
 
$config  = [
    host          => 192.168.1.1 ,      //  ftp地址
    user          => ***, 
    port          => 22,
    pubkey_path  => /root/.ssh/id_rsa.pub,   // 公钥的存储地址
    privkey_path => /root/.ssh/id_rsa,          // 私钥的存储地址
];
 
$handle = new SftpAccess();
$handle->init($config);
$rc = $handle->connect();
$handle->getData(remote, $local);
         
 
         
/*      