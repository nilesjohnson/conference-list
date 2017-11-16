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
  // link elements for rss feed
  if ($tagstring) {
    echo '<link type="application/rss+xml" rel="alternate" href="'.$tagstring.'.rss"/>';
  }
  else {
    echo '<link type="application/rss+xml" rel="alternate" href="'.Configure::read('site.home').'/conferences/index.rss"/>';
  }
?>


<?php
/*
echo $this->Js->link(array(
'https://apis.google.com/js/plusone.js', 
'http://platform.twitter.com/widgets.js', 
), false);
*/

// display search if requested 
if (isset($search) && $search) { 
echo '<h1>'.$view_title.'</h1>'; 

echo '<p>Currently the search only performs simple date comparison and basic 
string matching in the indicated fields.  If you have more sophisticated search 
needs, please <a href="http://nilesjohnson.net/contact.html" target="blank">let 
Niles know</a>.</p>';

echo $this->Form->create('Search');
echo "<br />";

echo $this->Form->input('Tag', array('label'=>'Subject tags', 'after'=>'Arxiv subject areas.  Select one or more; type to narrow options', 'multiple'=>true, 'default'=>$tagids));
echo $this->Form->input('after', array('label'=>'Begins after', 'type'=>'text', 'div'=>'input datefield', 'after'=>'yyyy-mm-dd'));
echo $this->Form->input('before', array('label'=>'Begins before', 'type'=>'text', 'div'=>'input datefield', 'after'=>'yyyy-mm-dd'));

echo $this->Form->input('title', array('label' => 'Title contains'));
//echo $this->Form->input('city', array('label'=>'City and State/Province'));
echo $this->Form->input('country', array('label'=>'Country contains', 'type'=>'text'));
//echo $this->Form->input('homepage', array('label'=>'Conference website'));
echo $this->Form->input('institution', array('label'=>'Host institution contains'));
echo $this->Form->input('meeting_type', array('label'=>'Meeting type contains'));
//echo $this->Form->input('contact_name', array('label'=>'Contact Name(s), comma separated'));
echo $this->Form->input('description', array('label'=>'Description contains'));

//echo '<div class="input"><p>Description Preview:</p><div class="wmd-preview"></div></div>';

/*
if (!isset($edit)) {
  echo '<div id="ConferenceRecaptcha" class="required">';
  echo $this->Form->label('recaptcha','Captcha task.');
  echo $this->Recaptcha->display();
  echo '</div>';
}
*/
echo $this->Form->end('Submit');
if ($results) {
  echo "<hr/>";
  echo "<h2>Results: ".count($conferences)." Announcement" . (count($conferences) != 1 ? 's' : '') . "</h2>";
  }
}


// else: default display
else {
?>

<div id="search_links">
<h2 style="margin: 0 0 1ex 0;">Choose a sublist of interest</h2>
<dl style="width:40ex;">
<dt><?php echo $this->Html->link(
  'Arithmetic Geometry', array('controller'=>null,'action'=>'ag-nt'));?>
</dt>
<dd>
  <span class="tag">ag.algebraic-geometry</span>
  <span class="tag">nt.number-theory</span>
</dd>
<!--
<dt><?php echo $this->Html->link(
  'Commutative Algebra', array('controller'=>null,'action'=>'ac-ag'));?>
</dt>
<dd>
  <span class="tag">ac.commutative-algebra</span>
  <span class="tag">ag.algebraic-geometry</span>
</dd>
-->
<dt><?php echo $this->Html->link(
  'Topology', array('controller'=>null,'action'=>'at-gt'));?>
</dt>
<dd>
  <span class="tag">at.algebraic-topology</span> 
  <span class="tag">gt.geometric-topology</span>
</dd>
<!--
<dt><?php echo $this->Html->link(
  'All', array('controller'=>null,'action'=>''));?>
</dt>
<dd>
  <span style="font-size:90%;">View all announcements.</span>
</dd>
-->
</dl>

<h2>Or choose your own subject tags below</h2>
</div>


<div class="intro_text">

  <p>Welcome to MathMeetings.net!  This is a list for research
  mathematics conferences, workshops, summer schools, etc.  Anyone
  at all is welcome to add announcements.</p>



  <div class="new">
    <h2>Know of a meeting not listed here?  Add it now!</h2>
    <p>
    <?php echo $this->Html->link('New Announcement', array('action' => 'add',$tagstring), array('class' => 'button', 'id' => 'add-button'));?>
    </p>
  </div>
  <h4>Updates 2017-10</h4>
  <ul>
    <li>Secure connections (https) now activated and all traffic is automatically redirected to use https.  Thanks to <a href='https://letsencrypt.org/' target='le'>Let's Encrypt</a> for providing the certificate!</li>
    <li>Spam protection now provided by Google <a href="https://www.google.com/recaptcha" target='gr'>reCaptcha</a>.</li>
    <li>New <?php echo $this->Html->link(
  'json and xml interfaces', array('action'=>'about#xml_json_about'));?> for access by other software.</li>
  </ul>
<!--
  <h4>Updates 2016-01</h4>
  <ul>
    <li>Now filter announcements by subject tags</li>
    <li>Form for editing announcements is now the same as that for adding new announcements</li>
    <li>New 'view' page for each announcement, and announcement data in confirmation emails</li>
    <li>Select boxes improved with select2 (jquery)</li>    
  </ul>	  

  <h4>Updates 2014-02-16</h4>

  <p>We've upgraded the AlgTop-Conf software to <a
  href="http://cakephp.org/" target="cake-blank">CakePHP 2.4.5</a> and
  <a href="http://www.php.net" target="php-blank">PHP 5.4</a>.  This involves
  substantial changes behind the scenes, but (hopefully!) minimal
  changes to the user interface.  If you notice something not working
  properly, please let Niles know.</p>
-->

  <p>Additional update notes are available in the <a href="https://github.com/nilesjohnson/conference-list" target="github">git repository</a> (GitHub).</p>

</div>


<hr class="top"/>
<h1 style="float:left;"><?php echo $view_title; ?></h1>

<div>
  <div style="float:right;">
<?php 
  if ($tagstring) {
    echo $this->Html->link('RSS',array('controller'=>null,'action'=>$tagstring.'.rss'));
    echo "&nbsp;&nbsp;";
    echo $this->Html->link('ICS',array('controller'=>null,'action'=>$tagstring.'.ics'));
  }
  else {
    echo $this->Html->link('RSS',Configure::read('site.home').'/conferences/index.rss');
    echo "&nbsp;&nbsp;";
    echo $this->Html->link('ICS',Configure::read('site.home').'/conferences/index.ics');
  }
?>
  </div>

<?php
  echo $this->Form->create('Conference');
  //the multi-select happens magically because of the HABTM and the variable $tags
  echo $this->Form->input('Tag',array(
    'label'=>'Subject tags',
    'value'=>$tagids,
    'onchange'=>"updateTagLink('".$this->Html->url(array('controller'=>null,'action'=>''))."');",
    'name'=>'tag_select',
    'after' => $this->Html->link(
      'Update tag selection', array('controller'=>null,'action'=>$tagstring), array('id'=>'tag_link')),
    'div'=>array('style'=>'display:none','id'=>'tagSelectDiv')
  ));
  //disables the SecurityComponent
  //$this->Form->unlockField('Tag');
  echo $this->Form->end();

  //echo $this->Html->link(
  //'Update tag selection', array('controller'=>null,'action'=>$tagstring), array('id'=>'tag_link'));
?>
<script>
<!--
document.getElementById('tagSelectDiv').style.display = 'block';
//-->
</script>
<noscript>
<pre>A javascript feature to select tags appears here.</pre>
<p>See <a href="/conferences/about#tags_about">about subject tags</a> to select tags by hand.</p>
</noscript>
</div>

<?php } ?>

<?php $curr_subsort = Null; $new_subsort = Null; $subsort_counter = 0; echo '<div id="subsort_start">'; ?>
<?php 
$site_url = Configure::read('site.home');
$site_name = Configure::read('site.name');

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
  $this->Gcal->gcal($conference),
  array('escape' => false,'class'=>'ics button'));
echo ' ';
echo
  $this->Html->link('iCalendar .ics',
  array('action'=>'view/'.$conference['id'].'.ics'),
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

<?php /* //print edit links  
  echo ' | '.$this->Html->link('Edit', 
  array('action'=>'edit', $conference['id'], $conference['edit_key'])); /**/?>


</div>

<div class="conference_minor" id="description_<?php echo $conference['id']?>">
<p>Meeting Type: <?php echo $conference['meeting_type']?></p>
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









