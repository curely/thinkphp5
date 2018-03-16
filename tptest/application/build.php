<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    // 生成应用公共文件
    '__file__' => ['common.php', 'config.php', 'database.php'],

    // 定义demo模块的自动生成 （按照实际定义的文件名生成）
    // 'demo'     => [
    //     '__file__'   => ['common.php'],
    //     '__dir__'    => ['behavior', 'controller', 'model', 'view'],
    //     'controller' => ['Index', 'Test', 'UserType'],
    //     'model'      => ['User', 'UserType'],
    //     'view'       => ['index/index'],
    // ],
    // 其他更多的模块定义
    'common' => [
        '__dir__'       => ['model'],
        'model'         => ['Category','Admin','Bis','Bislocation','Bisaccount','Base'],
    ],
    'admin' => [
        '__dir__'       => ['controller','validate','view'],
        'controller'    => ['Index','Category','Bis'],
        'validate'      => ['Category','Bis'],
        'view'          => ['index/index','index/welcome','bis/apply','bis/index','bis/detail','bis/del','category/index','category/edit','public/header','public/_header','public/left','public/footer'],
    ],
    'api' => [
        '__dir__'       => ['controller','view'],
        'controller'    => ['Index','City','Category','Image'],
    ], 
    'bis' => [
        '__dir__'       => ['controller','validate','view'],
        'controller'    => ['Register','Login','Base'],
        'view'          => ['register/index','register/waiting','login/index','public/header','public/footer','index/index'],
        'validate'      => ['Bis','Bislocation','Bisaccount'],
    ]
];
