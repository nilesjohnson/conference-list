<h1>Set curator cookie</h1>

<p>This fom lets you set a browser cookie so that your browser is recognized as a site curator.  With this cookie set, you will not need to complete the captcha task when adding new announcements.</p>

<p>To set the cookie, enter the site admin key in the box below.  If you have lost the key, contact Niles.</p>


<?php
//debug($readCookie);
if ($readCookie == Configure::read('site.curator_cookie')) {
  echo "<h2>Curator cookie is set!</h2>";
}
else {
  echo "<h2>Enter admin key to set cookie.</h2>";
}

echo $this->Form->create('Admin');
echo $this->Form->input('admin_key', array('label' => 'Admin Key'));
echo $this->Form->end('Submit');



?>


