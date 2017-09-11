<?php
 return array(
   'TMPL_L_DELIM'=>'{jasxun',
    'TMPL_R_DELIM'=>'}',
    'URL_MODEL'       =>  2, // 如果你的环境不支持PATHINFO 请设置为 3
     /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__CSS__'    => __ROOT__ . '/Public/' . GROUP_NAME . '/',
        '__JS__'     => __ROOT__ . '/Public/' . GROUP_NAME . '/',
        '__IMG__'     => __ROOT__ . '/Public/' . GROUP_NAME . '/',
     ),
 );