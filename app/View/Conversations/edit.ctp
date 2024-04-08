<div class="conversations form">
<?php echo $this->Form->create('Conversation'); ?>
	<fieldset>
		<legend><?php echo __('Edit Conversation'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('created_by');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

