<div class="conversations index">
	<h2><?php echo __('Conversations'); ?></h2>
	<?php echo $this->Html->link('New message', array('controller' => 'conversations', 'action' => 'add')) ?>
	<br>
	<div id="conversation-list">

	</div>
	<br>
</div>

<script>
	$(document).ready(function() {
		var page_count = 1;

		function getConversations(count) {

			$.post(
				'/messageboard/conversations/index', {
					page_count: count
				},
				function(response) {
					// let jsonData = JSON.parse(response)

					let conversationList = $("#conversation-list")
					conversationList.empty()

					response.forEach(convo => {

						let conversation = '<div class="conversations-container"><a href="/messageboard/conversations/view/' + convo['Conversation']['id'] + '" >'
												
						convo['Participant'].forEach(participant => {

							if (!participant.isSelf) {
								let profilePicture = participant.profile_picture == '' ? '<img class="small-profile-pic" src="app/webroot/img/default-profile.jpeg" alt="">' :
									'<img class="small-profile-pic" src="app/webroot/img/user_profile_uploads/' + participant.profile_picture + '">'
								let participantName = participant.name

								conversation += profilePicture + '<p>'+participantName+'</p>'
							}
						})

						conversation+= '</a>'

						let deleteButton = '<button class="delete-conversation-button" data-conversation-id="' + convo['Conversation']['id'] + '">' + 'Delete' + '</p>'
						conversation+= deleteButton+'</div>'
						


						conversationList.append(conversation)
					})

					let showMoreButton = '<button class="show-more-button" id="show-more-messages-button">Show more...</button>'

					conversationList.append(showMoreButton)

					page_count = count;

				}, 'json'
			);
		}

		$(document).on("click", "#show-more-messages-button", function() {
			getConversations(page_count + 1);
		});

		getConversations(page_count);

		var getConversationsIntervalId = setInterval(function() {
			getConversations(page_count);
		}, 1000)


		$(document).on('click', '.delete-conversation-button', function() {
			let conversationId = $(this).data('conversation-id');
			let conversationContainer = $(this).closest('.conversations-container')

			let confirmDelete = window.confirm("Are you sure you want to delete this conversation #" + conversationId + "?")

			if (confirmDelete) {
				clearInterval(getConversationsIntervalId);

				$.ajax({
					url: '/messageboard/conversations/delete/' + conversationId,
					type: 'DELETE',
					data: {},
					success: function(response) {
						console.log(response);
						conversationContainer.fadeOut(1000)

						setTimeout(function() {
							var getNewConversationsInterval = setInterval(function() {
								getConversations(page_count);
							}, 1000);
						}, 1000);

					},
					error: function(xhr, status, error) {
						console.error('Error deleting conversation:', error);
					}
				});
			} else {
				console.log('cancelled');

			}
		});
	})
</script>