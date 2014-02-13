<?php

$config = array(
  'database' => array(
    'test' => array(
      'datasource' => 'Database/Mysql',
      'persistent' => false,
      'host' => 'localhost',
      'login' => 'root',
      'password' => '',
      'database' => 'conflist_test',
    ),
    'default' => array(
      'datasource' => 'Database/Mysql',
      'persistent' => false,
      'host' => 'localhost',
      'login' => 'root',
      'password' => '',
      'database' => 'conflist',
    ),
  ),
  'site' => array(
    'host' => 'http://www.example.com',
    'host_email' => 'host@example.com',
    'home' => 'http://www.example.com/conf-list',
    'admin_email' => 'conflist-admin@example.com',
  ),
);


Configure::write('debug', 2);
Configure::write('Security.salt', 'qwewrtyuiop123');
Configure::write('Security.cipherSeed', '987654321')

?>