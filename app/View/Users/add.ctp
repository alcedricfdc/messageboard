<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Create an account'); ?></legend>
	<?php
		echo $this->Form->input('name', array('id' => 'name'));
		echo $this->Form->input('age', array('id' => 'age'));
		echo $this->Form->input('birthdate', array('id' => 'birthdate'));
		echo $this->Form->input('gender', array(
			'type' => 'radio',
			'options' => array(
				'male' => 'Male',
				'female' => 'Female'
			)
		));
		echo $this->Form->input('hobby', array('id' => 'hobby'));
		echo $this->Form->input('email', array('id' => 'email'));
		echo $this->Form->input('password', array('id' => 'password', 'value' => ''));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
