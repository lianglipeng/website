<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
// 加载框架常量定义文件
require __DIR__ . '/../extend/statusConst.php';
// 加载系统配置文件
require __DIR__ . '/../env.php';
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
//加载扩展类文件
require __DIR__ . '/../vendor/autoload.php';