<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Emails.text
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>

Your registration has been recorded!  Your information is copied below.

If you need to edit or delete your information, use the following private link:
<?php
echo $this->Html->url($url=array('action'=>'edit', $registrant['Registrant']['id'], $registrant['Registrant']['edit_key']), $full=true);
?>

If you have any difficulties, questions, or comments, you may contact the organizers by replying to this message.


Sincerely,
The organizers




Registration Data:

<?php 
echo $registrant['Registrant']['date']."\n";

echo "Basic Information\n";
echo "----\n";
echo "Name: ".$registrant['Registrant']['name']."\n";
echo "Webpage: ".$registrant['Registrant']['webpage']."\n";
echo "Affiliation: ".$registrant['Registrant']['affiliation']."\n";
echo "List basic info publicly: ";
echo $registrant['Registrant']['request_pub'] ? 'true':'false';
echo "\n\n";

echo "Additional Information\n";
echo "----\n";
echo "Email: ".$registrant['Registrant']['email']."\n";
echo "Request funding: ";
echo $registrant['Registrant']['request_fund'] ? 'true':'false';
echo "\n";
echo "Comment:\n";
echo $registrant['Registrant']['comment']."\n";


?>


