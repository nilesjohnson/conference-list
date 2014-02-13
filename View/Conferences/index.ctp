<!-- social networking buttons -->
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>

<?php

/*
echo $this->Js->link(array(
'https://apis.google.com/js/plusone.js', 
'http://platform.twitter.com/widgets.js', 
), false);
*/

/*
function gcal_link($start,$end,$title,$location) {
  $start_string = str_replace('-','',$start);
  $end_string = date('Ymd',strtotime($end." +1 day"));
  $url = "http://www.google.com/calendar/event?action=TEMPLATE&".
    "text=".$title."&".
    "dates=".$start_string."/".$end_string.
    "&details=".
    "&location=".$location.
    "&trp=false&sprop=http%3A%2F%2Fwww.nilesjohnson.net%2Falgtop-conf&sprop=name:AlgTop-Conf";
  return $url;
}
*/
?>


<div class="intro_text">
  <p>Welcome to the AlgTop-Conf List!  This is a home for conference
  announcements in algebraic topology and, more generally, mathematics
  meetings which may be of <em>any interest</em> to the algebraic
  topology community.</p>

  <p>There are a few other conference lists available, but this list
  aims to be more complete by allowing <em>anyone at all</em> to add
  announcements.  Rather than use a wiki, announcement information is
  stored in database format so that useful search functions can be
  added as the list grows.  Enjoy!</p>

  <p class="new">
    <span style="color:red;">Know of a meeting not listed here?</span><br />
    Go ahead and 
    <?php echo $this->Html->link('add the information', array('action' => 'add'));?>!
  </p>
</div>


<div id="sharingButtons">
  <div class="sharingButton">
    <g:plusone size="medium"></g:plusone>
  </div>
  <div class="sharingButton">
    <iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.nilesjohnson.net%2Falgtop-conf%2F&amp;send=false&amp;layout=button_count&amp;width=92&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=2em" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:92px;height:2em" allowTransparency="true"></iframe>
  </div>
  <div class="sharingButton">
    <a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a>
  </div>
  <div style="clear:both"></div>
</div>


<hr/>
<h1><?php echo $view_title; ?></h1>
<h2><?php echo __('Conferences'); ?></h2>

<div class="search_links">
  <?php echo $sort_text ?>
  <?php foreach ($search_links as $name => $array): ?>
  <?php echo $this->Html->link($name, $array)." "; ?>
  <?php endforeach; ?>

  <div style="float:right;">
    <?php echo $this->Html->link('Include Past',array('controller' =>
    'conferences', 'action' => 'index', 'all'))?>
    |
    <?php echo $this->Html->link('RSS','/conferences/index.rss');?>
  </div>
</div>




<?php $curr_subsort = Null; $new_subsort = Null; $subsort_counter = 0; echo '<div id="subsort_start">'; ?>
<?php foreach ($conferences as $conference): ?>
<?php 
if ($sort_condition == Null || $sort_condition == 'all') {
  $datearray = explode("-",$conference['Conference']['start_date']); 
  $new_subsort =  $months[(int)$datearray[1]]." ".$datearray[0]; 
 }
if ($sort_condition == 'country') {
  $new_subsort = $conference['Conference']['country'];
 }
if ($new_subsort != $curr_subsort) {
  echo '</div>';
  $curr_subsort = $new_subsort;
  echo '<div class="subsort' . $subsort_counter . '">';
  echo '<h2>' . $new_subsort . '</h2>';
  $subsort_counter += 1; 
  $subsort_counter = $subsort_counter % 2;
 }

?>

<h3 class="title">
<?php echo '<a href="'.
   $conference['Conference']['homepage'].
   '">'.
   $conference['Conference']['title'].
   '</a>'
   ;?>
</h3>
<div class="conference">

<div class="calendars">
<?php  echo
  $this->Html->link(
  $this->Html->image("gc_button6.gif",array('alt'=>'GCal', 'width'=>'90px')), 
  $this->Ical->gcal_url($conference['Conference']['id'], 
                               $conference['Conference']['start_date'], 
                               $conference['Conference']['end_date'],
                               $conference['Conference']['title'],
                               $conference['Conference']['city'],
                               $conference['Conference']['country'],
                               $conference['Conference']['homepage']
                               ),
  array('escape' => false,'id'=>'ics'));
?>
<?php  echo
  $this->Html->link(
  $this->Html->image("ics_button1.png", array('alt'=>'Ical', 'width'=>'30px')),
  array('action'=>'ical', $conference['Conference']['id']),
  array('escape' => false,'id'=>'ics'));
?>
</div>

<div class="dates">
   <?php echo $conference['Conference']['start_date']." <small>through</small> ".$conference['Conference']['end_date'];?>
</div>

<?php
      if (!empty($conference['Conference']['institution'])) {
      	 echo "<div class=\"location\">";
      	 echo $conference['Conference']['institution'];
	 echo "</div>";
      }

?>

<div class="location">
<?php 
      echo $conference['Conference']['city']."; ".$conference['Conference']['country'];
?>
</div>

<div class="action">
<a  id="description_<?php echo $conference['Conference']['id'];?>_plus" onclick="
   document.getElementById('description_<?php echo $conference['Conference']['id'];?>').style.display='block'; 
   document.getElementById('description_<?php echo $conference['Conference']['id'];?>_plus').style.display='none'; 
   document.getElementById('description_<?php echo $conference['Conference']['id'];?>_minus').style.display='inline'; 
   return false;" href="#">Description</a>
<a  id="description_<?php echo $conference['Conference']['id'];?>_minus" onclick="
   document.getElementById('description_<?php echo $conference['Conference']['id'];?>').style.display='none'; 
   document.getElementById('description_<?php echo $conference['Conference']['id'];?>_plus').style.display='inline'; 
   document.getElementById('description_<?php echo $conference['Conference']['id'];?>_minus').style.display='none'; 
   return false;" href="#" style="display:none;"> - Description</a>
 | 
<?php echo 
  $this->Html->link('View', 
  array('action'=>'view', $conference['Conference']['id']));?>
<!-- -->
 | 
<?php /**/ echo 
  $this->Html->link('Edit', 
  array('action'=>'edit', $conference['Conference']['id'], $conference['Conference']['edit_key'])); /**/?>
<!-- -->

</div>

<div class="conference_minor" id="description_<?php echo $conference['Conference']['id']?>">
<p>Meeting Type: <?php echo $conference['Conference']['meeting_type']?></p>
<p>Subject Area: <?php echo $conference['Conference']['subject_area']?></p>
<p>Contact: <?php echo 
!$conference['Conference']['contact_name'] ? 'see conference website' : $conference['Conference']['contact_name']?></p>


<h3>Description</h3>
<div class="description"><?php echo 
!$conference['Conference']['description'] ? 'none' : $conference['Conference']['description']
?></div>
</div>





</div>

<?php endforeach; ?>

</div>









