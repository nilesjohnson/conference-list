<?php
if (isset($edit)){
echo '<div class="conferences form">';
$addedit='Edit';
}
 else $addedit='New';
echo '<h1>'.$addedit.' Meeting Information</h1>';

echo $this->Form->create('Conference');
echo $this->Form->submit('Submit');
echo "<br />";
if (isset($edit)){
	echo $this->Form->input('id');
	echo $this->Form->input('edit_key', array('type'=>'hidden'));
}

echo $this->Form->input('title');
echo $this->Form->input('start_date', array('type'=>'text', 'div'=>'input datefield', 'after'=>'yyyy-mm-dd'));
echo $this->Form->input('end_date', array('type'=>'text', 'div'=>'input datefield', 'after'=>'yyyy-mm-dd'));
echo $this->Form->input('city', array('label'=>'City and State/Province'));

echo "\n"."<!-- country data from https://github.com/mledoze/countries licensed under Open Database License 1.0 -->\n";
echo $this->Form->input('country', array( 'type'=>'select', 'options'=>$countries, 'default'=>'country', 'after'=>'Type to narrow options'));
echo $this->Form->input('homepage', array('label'=>'Conference website'));
echo $this->Form->input('institution', array('label'=>'Host institution', 'after'=>'University, institute, etc.'));
echo $this->Form->input('meeting_type', array('after'=>'e.g. conference, summer school, special session, etc.'));
echo $this->Form->input('Tag', array('label'=>'Subject tags', 'after'=>'Arxiv subject areas.  Select one or more; type to narrow options', 'multiple'=>true, 'default'=>$tagids));
echo $this->Form->input('contact_name', array('label'=>'Contact Name(s), comma separated'));
echo $this->Form->input('contact_email', array('label'=>'Contact Email(s), comma separated', 'after'=>'never displayed publicly; confirmation and edit/delete codes will be sent to these addresses'));
echo $this->Form->input('description', array('label'=>'Description: <br/><span style="font-size:80%;">Enter text, HTML, or <a href="http://daringfireball.net/projects/markdown/">Markdown</a>.</span>', 'rows' => '10'));

echo '<div class="input"><p>Description Preview:</p><div class="wmd-preview"></div></div>';

if (!(isset($edit) || $validCuratorcookie)) {
  echo '<div id="ConferenceRecaptcha" class="required">';
  echo $this->Form->label('recaptcha','Captcha task.');
  echo $this->Recaptcha->display();
  echo '</div>';
}
echo $this->Form->end('Submit');
if (isset($edit)) {
echo '</div>';
?>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Conference.id'),$this->Form->value('Conference.edit_key')), null, __('Are you sure you want to delete "%s"?', $this->Form->value('Conference.title'))); ?></li>
		<li><?php echo $this->Html->link(__('List Conferences'), array('action' => 'index')); ?></li>
	</ul>
</div>
<? } ?>
<script type="text/javascript">
  // to set WMD's options programatically, define a "wmd_options" object with whatever settings
  // you want to override.  Here are the defaults:
  wmd_options = {
    // format sent to the server.  Use "Markdown" to return the markdown source.
    output: "HTML",

    // line wrapping length for lists, blockquotes, etc.
    lineLength: 40,

    // toolbar buttons.  Undo and redo get appended automatically.
    buttons: "bold italic | link blockquote code | ol ul heading hr",

    // option to automatically add WMD to the first textarea found.  See apiExample.html for usage.
    autostart: true
  };
</script>

<script type="text/javascript" src="<?echo Configure::read('site.home');?>/js/wmd/wmd.js"></script>
