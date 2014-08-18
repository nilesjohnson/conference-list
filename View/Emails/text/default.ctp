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

Thanks for adding your announcement to 
<?php 
echo Configure::read('site.name');
?>
.  The announcement data is copied below, and is also available at:
<?php
echo $this->Html->url(array('action'=>'view', $conference['Conference']['id']), $full=true);
?>


If you need to edit or delete your announcement, use the unique edit/delete link:
<?php
echo $this->Html->url($url=array('action'=>'edit', $conference['Conference']['id'], $conference['Conference']['edit_key']), $full=true);
?>


Note that you will receive a new edit/delete link after each update to your announcement.
If you have any difficulties, questions, or comments, don't hesitate to contact the curators:
<?php
echo $this->Html->url($url=array('action'=>'about#curators'), $full=true);
?>



best,
AlgTop-Conf


Announcement Data:

<?php
echo $this->Display->announcementText($conference['Conference']);
?>