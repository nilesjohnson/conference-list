
<h2 class="title">
<?php 
echo $this->Html->link($conference['Conference']['title'], $conference['Conference']['homepage']);
;?>
</h2>


<dl>
  <dt><?php echo __('Start Date'); ?></dt>
  <dd>
    <?php echo h($conference['Conference']['start_date']); ?>
     &nbsp;
  </dd>
  <dt><?php echo __('End Date'); ?></dt>
  <dd>
    <?php echo h($conference['Conference']['end_date']); ?>
     &nbsp;
  </dd>
  <dt><?php echo __('Institution'); ?></dt>
  <dd>
    <?php echo h($conference['Conference']['institution']); ?>
     &nbsp;
  </dd>
  <dt><?php echo __('City'); ?></dt>
  <dd>
    <?php echo h($conference['Conference']['city']); ?>
     &nbsp;
  </dd>
  <dt><?php echo __('Country'); ?></dt>
  <dd>
    <?php echo h($conference['Conference']['country']); ?>
     &nbsp;
  </dd>
  <dt><?php echo __('Meeting Type'); ?></dt>
  <dd>
    <?php echo h($conference['Conference']['meeting_type']); ?>
     &nbsp;
  </dd>
  <dt><?php echo __('Subject Area'); ?></dt>
  <dd>
    <?php echo h($conference['Conference']['subject_area']); ?>
     &nbsp;
  </dd>
  <dt><?php echo __('Homepage'); ?></dt>
  <dd>
    <?php echo $this->Html->link(h($conference['Conference']['homepage']),h($conference['Conference']['homepage'])); ?>
     &nbsp;
  </dd>
  <dt><?php echo __('Contact Name'); ?></dt>
  <dd>
    <?php echo h($conference['Conference']['contact_name']); ?>
     &nbsp;
  </dd>
</dl>


<h2>Description</h2>
<div class="conference_minor" style="display:block">
<?php echo 
!$conference['Conference']['description'] ? 'none' : $conference['Conference']['description']
?>
</div>

