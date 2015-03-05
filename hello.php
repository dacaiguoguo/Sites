<html>
 <head>
  <title>PHP 测试</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
 </head>
 <body>
<?php
class MyClass {
    const CONST_VALUE = 'A constant value';
}

class OtherClass extends MyClass
{
    public static $my_static = 'static var';

    public static function doubleColon() {
        echo parent::CONST_VALUE . "\n";
        echo self::$my_static . "\n";
    }
}

$classname = 'OtherClass';
echo $classname::doubleColon(); // 自 PHP 5.3.0 起

OtherClass::doubleColon();
?>
</body>
</html>