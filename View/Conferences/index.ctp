<!-- social networking buttons -->
<!-- currently disabled
<div class="share-links">
  <div class="g-plusone" data-href="<? echo Configure::read('site.home'); ?>"></div>
  <div style="display: inline-block;"><a href="https://twitter.com/share" class="twitter-share-button" 
    data-text="check out <? echo Configure::read('site.name'); ?>"
    data-hashtags="MathConferences" 
    data-url="<? echo Configure::read('site.home');?>">Tweet</a></div>
</div>
-->

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

<div id="search_links">

<!--
<?php
  echo $this->Form->create('Conference');
  //the multi-select happens magically because of the HABTM and the variable $tags
  echo $this->Form->input('Tag',array('label'=>'Filter by arxiv subject tags','value'=>$tagids));
  //disables the SecurityComponent
  $this->Form->unlockField('Tag');

  echo "<div><p>Click or type to select tags. Last tag search is saved in a cookie.</p><p>";
  echo "</p></div>";

  echo $this->Form->submit(__('Apply subject filter', true), array('div' => false));
  echo "<br/>\n";
  echo "<p style='margin-top:10px;'>".$this->Html->link('Delete subject filter', array('controller' => 'conferences', 'action'=>'index', '?'=>array('t0' => '')), array('class' => 'ics button'))."</p>\n";
  echo $this->Form->end();
?>
-->
</div>

<div style="float:right; padding-left:.5ex; border-left: 1px solid #777; margin-left:.5ex;">
<h2 style="margin: 0 0 1ex 0;">Choose a sublist of interest.</h2>
<dl style="width:40ex;">
<style>
dd {
  margin: 0 0 0 1ex;
}
</style>
<dt><a href="/at-gt">Algebraic Topology</a></dt>
<dd><span class="tag">at.algebraic-topology</span> 
<span class="tag">gt.geometric-topology</span></dd>
<dt><a href="/ag-nt">Arithmetic Geometry</a></dt>
<dd><span class="tag">algebraic-geometry</span>
<span class="tag">nt.number-theory</span></dd>
<dt><a href="/ac-ag">Commutative Algebra</a></dt>
<dd><span class="tag">ac.commutative-algebra</span>
<span class="tag">ag.algebraic-geometry</span></dd>
<dt><a href="/t0">All</a></dt>
<dd><span style="font-size:80%;">Delete the sublist cookie and view all announcements.</span></dd>
</dl>
<!--
<ul>
<?php foreach ($tags as $id => $tag): 
$t = substr($tag,0,2)?>
<li><a href="/<?php echo $t;?>"><?php echo $tag;?></a></li>
<?php endforeach;?>
</ul>
-->
</div>


<div class="intro_text">

  <p>Welcome to the MathMeetings.net list!  This is based
  on the conference list software developed for conferences in
  algebraic topology: <a href="http://nilesjohnson.net/algtop-conf"
  target="blank">AlgTop-Conf</a>.</p>

  <p><em style="font-size:110%; background-color:#feb">This is a demo, under development.</em></p>

  <p>There are a few other conference lists available, but this list
  aims to be more complete by allowing <em>anyone at all</em> to add
  announcements.  Rather than use a wiki, announcement information is
  stored in database format so that useful search functions can be
  added as the list grows.</p>

  <h4>Updates (sketch)</h4>
  <ul>
    <li>Now filter announcements by subject tags</li>
    <li>Form for editing announcements is now the same as that for adding new announcements</li>
    <li>New 'view' page for each announcement, and announcement data in confirmation emails</li>
    <li>Select boxes improved with select2 (jquery)</li>    
  </ul>	  

<!--
  <h4>Updates 2014-02-16</h4>

  <p>We've upgraded the AlgTop-Conf software to <a
  href="http://cakephp.org/" target="cake-blank">CakePHP 2.4.5</a> and
  <a href="http://www.php.net" target="php-blank">PHP 5.4</a>.  This involves
  substantial changes behind the scenes, but (hopefully!) minimal
  changes to the user interface.  If you notice something not working
  properly, please let Niles know.</p>
-->

  <p>Additional update notes are available in the <a href="https://github.com/nilesjohnson/conference-list" target="github">git repository</a> (GitHub).</p>

  <div class="new">
    <h2>Know of a meeting not listed here?  Add it now!</h2>
    <p>
    <?php echo $this->Html->link('New Announcement', array('action' => 'add'), array('class' => 'button', 'id' => 'add-button'));?>
    </p>
  </div>
</div>



<hr class="top"/>
<h1><?php echo $view_title; ?></h1>

<div>
<!--
  <?php echo $sort_text ?>
  <?php foreach ($search_links as $name => $array): ?>
  <?php echo $this->Html->link($name, $array)." "; ?>
  <?php endforeach; ?>
-->
  &nbsp;
  <div style="float:right;">
<!--
    <?php echo $this->Html->link('Include Past',$past_link)?>
    |
-->
    <?php echo $this->Html->link('RSS','/conferences/index.rss');?>
  </div>
</div>



<?php 

//just added this to show basic Paginator function
/*
echo '<div>';

//notice clicking this will change from ASC to DESC it also changes the class name so you can draw a little arrow. Check out the default CakePHP CSS you'll see it
echo $this->Paginator->sort('country').'<br/>';


	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	)).'<br />';

		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));


echo '</div>';
*/

//

?>


<?php $curr_subsort = Null; $new_subsort = Null; $subsort_counter = 0; echo '<div id="subsort_start">'; ?>
<?php 
$site_url = Configure::read('site.home');
$site_name = Configure::read('site.name');

//debug($conferences);
//debug($conferencesTags);
foreach ($conferences as $conference):
if ($sort_condition == Null || $sort_condition == 'all') {
  $datearray = explode("-",$conference['start_date']); 
  $new_subsort =  $months[(int)$datearray[1]]." ".$datearray[0]; 
 }
if ($sort_condition == 'country') {
  $new_subsort = $conference['country'];
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
   $conference['homepage'].
   '">'.
   $conference['title'].
   '</a>'
   ;?>
</h3>
<div class="conference">

<div class="subject-tags">
<?php
  //debug($conference);
  foreach($conferencesTags[$conference['id']] as $tag) {
    echo '<span class="tag">'.$tag['name']."</span>\n";
  }
?>
</div>

<div class="calendars">
<?php  echo
  $this->Html->link('Google calendar',
  $this->Gcal->gcal_url($conference['id'], 
                               $conference['start_date'], 
                               $conference['end_date'],
                               $conference['title'],
                               $conference['city'],
                               $conference['country'],
                               $conference['homepage'],
			       $site_url,
			       $site_name
                               ),
  array('escape' => false,'class'=>'ics button'));

echo
  $this->Html->link('iCalendar .ics',
  array('action'=>'ical', $conference['id']),
  array('escape' => false,'class'=>'ics button'));
?>
</div>

<div class="dates">
   <?php echo $conference['start_date']." <small>through</small> ".$conference['end_date'];?>
</div>

<?php
      if (!empty($conference['institution'])) {
      	 echo "<div class=\"location\">";
      	 echo $conference['institution'];
	 echo "</div>";
      }

?>

<div class="location">
<?php 
      echo $conference['city']."; ".$conference['country'];
?>
</div>

<div class="action">
<a  id="description_<?php echo $conference['id'];?>_plus" onclick="
   document.getElementById('description_<?php echo $conference['id'];?>').style.display='block'; 
   document.getElementById('description_<?php echo $conference['id'];?>_plus').style.display='none'; 
   document.getElementById('description_<?php echo $conference['id'];?>_minus').style.display='inline'; 
   return false;" href="#">Description</a>
<a  id="description_<?php echo $conference['id'];?>_minus" onclick="
   document.getElementById('description_<?php echo $conference['id'];?>').style.display='none'; 
   document.getElementById('description_<?php echo $conference['id'];?>_plus').style.display='inline'; 
   document.getElementById('description_<?php echo $conference['id'];?>_minus').style.display='none'; 
   return false;" href="#" style="display:none;"> - Description</a>
 | 
<?php echo 
  $this->Html->link('View entry', 
  array('action'=>'view', $conference['id']));?>
<!--
 | 
<?php /* echo 
  $this->Html->link('Edit', 
  array('action'=>'edit', $conference['id'], $conference['edit_key'])); /**/?>
-->

</div>

<div class="conference_minor" id="description_<?php echo $conference['id']?>">
<p>Meeting Type: <?php echo $conference['meeting_type']?></p>
<p>Subject Area: <?php echo $conference['subject_area']?></p>
<p>Contact: <?php echo 
!$conference['contact_name'] ? 'see conference website' : $conference['contact_name']?></p>


<h3>Description</h3>
<div class="description"><?php echo 
!$conference['description'] ? 'none' : $conference['description']
?></div>
</div>





</div>

<?php endforeach; ?>

</div>









