<?php
//$this->set('documentData', array('xmlns:atom' => 'http://www.w3.org/2005/Atom'));
/*
$this->set('channelData', array(
    'title' => __(Configure::read('site.name')." Announcements"),
    'link' => $this->Html->url('/', true),
    'description' => __("Upcoming meetings."),
    'language' => 'en-us',
    'atom:link' => array(
    		'attrib' => array(
			    'href' => Configure::read('site.home')."/conferences/index.rss",
	 		    'rel' => 'self',
			    'type' => 'application/rss+xml'
			    )
			 ),
));

echo "\n\n";
*/

foreach ($conferences as $conference) {

  $bodyText = $this->Html->link($conference['id'].'.ics',
    array('action'=>'ical', $conference['id']),
    array('escape' => false,'class'=>'ics button'));
  echo  $bodyText;
}

?>