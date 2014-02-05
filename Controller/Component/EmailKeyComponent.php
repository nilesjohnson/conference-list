<?php

class EmailKeyComponent extends Component {

  // test function
  public function send_key_test($id,$conf_data,$cc_data) {
    $from    = 'AlgTop-Conf <noreply@nilesjohnson.net>';
    $to      = $conf_data['Conference']['contact_email'];
    $bcc      = 'nilesj@gmail.com';
    $reply_to = 'njohnson@math.uga.edu';
    $subject = 'AlgTop-Conf: ' . $conf_data['Conference']['title'];
    $headers = 'From: '. $from . "\n";
    $headers .= 'Bcc: ' . $bcc . "\n";
    $headers .= 'Reply-To: ' . $reply_to . "\n";
    $body = "Thanks for adding your announcement to AlgTop-Conf; it is now available in the main list:\n";
    $body .= "http://www.nilesjohnson.net/algtop-conf/ \n\n";
    $body .= "If you need to edit your announcement, use the unique edit link: \n";
    $body .= "http://www.nilesjohnson.net/algtop-conf/conferences/edit/" . 
      $id . '/' . $conf_data['Conference']['edit_key'] . "\n\n";
    $body .= "If you need to delete your announcement, use the unique delete link: \n";
    $body .= "http://www.nilesjohnson.net/algtop-conf/conferences/view/" . 
      $id . '/' . $conf_data['Conference']['edit_key'] . "\n\n";
    $body .= "Note that you will receive new edit/delete links after each update to your announcement. ";
    $body .= "If you have any difficulties, questions, or comments, don't hesitate to contact Niles: \n" . "njohnson@math.uga.edu \n\n";
    $body .= "best, \n" . "AlgTop-Conf";

    mail($to, $subject, $body, $headers);    
  }

  public function send_key($id,$conf_data, $admin_list) {
    $from    = 'AlgTop-Conf <noreply@nilesjohnson.net>';
    $to      = $conf_data['Conference']['contact_email'];
    $bcc      = implode(", ", $admin_list);
    $reply_to = 'njohnson@math.uga.edu';
    $subject = 'AlgTop-Conf: ' . $conf_data['Conference']['title'];
    $headers = 'From: '. $from . "\n";
    $headers .= 'Bcc: ' . $bcc . "\n";
    $headers .= 'Reply-To: ' . $reply_to . "\n";
    $body = "Thanks for adding your announcement to AlgTop-Conf; it is now available in the main list:\n";
    $body .= "http://www.nilesjohnson.net/algtop-conf/ \n\n";
    $body .= "If you need to edit your announcement, use the unique edit link: \n";
    $body .= "http://www.nilesjohnson.net/algtop-conf/conferences/edit/" . 
      $id . '/' . $conf_data['Conference']['edit_key'] . "\n\n";
    $body .= "If you need to delete your announcement, use the unique delete link: \n";
    $body .= "http://www.nilesjohnson.net/algtop-conf/conferences/view/" . 
      $id . '/' . $conf_data['Conference']['edit_key'] . "\n\n";
    $body .= "Note that you will receive new edit/delete links after each update to your announcement. ";
    $body .= "If you have any difficulties, questions, or comments, don't hesitate to contact Niles: \n" . "njohnson@math.uga.edu \n\n";
    $body .= "best, \n" . "AlgTop-Conf";

    mail($to, $subject, $body, $headers);    
  }

  public function send_cc($cc_data, $admin_list) {
    $from     = $cc_data['from'];
    $to       = $cc_data['to'];
    $bcc      = $cc_data['from'] . ', ' . implode(", ", $admin_list);
    $reply_to = $cc_data['from'];
    $subject  = $cc_data['subject'];
    $headers  = 'From: '. $from . "\n";
    $headers .= 'Bcc: ' . $bcc . "\n";
    $headers .= 'Reply-To: ' . $reply_to . "\n";
    $body = $cc_data['body'];
    mail($to, $subject, $body, $headers);
  }

  public function report_item($id, $conf_data, $address_list) {
    $from    = 'AlgTop-Conf <noreply@nilesjohnson.net>';
    $to      = implode(", ", $address_list);
    $bcc = '';
    $reply_to = 'njohnson@math.uga.edu';
    $subject = 'AlgTop-Conf Problem: ' . $conf_data['Conference']['title'];
    $headers = 'From: '. $from . "\n";
    $headers .= 'Bcc: ' . $bcc . "\n";
    $headers .= 'Reply-To: ' . $reply_to . "\n";
    $body = "There is a problem with this announcement at AlgTop-Conf:\n\n";
    $body .= "-------comment-------\n";
    $body .= $conf_data['Conference']['report_comment'] . "\n\n";
    $body .= "-------details-------\n";
    $body .= 'Meeting Type: ' . $conf_data['Conference']['meeting_type'] . "\n";
    $body .= 'Subject Area: ' . $conf_data['Conference']['subject_area'] . "\n";
    $body .= 'Contact: ' . $conf_data['Conference']['contact_name'] . "\n\n";
    $body .= 'Description: ' . $conf_data['Conference']['description'] . "\n\n";
    /*
    $body .= "--------links--------\n";
    $body .= "Here is the link to edit this announcement: \n";
    $body .= "http://www.nilesjohnson.net/algtop-conf/conferences/edit/" . 
      $id . '/' . $conf_data['Conference']['edit_key'] . "\n\n";
    $body .= "Here is the link to delete this announcement: \n";
    $body .= "http://www.nilesjohnson.net/algtop-conf/conferences/view/" . 
      $id . '/' . $conf_data['Conference']['edit_key'] . "\n\n";
    */
    $body .= "best, \n" . "AlgTop-Conf";
    mail($to, $subject, $body, $headers);    
  }
    
}

?>
