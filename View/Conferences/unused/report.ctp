<!-- File: /app/views/conferences/view.ctp -->

<h1>Report Problem:</h1>
<h2 class="title">
<?php echo '<a href="'.
   $conference['Conference']['homepage'].
   '">'.
   $conference['Conference']['title'].
   '</a>'
   ;?>
</h2>

<div class="conference">

<div class="dates">
   <?php echo $conference['Conference']['start_date']." <small>through</small> ".$conference['Conference']['end_date']; ?>
</div>

<?php
      if (!empty($conference['Conference']['institution'])) {
      	 echo "<div class=\"location\">";
      	 echo $conference['Conference']['institution'];
	 echo "</div>";
      }

?>

<div class="location">
<?php echo $conference['Conference']['city']."; ".$conference['Conference']['country'];?>
</div>


<!--<p>duration: <?php echo $conference['Conference']['duration']?></p>-->

<div class="conference_minor">
<p>Click title to visit website.</p>
<p>Meeting Type: <?php echo $conference['Conference']['meeting_type']?></p>
<p>Subject Area: <?php echo $conference['Conference']['subject_area']?></p>
<p>Contact: <?php echo $conference['Conference']['contact_name']?></p>
</div>

<h2>Description</h2>
<p class="description"><?php echo 
!$conference['Conference']['description'] ? 'none' : $conference['Conference']['description']
?></p>

<div class="flash flash_bad" style="margin-top: 2em;">
Please submit a brief description of the problem using the box below.
</div>

<?php
echo $this->Form->create('Conference', array('action' => 'report'));
echo $this->Form->input('id', array('type'=>'hidden')); 
echo $this->Form->input('edit_key', array('type'=>'hidden')); 
echo $this->Form->input('report_comment', array('type'=>'text_area', 'label' => 'Note'));
echo $this->Form->input('captcha', array('label' => 'Please Enter the Sum of ' . $mathCaptcha, 'after'=> '(anti-spam)'));
echo $this->Form->end('Report Problem');
?>




