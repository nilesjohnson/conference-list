
<div class="share-links">
  <div class="g-plusone" data-href="<? echo $conference['Conference']['homepage']; ?>"></div>
  <div style="display: inline-block;"><a href="https://twitter.com/share" class="twitter-share-button" 
    data-text="<? echo $conference['Conference']['title']; ?>"
    data-hashtags="ConferenceAnnouncement" 
    data-url="<? echo $conference['Conference']['homepage'];?>">Tweet</a></div>
</div>


<h2 class="title">
<?php 
echo $this->Html->link($conference['Conference']['title'], $conference['Conference']['homepage']);
;?>
</h2>

<div class="subject-tags">
<?php
  foreach($conference['Tag'] as $tag) {
    echo '<span class="tag">'.$tag['name']."</span>\n";
  }
?>
</div>

<div class="calendars" style="margin: 1ex;">
<?php  
echo
  $this->Html->link('Google calendar',
  $this->Gcal->gcal($conference['Conference']),
  array('escape' => false,'class'=>'ics button'));

echo
  $this->Html->link('iCalendar .ics',
  array('action'=>'view/'.$conference['Conference']['id'].'.ics'),
  array('escape' => false,'class'=>'ics button'));
?>
</div>

<dl>
<?php foreach ($this->Display->asArray($conference['Conference']) as $entry){
  if ($entry[0] != 'title' && $entry[0] != 'description' && $entry[0] != 'subject_area') {
    echo "  <dt>".$entry[1]."</dt>\n";
    echo "  <dd>".$entry[2]."&nbsp;</dd>\n"; 
  }
}?>
</dl>

<h2>Description</h2>
<div class="conference_minor" style="display:block">
<?php echo 
!$conference['Conference']['description'] ? 'none' : $conference['Conference']['description']
?>
</div>

<h2>Problems?</h2>
<p>
If you notice a problem with this entry, please contact 
<?php
echo "<a href=\"" . Configure::read('site.home') . "/conferences/about#curators\">the curators</a> ";
?>
by email.
</p>

