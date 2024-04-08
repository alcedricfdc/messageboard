<div class="conversations form">
<?php echo $this->Form->create('Conversation'); ?>
	<fieldset>
		<legend><?php echo __('Add Message'); ?></legend>
	<?php
		echo $this->Form->select(
			'recipient_id',
			array('placeholder' => 'Search for a recipient'),
			array(
				'id' => 'nameSelect',
				'placeholder' => 'Type a name...',
				'class' => 'select2'
			)
		);
		echo $this->Form->input('message', array(
			'type' => 'textarea'
		));
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

