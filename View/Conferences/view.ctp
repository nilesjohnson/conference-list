
<h2 class="title">
<?php 
echo $this->Html->link($conference['Conference']['title'], $conference['Conference']['homepage']);
;?>
</h2>

<div class="calendars" style="margin: 1ex;">
<?php  
$site_url = Configure::read('site.home');
$site_name = Configure::read('site.name');
echo
  $this->Html->link('Google calendar',
  $this->Gcal->gcal_url($conference['Conference']['id'], 
                               $conference['Conference']['start_date'], 
                               $conference['Conference']['end_date'],
                               $conference['Conference']['title'],
                               $conference['Conference']['city'],
                               $conference['Conference']['country'],
                               $conference['Conference']['homepage'],
			       $site_url,
			       $site_name
                               ),
  array('escape' => false,'class'=>'ics button'));

echo
  $this->Html->link('iCalendar .ics',
  array('action'=>'ical', $conference['Conference']['id']),
  array('escape' => false,'class'=>'ics button'));
?>
</div>

<dl>
<?php foreach ($this->Display->asArray($conference['Conference']) as $entry){
  if ($entry[0] != 'title' && $entry[0] != 'description') {
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

