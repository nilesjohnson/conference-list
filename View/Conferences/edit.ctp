<div class="conferences form">
<?php debug('This form is not used');?>
<?php echo $this->Form->create('Conference'); ?>
	<fieldset>
		<legend><?php echo __('Edit Conference'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('edit_key', array('type'=>'hidden'));
		echo $this->Form->input('title');
		echo $this->Form->input('start_date');
		echo $this->Form->input('end_date');
		//echo $this->Form->input('duration');
		echo $this->Form->input('institution');
		echo $this->Form->input('city');
		//echo $this->Form->input('region');
		echo $this->Form->input('country');
		echo $this->Form->input('meeting_type');
		//echo $this->Form->input('subject_area');
		echo $this->Form->input('Tag', array('label'=>'Subject tags'));
		echo $this->Form->input('homepage');
		echo $this->Form->input('contact_name');
		echo $this->Form->input('contact_email');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Conference.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Conference.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Conferences'), array('action' => 'index')); ?></li>
	</ul>
</div>
