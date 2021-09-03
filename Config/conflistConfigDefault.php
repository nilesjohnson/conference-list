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
      'encoding' => 'utf8',
    ),
  ),
  'site' => array(
    'host' => 'http://www.example.com',
    'host_email' => 'host@example.com',
    'host_name' => 'Host',
    'host_contact_url' => 'http://www.example.com/contact.html',
    'home' => 'http://www.example.com/conf-list',
    'admin_email' => array('site' => array('nilesj+CONFLISTTEST@gmail.com'),
                           'all' => array('nilesj+CONFLISTTEST@gmail.com',
                           'at' => array('conflist-admin-at@example.com',),
                           'gt' => array('conflist-admin-gt@example.com',),
                           'ag' => array('conflist-admin-ag@example.com',
                                         'ag2@example.com'),
                           'nt' => array('conflist-admin-nt@example.com',),
                           'ap' => array('conflist-admin-ap@example.com',
                                         'ap2@example.com'),
                           ),
    'admin_key' => '146c07ef2479cedcd54c7c2af5cf3a80', // curator login
    'curator_cookie' => 'd394815482bc9c54be38168cfa67e04f', // cookie value
    'name' => 'ConfList',
    'analytics' => "
<script type=\"text/javascript\">
//tracking code
</script>
",
  ),
  'smtp' => array(
    'gmail' => array(
      'from' => 'example@address.org',
      'transport' => 'Smtp',
      'host' => 'smtp.gmail.com',
      'port' => 587, // or 465
      'username' => 'example@address.org', 
      'password' => '***',
      'client' => null,
      'log' => true,
      'tls' => true,
    ),
  ),
);


Configure::write('debug', 2);
Configure::write('Security.salt', '0123456789abcdef0123456789abcdef');
Configure::write('Security.cipherSeed', '987654321');

// Recaptcha keys
Configure::write('Recaptcha.publicKey', 'your-public-api-key');
Configure::write('Recaptcha.privateKey', 'your-private-api-key');


?>
