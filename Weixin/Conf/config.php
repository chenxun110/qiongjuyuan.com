<?php
return array(
    'URL_MODEL'            =>  2, // 如果你的环境不支持PATHINFO 请设置为 3
    'APP_GROUP_LIST'       => 'Wap,User,Home',
    'DEFAULT_GROUP'        => 'Home',
    //开启独立分组
    'APP_GROUP_MODE'       => 1,
    'APP_GROUP_PATH'       => 'App',
    //伪静态后缀名
    'URL_HTML_SUFFIX'      => '',
     //URL大小写
    'URL_CASE_INSENSITIVE' => TRUE,
    //是否开启session
    'SESSION_AUTO_START'   => TRUE, 
    'APP_AUTOLOAD_PATH'    => '@.ORG',
    //微信和域名配置
    'SITE_URL'             => 'http://qiongjuyuan.com',//域名
    'AppID'                => 'wx5a97f05af959b0b1',//公众号appid
    'EncodingAESKey'       => 'ZW2vUzAsWEItSAg3UwEypOL7H9jiuQl6ELwQh2rI2nK',//消息加解密密钥
    'TOKEN'                => 'qiongjuyuan',//微信接入token值
     //数据库配置信息
    'DB_TYPE'              => 'mysql', // 数据库类型
    'DB_HOST'              => 'localhost', // 服务器地址
    'DB_NAME'              => 'qiongjuyuan.com', // 数据库名
    'DB_USER'              => 'root', // 用户名
    'DB_PWD'               => '123456', // 密码
    'DB_PORT'              => 3306, // 端口
    'DB_PREFIX'            => 'wx_', // 数据库表前缀
);
?>