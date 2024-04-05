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
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Conversations'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Participants'), array('controller' => 'participants', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Participant'), array('controller' => 'participants', 'action' => 'add')); ?> </li>
	</ul>
</div>