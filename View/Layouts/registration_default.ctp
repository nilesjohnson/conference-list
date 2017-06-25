<!DOCTYPE html>
<html>
<head>
<?php echo $this->Html->charset(); ?>
<title>
  <?php echo $conference['Conference']['title'];?>
</title>
<?php
echo $this->Html->meta(
    'favicon.ico',
    '/favicon.ico',
    array('type' => 'icon')) ."\n";

echo $this->Html->css('simple-conference') ."\n";


echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');

echo Configure::read('site.analytics');
?>

</head>
<body>
<div id="container">
  <div id="flashdiv">
    <?php echo $this->Session->flash(); ?>
  </div>

  <div id="header">
    <h1><?php echo $conference['Conference']['title'];?></h1>
  <div id="sub_header">
    <div id="menu">
      <?php echo $this->Html->link('Info',array('controller' =>
      'conferences', 'action' => 'view', $conference['Conference']['id']))?>
      |
      <?php echo $this->Html->link('Current Registrants',array('controller' =>
     'registrants', 'action' => 'all', $conference['Conference']['id']))?>
      | 
      &nbsp;&nbsp;
      <?php if (empty($noRegButton)) {echo $this->Html->link('Register&nbsp;Now!', 
array('action' => 'add', $conference['Conference']['id']), array('class' => 
'button', 'id' => 'add-button', 
'escape' => false));}?>
    </div>
  </div>
  </div>

  <!-- view content -->
  <div id="content">
    <?php echo $this->fetch('content'); ?>
  </div>

  <!-- footer -->
  <div id="footer">
    <!-- footer content -->
    <div style="text-align: center;">
      <?php echo 
$this->Html->link(str_replace('http://','',Configure::read('site.host')),Configure::read('site.host'), 
array('target' => 'hosthome'));?>
      |
      <?php echo $this->Html->link('simple-conference web 
app','http://github.com/nilesjohnson/simple-conference',array('target' => 
'github')); ?>
    </div>
</div>



<?php echo $this->element('sql_dump'); ?>
</body>
</html>
