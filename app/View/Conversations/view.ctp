<div>
	<h2><?php echo __('Message details'); ?></h2>

	<?php foreach ($conversation['Participant'] as $participant) : ?>
		<?php if ($participant['user_id'] !== AuthComponent::user('id')) : ?>
			<h2>Name :
				<?php echo $participant['name'] ?>
			</h2>
		<?php endif ?>
	<?php endforeach ?>

</div>

<div class="conversation-box">
	
	<div class="message-box-sent">
		Hi this is my own message sent
	</div>
	<div class="message-box-received">
		This is the reply i received
	</div>
</div>
<br>
<br>
<br>


<div class="related">
	<h3><?php echo __('Related Messages'); ?></h3>
	<?php if (!empty($conversation['Message'])) : ?>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('Participant Id'); ?></th>
				<th><?php echo __('Conversation Id'); ?></th>
				<th><?php echo __('Message'); ?></th>
				<th><?php echo __('Created'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($conversation['Message'] as $message) : ?>
				<tr>
					<td><?php echo $message['id']; ?></td>
					<td><?php echo $message['participant_id']; ?></td>
					<td><?php echo $message['conversation_id']; ?></td>
					<td><?php echo $message['message']; ?></td>
					<td><?php echo $message['created']; ?></td>
					<td class="actions">
						<?php echo $this->Html->link(__('View'), array('controller' => 'messages', 'action' => 'view', $message['id'])); ?>
						<?php echo $this->Html->link(__('Edit'), array('controller' => 'messages', 'action' => 'edit', $message['id'])); ?>
						<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'messages', 'action' => 'delete', $message['id']), array('confirm' => __('Are you sure you want to delete # %s?', $participant['id']))); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php endif; ?>

	<pre>
	<!-- <?php print_r($messages) ?> -->
</pre>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Participant'), array('controller' => 'participants', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>

<!-- <div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Conversation'), array('action' => 'edit', $conversation['Conversation']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Conversation'), array('action' => 'delete', $conversation['Conversation']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $conversation['Conversation']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Conversations'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Conversation'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Participants'), array('controller' => 'participants', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Participant'), array('controller' => 'participants', 'action' => 'add')); ?> </li>
	</ul>
</div> -->




<!-- <div class="related">
	<h3><?php echo __('Related Participants'); ?></h3>
	<?php if (!empty($conversation['Participant'])) : ?>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('User Id'); ?></th>
				<th><?php echo __('Conversation Id'); ?></th>
				<th><?php echo __('Created'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($conversation['Participant'] as $participant) : ?>
				<tr>
					<td><?php echo $participant['id']; ?></td>
					<td><?php echo $participant['user_id']; ?></td>
					<td><?php echo $participant['conversation_id']; ?></td>
					<td><?php echo $participant['created']; ?></td>
					<td class="actions">
						<?php echo $this->Html->link(__('View'), array('controller' => 'participants', 'action' => 'view', $participant['id'])); ?>
						<?php echo $this->Html->link(__('Edit'), array('controller' => 'participants', 'action' => 'edit', $participant['id'])); ?>
						<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'participants', 'action' => 'delete', $participant['id']), array('confirm' => __('Are you sure you want to delete # %s?', $participant['id']))); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Participant'), array('controller' => 'participants', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div> -->