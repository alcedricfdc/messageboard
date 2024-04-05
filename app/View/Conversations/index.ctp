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
	<br>
	<br>
	<table cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th><?php echo ('id'); ?></th>
				<th><?php echo ('created_by'); ?></th>
				<th><?php echo ('created'); ?></th>
				<th><?php echo ('modified'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($conversations as $conversation) : ?>
				<tr>
					<td><?php echo h($conversation['Conversation']['id']); ?>&nbsp;</td>
					<td><?php echo h($conversation['Conversation']['created_by']); ?>&nbsp;</td>
					<td><?php echo h($conversation['Conversation']['created']); ?>&nbsp;</td>
					<td><?php echo h($conversation['Conversation']['modified']); ?>&nbsp;</td>
					<td class="actions">
						<?php echo $this->Html->link(__('View'), array('action' => 'view', $conversation['Conversation']['id'])); ?>
						<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $conversation['Conversation']['id'])); ?>
						<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $conversation['Conversation']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $conversation['Conversation']['id']))); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Conversation'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Participants'), array('controller' => 'participants', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Participant'), array('controller' => 'participants', 'action' => 'add')); ?> </li>
	</ul>
</div>