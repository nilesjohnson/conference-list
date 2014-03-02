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

  $bodyText = $conference['Conference']['start_date']." <small>through</small> ".$conference['Conference']['end_date'];
  $bodyText .= ", ".$conference['Conference']['city']."; ".$conference['Conference']['country'];
  $bodyText = h(strip_tags($bodyText));
  echo  $this->Rss->item(array(), array(
				  'title' => $conference['Conference']['title'],
				  'link' => $conference['Conference']['homepage'],
				  'guid' => array('url' => $conference['Conference']['homepage'], 'isPermaLink' => 'true'),
				  'description' =>  $bodyText,
				  //'dc:creator' => '',
				  //'pubDate' => ''
					))."\n\n";
}

?>