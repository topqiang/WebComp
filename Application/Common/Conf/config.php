<?php
return array(
	//'配置项'=>'配置值'
	'DB_TYPE'               =>  'mysqli',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'comp',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '123456',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'top_',    // 数据库表前缀
    'MODULE_ALLOW_LIST'      =>  array('Home','Admin'),
    'TMPL_PARSE_STRING' => array(
		'__STATIC__' => __ROOT__ . '/Public/Static',
		'__PLUGINS__' => __ROOT__ . '/Public/Plugins',
		'__IMG__'    => __ROOT__ . '/Public/img',
		'__CSS__'    => __ROOT__ . '/Public/css',
		'__JS__'     => __ROOT__ . '/Public/js',
	),);