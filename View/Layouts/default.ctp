<!DOCTYPE html>
<html>
<head>
<?php echo $this->Html->charset(); ?>
<title>
  <?php echo Configure::read('site.name');?>
</title>
<?php
echo $this->Html->meta(
    'favicon.ico',
    '/favicon.ico',
    array('type' => 'icon')
);
echo $this->Html->css('conf-list');

echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');
?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-11180825-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</head>
<body>
<div id="container">
  <div id="header">
    <h1><?php echo $this->Html->link(Configure::read('site.name'),Configure::read('site.home'));?></h1>
  </div>
  <div id="sub_header">
    <div id="menu">
      <?php echo $this->Html->link('Main List',array('controller' =>
      'conferences', 'action' => 'index'))?>
      |
      <?php echo $this->Html->link('New Announcement',array('controller' =>
     'conferences', 'action' => 'add'))?>
      | 
      <?php echo $this->Html->link('About',array('controller' =>
     'conferences', 'action' => 'about'))?>

      <div id="admin_contact">
	Trouble? Comments? 
	<?php echo $this->Html->link('Contact ' . Configure::read('site.host_name'),Configure::read('site.host_contact_url'));?>
      </div>
    </div>
  </div>

  <div id="flashdiv">
    <?php echo $this->Session->flash(); ?>
  </div>

  <!-- view content -->
  <div id="content">
    <?php echo $this->fetch('content'); ?>
  </div>
  <!-- footer -->
  <div id="footer">
    <!-- footer content -->
    <div style="text-align: center">
      <?php echo $this->Html->link(str_replace('http://www.','',Configure::read('site.host')),Configure::read('site.host'));?>
    </div>
  </div>
</div>



	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
