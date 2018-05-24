<?php
if ($readCookie == Configure::read('site.admin_cookie')) {
  echo "<h2>Admin cookie is set!</h2>";
}
else {
  echo "<h2>Enter admin key to set cookie.</h2>";
}

echo $this->Form->create('Admin');
echo $this->Form->input('admin_key', array('label' => 'Admin Key'));
echo $this->Form->end('Submit');



?>


