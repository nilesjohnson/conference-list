<?php
$this->set('channelData', array(
    'title' => __("AlgTop-Conf Announcements"),
    'link' => $this->Html->url('/', true),
    'description' => __("Upcoming meetings."),
    'language' => 'en-us'
));


foreach ($conferences as $conference) {

  $bodyText = $conference['Conference']['start_date']." <small>through</small> ".$conference['Conference']['end_date'];
  $bodyText .= ", ".$conference['Conference']['city']."; ".$conference['Conference']['country'];
  $bodyText = h(strip_tags($bodyText));
  echo  $this->Rss->item(array(), array(
				  'title' => $conference['Conference']['title'],
				  'link' => $conference['Conference']['homepage'],
				  'guid' => array('url' => $conference['Conference']['homepage'], 'isPermaLink' => 'true'),
				  'description' =>  $bodyText,
				  'dc:creator' => '',
				  //'pubDate' => ''
					));
}

?>