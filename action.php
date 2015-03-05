<html>
 <head>
  <title>PHP 测试</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
 </head>
 <body>

你好，<?php echo htmlspecialchars($_POST['name']); ?>。
你 <?php echo (int)$_POST['age']; ?> 岁了。

 </body>
</html>