<div class="users view">
	<h2><?php echo __('User'); ?></h2>
	<div id="profile-image-container" class="flex-row">
		<label for="profile-image-file-input" class="change-profile-button">Change</label>
		<?php
		if ($user['User']['profile_picture'] == '') {

			echo $this->Html->image('/app/webroot/img/default-profile.jpeg', array('id' => 'profile-image', 'alt' => 'Default Profile', 'class' => 'profile-image'));
		} else {
			echo $this->Html->image('/app/webroot/img/user_profile_uploads/' . $user['User']['profile_picture'], array('id' => 'profile-image', 'alt' => 'Default Profile', 'class' => 'profile-image'));
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

	<?php if (AuthComponent::user('id') == $user['User']['id']) : ?>
		<?php echo $this->Html->link('Edit info', array('controller' => 'users', 'action' => 'edit', $user['User']['id'])); ?>
		&nbsp;
		<?php echo $this->Html->link('Change password', array('controller' => 'users', 'action' => 'changePassword', $user['User']['id'])); ?>
	<?php endif ?>
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
		<?php if (AuthComponent::user('id') == $user['User']['id']) : ?>
			<dt><?php echo __('Password'); ?></dt>
			<dd class="password-display cursor-pointer">
				<?php echo h($user['User']['password']); ?>
			</dd>
		<?php endif ?>
	</dl>
</div>
