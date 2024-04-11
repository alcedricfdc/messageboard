<div class="flex-row justify-space-between">
	<div>
		<h2><?php echo __('Message details'); ?></h2>

		<?php foreach ($conversation['Participant'] as $participant) : ?>
			<?php if ($participant['user_id'] !== AuthComponent::user('id')) : ?>
				<h2>Name :
					<?php echo $this->Html->link($participant['name'], array('controller' => 'users', 'action' => 'view', $participant['user_id'])); ?>
				</h2>
			<?php endif ?>
		<?php endforeach ?>
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
</div>
<br>
<div class="search-message-container">
	<?php
	echo $this->Form->input(
		'',
		array(
			'id' => 'search-message-input',
			'placeholder' => 'Seach for a message...'
		)
	);
	echo $this->Form->button('Search', array('id' => 'search-message-button'));

	?>
</div>

<div class="search-results-container" id="search-results-container">

</div>

<div class="conversation-box" id="conversation-box">

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



		var showmoreMessagesId = [];
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
						let messageClassName = message['Participant']['isSelf'] ? 'message-box-sent' : 'message-box-received'
						let deleteButton = message['Participant']['isSelf'] ? '<button class="delete-message-button" data-message-id="' + message['Message']['id'] + '">' + 'Delete' + '</p>' : ''

						let originalText = message['Message']['message']
						let messageText = message['Message']['message']
						let readMoreButton = '';

						if (showmoreMessagesId.includes(Number(message['Message']['id']))) {
							

						} else if (messageText.length > 100) {
							messageText = messageText.slice(0, 99) + '...'
							readMoreButton = '<span class="read-more-span" data-message-id="' + message['Message']['id'] + '">read more...</span><br>'
						}

						let messageContainer = '<div class="' + messageClassName + '">' +
							'<p class="original-message">' + originalText + '</p>' +
							'<p class="modified-message">' + messageText + '</p>' +
							readMoreButton +
							'<p class="message-time-sent">' + message['Message']['created'] + '</p>' +
							deleteButton +
							'</div>'
						conversationBox.append(messageContainer)
					})

					$(".read-more-span").click(function() {
						showmoreMessagesId.push($(this).data('message-id'))
						console.log(showmoreMessagesId);

						$(this).closest('div').find('.original-message').show()
						$(this).closest('div').find('.modified-message').hide()

						$(this).hide()


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


		$("button[id='search-message-button']").click(function() {
			let searchInput = $("#search-message-input").val()

			let url = window.location.href;
			let parts = url.split('/');
			let conversation_id = parts[parts.length - 1];

			let searchResultContainer = $('#search-results-container')
			searchResultContainer.empty()

			$.post(
				'/messageboard/messages/searchMessage', {
					conversation_id: conversation_id,
					searchInput: searchInput
				},
				function(response) {
					response.forEach(message => {
						console.log(message);
						let resultMessage = '<div class="search-result">' + message['Message']['sender'] + ' : ' + message['Message']['message'] + '<br><i class="small-text">' + message['Message']['created'] + '</i></div>'

						searchResultContainer.append(resultMessage)
					})

					searchResultContainer.prepend('<div class="search-results-header">Search Results</div>')

				}
			);

		})

	})
</script>