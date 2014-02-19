<div class="conferences index">
	<h2><?php echo __('Conferences'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('edit_key'); ?></th>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('start_date'); ?></th>
			<th><?php echo $this->Paginator->sort('end_date'); ?></th>
			<th><?php echo $this->Paginator->sort('duration'); ?></th>
			<th><?php echo $this->Paginator->sort('institution'); ?></th>
			<th><?php echo $this->Paginator->sort('city'); ?></th>
			<th><?php echo $this->Paginator->sort('region'); ?></th>
			<th><?php echo $this->Paginator->sort('country'); ?></th>
			<th><?php echo $this->Paginator->sort('meeting_type'); ?></th>
			<th><?php echo $this->Paginator->sort('subject_area'); ?></th>
			<th><?php echo $this->Paginator->sort('homepage'); ?></th>
			<th><?php echo $this->Paginator->sort('contact_name'); ?></th>
			<th><?php echo $this->Paginator->sort('contact_email'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($conferences as $conference): ?>
	<tr>
		<td><?php echo h($conference['Conference']['id']); ?>&nbsp;</td>
		<td><?php echo h($conference['Conference']['edit_key']); ?>&nbsp;</td>
		<td><?php echo h($conference['Conference']['title']); ?>&nbsp;</td>
		<td><?php echo h($conference['Conference']['start_date']); ?>&nbsp;</td>
		<td><?php echo h($conference['Conference']['end_date']); ?>&nbsp;</td>
		<td><?php echo h($conference['Conference']['duration']); ?>&nbsp;</td>
		<td><?php echo h($conference['Conference']['institution']); ?>&nbsp;</td>
		<td><?php echo h($conference['Conference']['city']); ?>&nbsp;</td>
		<td><?php echo h($conference['Conference']['region']); ?>&nbsp;</td>
		<td><?php echo h($conference['Conference']['country']); ?>&nbsp;</td>
		<td><?php echo h($conference['Conference']['meeting_type']); ?>&nbsp;</td>
		<td><?php echo h($conference['Conference']['subject_area']); ?>&nbsp;</td>
		<td><?php echo h($conference['Conference']['homepage']); ?>&nbsp;</td>
		<td><?php echo h($conference['Conference']['contact_name']); ?>&nbsp;</td>
		<td><?php echo h($conference['Conference']['contact_email']); ?>&nbsp;</td>
		<td><?php echo h($conference['Conference']['description']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $conference['Conference']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $conference['Conference']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $conference['Conference']['id']), null, __('Are you sure you want to delete # %s?', $conference['Conference']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Conference'), array('action' => 'add')); ?></li>
	</ul>
</div>
