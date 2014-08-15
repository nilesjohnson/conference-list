
<?php
// calendar date picker

$this->Html->script('jquery-ui-1.8.10.custom/js/jquery-1.4.4.min',array('inline'=>false));
$this->Html->script('jquery-ui-1.8.10.custom/js/jquery-ui-1.8.10.custom.min',array('inline'=>false));
$this->Html->css('jquery-ui-1.8.10.custom-css/jquery-ui-1.8.10.custom',array('inline'=>false));
$this->Html->script('datepicker',array('inline'=>false));

?>


<h1>Add Meeting Information</h1>

<?php 
echo $this->Form->create('Conference');
echo $this->Form->input('title');
//echo $this->Form->input('edit_key', array('type'=>'hidden'));
echo $this->Form->input('start_date', array('type'=>'text', 'div'=>'input datefield', 'after'=>'yyyy-mm-dd'));
echo $this->Form->input('end_date', array('type'=>'text', 'div'=>'input datefield', 'after'=>'yyyy-mm-dd'));
//echo $this->Form->input('duration');
echo $this->Form->input('city', array('label'=>'City and State/Province'));
echo $this->Form->input('country', array( 'type'=>'select', 'options'=>$countries, 'default'=>'country'));
echo $this->Form->input('homepage', array('label'=>'Conference website'));
echo $this->Form->input('institution', array('label'=>'Host institution', 'after'=>'University, institute, etc.'));
echo $this->Form->input('meeting_type', array('after'=>'e.g. conference, summer school, special session, etc.'));
echo $this->Form->input('subject_area', array('after'=>'comma-separated list'));
echo $this->Form->input('contact_name');
echo $this->Form->input('contact_email', array('after'=>'never displayed publicly; confirmation and edit/delete codes will be sent to this address (or list of addresses)'));
echo $this->Form->input('description', array('label'=>'Description: <br/><span style="font-size:80%;">Enter text, HTML, or <a href="http://daringfireball.net/projects/markdown/">Markdown</a>.</span>', 'rows' => '10'));
echo '<div class="input"><p>Description Preview:</p><div class="wmd-preview"></div></div>';
?>



<?php
echo $this->Form->input('captcha', array('label' => 'Please Enter the Sum of ' . $mathCaptcha, 'after'=>'anti-spam'));
echo $this->Form->end('Submit');
?>

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

<script type="text/javascript" src="/js/wmd/wmd.js"></script>


