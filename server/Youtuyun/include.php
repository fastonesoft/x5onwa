<?php

// >= php 5.3.0
// Youtuyun
spl_autoload_register(function($class){
    // 类的名称为全名：Youtuyun\Conf
    // 所以不能在当前目录，而要退回到上层目录
    $dir = dirname(dirname(__FILE__));
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

    include($dir.DIRECTORY_SEPARATOR.$class); 
});