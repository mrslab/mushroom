<?php

$cfg = array();
//输出编码
$cfg['base']['charset'] = 'utf-8';
//时区
$cfg['base']['timezone'] = 8;
//默认控制器名称
$cfg['base']['controller'] = 'index';
//默认控制方法名
$cfg['base']['method'] = 'index';
//模板目录
$cfg['base']['theme'] = 'default';
//解析路由方式
$cfg['param']['test'] = 1;

$cfg['hook'] = array(
    array('output', array('className', 'method')),
);

$cfg['comp']['session'] = array(
    'name' => 'Session',
    'config' => array(
        'driver' => 'Memcache',
        'connect' => '127.0.0.1:11211:12',
    ),

);
$cfg['comp']['mc1'] = array(
    'name' => 'Memcache',
    'config' => '127.0.0.1:11211:1',
);
$cfg['comp']['redis'] = array(
    'name' => 'Redis',
    'config' => '127.0.0.1:6379:1:fasdfasdf$sfasdf:0',
);
$cfg['comp']['db'] = array(
    'name' => 'Mysql',
    'config' => array(
        'dsn' => 'mysql:host=localhost;dbname=test;charset=utf8',
        'user' => 'root',
        'pass' => 'root',
        'time' => 3,
        'tablepre' => 'mr_'
    ),
);

return $cfg;
