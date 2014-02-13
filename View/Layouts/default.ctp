<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<title>AlgTop-Conf</title>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('conf-list');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
<div id="container">
  <div id="header">
    <h1><a href="http://mathmeetings.net">AlgTop-Conf 2</a>: Conf-List</h1>
  </div>
  <div id="sub_header">
    <div id="menu">
      <?php echo $this->Html->link('Main List',array('controller' =>
      'conferences', 'action' => 'index'))?>
      |
      <?php echo $this->Html->link('Add Announcement',array('controller' =>
     'conferences', 'action' => 'add'))?>
      | 
      <?php echo $this->Html->link('About',array('controller' =>
     'conferences', 'action' => 'about'))?>

      <div id="admin_contact">
	Trouble? Comments? <a href="http://www.nilesjohnson.net/contact.html">Contact Niles</a>
      </div>
    </div>
  </div>

  <div id="flashdiv">
    <div class="flash flash_good">Note: this is the NEW app for cake 2 and php 5.4.  It is still in the final stages of development.</div>
    <?php echo $this->Session->flash(); ?>
  </div>

  <!-- view content -->
  <div id="content">
    <?php echo $this->fetch('content'); ?>
  </div>
  <!-- footer -->
  <div id="footer">
    <!-- footer content -->
    <div style="text-align: center"><a href="http://www.nilesjohnson.net">nilesjohnson.net</a></div>
  </div>
</div>



	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
