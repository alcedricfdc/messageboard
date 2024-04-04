<div class="users view">
	<h2><?php echo __('User'); ?></h2>
	<div id="profile-image-container" class="flex-row">
		<label for="profile-image-file-input" class="change-profile-button">Change</label>
		<?php 
			if($user['User']['profile_picture'] == '') {
				
				echo $this->Html->image('/app/webroot/img/default-profile.jpeg', array('id' => 'profile-image', 'alt' => 'Default Profile', 'class' => 'profile-image')); 
			} else {
				echo $this->Html->image('/app/webroot/img/user_profile_uploads/'.$user['User']['profile_picture'], array('id' => 'profile-image', 'alt' => 'Default Profile', 'class' => 'profile-image')); 
			}
		?>
		<div id="update-profile-image-form-container" class="display-none">
			<?php
				echo $this->Form->create('User', array('type' => 'file', 'url' => array('controller' => 'Users', 'action' => 'uploadProfileImage'))); // Create form with file type
				echo $this->Form->file('image', array('id' => 'profile-image-file-input', 'accept' => '.jpg, .jpeg, .gif, .png', 'class' => 'display-none'));
				echo $this->Form->submit('Upload', array('id' => 'update-profile-image-button')); // Submit button
				echo $this->Form->end(); // End form
			?>
		</div>

	</div>


	<br><br>
	<?php echo $this->Html->link('Edit info', array('controller' => 'users', 'action' => 'edit', $user['User']['id'])); ?>
	&nbsp;
	<?php echo $this->Html->link('Change password', array('controller' => 'users', 'action' => 'changePassword', $user['User']['id'])); ?>

	<dl>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($user['User']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Age'); ?></dt>
		<dd>
			<?php echo h($user['User']['age']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Birthdate'); ?></dt>
		<dd>
			<?php echo h($user['User']['birthdate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Gender'); ?></dt>
		<dd>
			<?php echo h($user['User']['gender']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hobby'); ?></dt>
		<dd>
			<?php echo h($user['User']['hobby']); ?>
			&nbsp;
		</dd>
	</dl>
	<br>
	<dl>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($user['User']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Password'); ?></dt>
		<dd class="password-display cursor-pointer">
			<?php echo h($user['User']['password']); ?>
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $user['User']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
	</ul>
</div>