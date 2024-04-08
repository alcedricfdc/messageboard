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

<div class="conversation-box" id="conversation-box">

</div>
<br>
<div class="flex-column align-end">

	<?php
	echo $this->Form->input(
		'message',
		array(
			'type' => 'textarea',
			'id' => 'replayTextArea',
			'cols' => 40,
			'rows' => 3
		)
	);
	echo $this->Form->button('Send', array('id' => 'sendMessage'));

	?>

</div>

<script>
	$(document).ready(function() {

		$(document).on('click', '.delete-message-button', function() {
			let messageId = $(this).data('message-id');
			let messageContainer = $(this).closest('.message-box-sent')

			let confirmDelete = window.confirm("Are you sure you want to delete this message #" + messageId + "?")

			if (confirmDelete) {
				clearInterval(getMessagesIntervalId);

				$.ajax({
					url: '/messageboard/messages/delete/' + messageId,
					type: 'DELETE',
					data: {},
					success: function(response) {
						console.log('Message deleted successfully:', response);
						messageContainer.fadeOut(1000)

						setTimeout(function() {
							var getNewMessagesInterval = setInterval(function() {
								getMessages(page_count);
							}, 1000);
						}, 1000);

					},
					error: function(xhr, status, error) {
						console.error('Error deleting message:', error);
					}
				});
			} else {
				console.log('cancelled');

			}
		});




		var page_count = 1;

		function getMessages(count) {
			let url = window.location.href;
			let parts = url.split('/');
			let conversation_id = parts[parts.length - 1];

			$.post(
				'/messageboard/messages/getMessages', {
					conversation_id: conversation_id,
					page_count: count
				},
				function(response) {
					let jsonData = JSON.parse(response)

					let conversationBox = $("#conversation-box")
					conversationBox.empty()

					jsonData.forEach(message => {
						let messageClassName = message['Participant']['isLoggedIn'] ? 'message-box-sent' : 'message-box-received'
						let deleteButton = message['Participant']['isLoggedIn'] ? '<button class="delete-message-button" data-message-id="' + message['Message']['id'] + '">' + 'Delete' + '</p>' : ''

						let messageContainer = '<div class="' + messageClassName + '">' +
							'<p>' + message['Message']['message'] + '</p>' +
							'<p class="message-time-sent">' + message['Message']['created'] + '</p>' +
							deleteButton +
							'</div>'
						conversationBox.append(messageContainer)
					})

					let showMoreButton = '<button class="show-more-button" id="show-more-messages-button">Show more...</button>'

					conversationBox.append(showMoreButton)

					page_count = count;

				}
			);
		}

		$(document).on("click", "#show-more-messages-button", function() {
			getMessages(page_count + 1);
		});

		getMessages(page_count);

		var getMessagesIntervalId = setInterval(function() {
			getMessages(page_count);
		}, 1000)

		$("button[id='sendMessage']").click(function() {
			let message = $("#replayTextArea").val()

			let url = window.location.href;
			let parts = url.split('/');
			let conversation_id = parts[parts.length - 1];

			$.post(
				'/messageboard/conversations/replyMessage', {
					conversation_id: conversation_id,
					message: message
				},
				replyMessageCallback
			);

			function replyMessageCallback(response) {
				console.log(response);
				$("#replayTextArea").val('')
				getMessages(page_count);
			}

		})


	})
</script>