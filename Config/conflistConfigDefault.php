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
    'host_name' => 'Host',
    'host_contact_url' => 'http://www.example.com/contact.html',
    'home' => 'http://www.example.com/conf-list',
    'admin_email' => array('conflist-admin1@example.com','conflist-admin2@example.com'),
    'admin_key' => '146c07ef2479cedcd54c7c2af5cf3a80',
    'name' => 'ConfList',
    'analytics' => "
<script type=\"text/javascript\">
//tracking code
</script>
",
  ),
);


Configure::write('debug', 2);
Configure::write('Security.salt', 'qwewrtyuiop123');
Configure::write('Security.cipherSeed', '987654321')

?>
