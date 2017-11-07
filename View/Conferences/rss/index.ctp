<?php
$this->set('documentData', array('xmlns:atom' => 'http://www.w3.org/2005/Atom'));

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

foreach ($conferences as $conference) {
  $bodyText = $conference['start_date']." <small>through</small> ".$conference['end_date'];
  $bodyText .= ", ".$conference['city']."; ".$conference['country'];
  $bodyText = h(strip_tags($bodyText));
  echo  $this->Rss->item(array(),
			 array(
			       'title' => $conference['title'],
			       'link' => $conference['homepage'],
			       'guid' => array('url' => $conference['homepage'], 'isPermaLink' => 'true'),
			       'description' =>  $bodyText,
			       'enclosure' => array('url'=>$this->Html->url(array('action'=>'view/'.$conference['id'].'.ics'), true),
						    'length'=>strlen($this->Ical->vcal(array($conference))),
						    'type'=>"text/calendar"),
				  //'dc:creator' => '',
				  //'pubDate' => ''
			       ))."\n\n";
}

?>