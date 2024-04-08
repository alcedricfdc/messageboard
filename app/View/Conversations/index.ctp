<div class="conversations index">
	<h2><?php echo __('Conversations'); ?></h2>
	<?php echo $this->Html->link('New message', array('controller' => 'conversations', 'action' => 'add')) ?>
	<br>
	<?php foreach ($conversations as $conversation) : ?>
		<?php foreach ($conversation['Participant'] as $participant) : ?></p>
			<?php if ($participant['user_id'] !== AuthComponent::user('id')) : ?>
				<div class="conversations-container">
					<?php
					if ($participant['profile_picture'] == '') {
						echo $this->Html->image('/app/webroot/img/default-profile.jpeg', array('id' => 'profile-image', 'alt' => 'Default Profile', 'class' => 'small-profile-pic'));
					} else {
						echo $this->Html->image('/app/webroot/img/user_profile_uploads/' . $participant['profile_picture'], array('alt' => 'Default Profile', 'class' => 'small-profile-pic'));
					}
					?>
					<?php echo $this->Html->link(__($participant['name']), array('action' => 'view', $conversation['Conversation']['id'])); ?>

				</div>

			<?php endif; ?>
		<?php endforeach ?>
	<?php endforeach ?>
	<br>
</div>
