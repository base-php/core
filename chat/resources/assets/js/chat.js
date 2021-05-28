function chat_list(that, prepend = '') {
	$('.chat_list').removeClass('active_chat');
	$(that).addClass('active_chat');

	id = $(that).attr('data-user');
	name = $(that).attr('data-name');
	photo = $(that).attr('data-photo');

	if (prepend != '') {
		if ($('.chats').find('[data-user=' + id + ']').length == 0) {
			$('.chats').prepend(`
				<div onClick="chat_list(this)" class="chat_list active_chat" data-user="${id}" data-name="${name}" data-photo="${ (photo) ? photo : '/resources/assets/img/app/user.png' }">
					<div class="chat_people">
						<div class="chat_img">
							<img height="38px" width="38px" src="${ (photo) ? photo : '/resources/assets/img/app/user.png' }" alt="sunil">
						</div>

						<div class="chat_ib" data-info="${id}">
							<h5>
								${name}
							</h5>
						</div>
					</div>
				</div>
			`);
		}
	}

	$.ajax({
		url: '/chats/messages/' + id,
		type: 'GET',
		success: function (response) {
			$('.text-success').remove();

			html = `
				<div class="headind_srch" style="margin-top: 0px">
					<div class="chat_img">
						<img height="56px" width="56px" src="${photo}" alt="sunil">
					</div>

					<div class="recent_heading mt-3 ml-5">
						${name}
					</div>

					<div class="float-right mt-2">
						<label for="file">
							<i class="fa fa-paperclip" style="cursor: pointer"></i>
						</label>

						<input onChange="file()" type="file" id="file" style="display: none">

						<button onClick="close_conversation()" class="btn btn-default">
							<i class="fa fa-times"></i>
						</button>
					</div>
				</div>
			`;

			html += '<div class="msg_history">';			

			for (var i = response.length - 1; i >= 0; i--) {
				if (response[i].id_sender != id) {
					html += `
						<div id="${response[i].timestamp}" class="outgoing_msg mr-3">
							<div class="sent_msg">
								<p>${response[i].content}</p>
								<span class="time_date">${response[i].date}</span>
							</div>
						</div>
					`;
				} else {
					html += `
						<div id="${response[i].timestamp}" class="incoming_msg">
							<div class="received_msg">
								<div class="received_withd_msg">
									<p>${response[i].content}</p>
									<span class="time_date">${response[i].date}</span>
								</div>
							</div>
						</div>
					`;
				}

				timestamp = response[i].timestamp;
			}

			html += '</div>';

			html += `
				<div class="type_msg">
					<div class="input_msg_write">
						<input style="width: 90%" onKeypress="send(event)" type="text" class="write_msg" placeholder="Escribe un mensaje">
						<input type="hidden" name="id" value="${id}">
						<button onClick="send()" class="msg_send_btn" type="button">
							<i class="fa fa-paper-plane" aria-hidden="true"></i>
						</button>
					</div>
				</div>
			`;

			$('.mesgs').html(html);

			window.location.href = '#' + timestamp;

			$('.write_msg').focus();
		},
		error: function (error) {
			$('body').html(error.responseText);
		}
	});
}

function send(event = '') {
	if (event != '' && event.key != 'Enter') {
		return false;
	}

	content = $('.write_msg').val();
	id_addresse = $('[name=id]').val();

	if (content == '') {
		return false;
	}

	$.ajax({
		type: 'POST',
		url: '/chats/send',
		data: {
			content: content,
			id_addresse: id_addresse
		},
		success: function (response) {
			$('.msg_history').append(`
				<div id="${response.timestamp}" class="outgoing_msg mr-3">
					<div class="sent_msg">
						<p>${response.content}</p>
						<span class="time_date">${response.date}</span>
					</div>
				</div>
			`);

			window.location.href = '#' + response.timestamp;

			$('.write_msg').val('');
			$('.write_msg').focus();
		},
		error: function (error) {
			$('body').html(error.responseText);
		}
	});
}

function receive() {
	$.ajax({
		type: 'GET',
		url: '/chats/receive',
		success: function (response) {
			if (response != '') {
				for (var i = response.length - 1; i >= 0; i--) {
					Push.create(response[i].name, {
						body: 'Nuevo mensaje',
						icon: response[i].photo,
						timeout: 40000,
						onClick: function () {
							window.location.href = '/';
							this.close();
						}
					});

					if ($('[data-info=' + response[i].id_sender + ']').length == 0) {
						$('.inbox_chat').prepend(`
							<div onClick="chat_list(this)" class="chat_list" data-user="${response[i].id_sender}" data-name="${response[i].name}" data-photo="${response[i].photo}">
								<div class="chat_people">
									<div class="chat_img">
										<img height="38px" width="38px" src="${response[i].photo}" alt="sunil">
									</div>

									<div class="chat_ib" data-info="${response[i].id_sender}">
										<h5>
											${response[i].name}
										</h5>
									</div>
								</div>
							</div>
						`);
					}

					if ($('[name=id]').val()) {
						if (response[i].id_sender == $('[name=id]').val()) {
							$('.msg_history').append(`
								<div id="${response[i].timestamp}" class="incoming_msg">
									<div class="received_msg">
										<div class="received_withd_msg">
											<p>${response[i].content}</p>
											<span class="time_date">${response[i].date}</span>
										</div>
									</div>
								</div>
							`);

							$.ajax({
								type: 'GET',
								url: '/chats/read/' + $('[name=id]').val(),
								success: function () {

								},
								error: function (error) {
									$('body').html(error.responseText);
								}
							});

							window.location.href = '#' + timestamp;
						}
					}

					if ($('[data-info=' + response[i].id_sender + ']').find('p.text-success').length == 0) {
						$('[data-info=' + response[i].id_sender + ']').append(`
							<p class="text-success">Mensajes sin leer</p>
						`);
					}
				}
			}
		},
		error: function (error) {
			$('body').html(error.responseText);
		}
	});
}

setInterval(function () {
	receive();
}, 1000);

hide = 0;

$('.search-btn').click(function () {
	if (hide == 0) {
		text = $('.search-bar').val();

		if (text == '') {
			return false;
		}

		$(this).html(`
			<i class="fa fa-times" aria-hidden="true"></i>
		`);

		$('.chats').hide();

		$.ajax({
			type: 'GET',
			url: '/chats/users?user=' + text,
			success: function (response) {
				if (response != '') {
					for (var i = response.length - 1; i >= 0; i--) {
						$('.search-chats').append(`
							<div onClick="chat_list(this, 'prepend')" class="chat_list" data-user="${response[i].id}" data-name="${response[i].name}" data-photo="${ (response[i].photo) ? response[i].photo : '/resources/assets/img/app/user.png' }">
								<div class="chat_people">
									<div class="chat_img">
										<img height="38px" width="38px" src="${ (response[i].photo) ? response[i].photo : '/resources/assets/img/app/user.png' }" alt="sunil">
									</div>

									<div class="chat_ib" data-info="${response[i].id}">
										<h5>
											${response[i].name}
										</h5>
									</div>
								</div>
							</div>
						`);
					}
				}
			},
			error: function (error) {
				$('body').html(error.responseText);
			}
		});

		hide = 1;
	} else {
		$(this).html(`
			<i class="fa fa-search" aria-hidden="true"></i>
		`);

		$('.search-chats').empty();
		$('.search-bar').val('');

		$('.chats').show();

		hide = 0;
	}
});


$(function () {
	$.contextMenu({
		selector: '.chat_list',
		callback: function (key, options) {
			$(this).remove();

			id = $(this).attr('data-user');
			open = $('[name=id]').val();

			if (open && id == open) {
				$('.mesgs').empty();
			}

			$.ajax({
				type: 'GET',
				url: '/chats/delete/conversation/' + id,
				success: function (response) {
					window.close;
				},
				error: function (error) {
					$('body').html(error.responseText);
				}
			});
		},
		items: {
			delete: {
				name: 'Eliminar',
			},
		}
	});
});


$(function () {
	$.contextMenu({
		selector: '.outgoing_msg',
		callback: function (key, options) {
			$(this).remove();

			id = $(this).attr('id');

			$.ajax({
				type: 'GET',
				url: '/chats/delete/message/' + id,
				success: function (response) {
					window.close;
				},
				error: function (error) {
					$('body').html(error.responseText);
				}
			});
		},
		items: {
			delete: {
				name: 'Eliminar',
			},
		}
	});
});


$(function () {
	$.contextMenu({
		selector: '.incoming_msg',
		callback: function (key, options) {
			$(this).remove();

			id = $(this).attr('id');

			$.ajax({
				type: 'GET',
				url: '/chats/delete/message/' + id,
				success: function (response) {
					window.close;
				},
				error: function (error) {
					$('body').html(error.responseText);
				}
			});
		},
		items: {
			delete: {
				name: '<i class="fa fa-trash"></i> Eliminar',
			},
		}
	});
});


function close_conversation() {
	$('.chat_list').removeClass('active_chat');
	$('.mesgs').empty();
}

function file() {
	data = new FormData();
	file = $('#file')[0].files[0];
	data.append('file', file);
	data.append('id_addresse', $('[name=id]').val());

	$.ajax({
		type: 'POST',
		url: '/chats/file',
		data: data,
		contentType: false,
        processData: false,
		success: function (response) {
			$('.msg_history').append(`
				<div id="${response.timestamp}" class="outgoing_msg mr-3">
					<div class="sent_msg">
						<p>${response.content}</p>
						<span class="time_date">${response.date}</span>
					</div>
				</div>
			`);

			window.location.href = '#' + response.timestamp;

			$('.write_msg').val('');
			$('.write_msg').focus();
		},
		error: function (error) {
			$('body').html(error.responseText);
		}
	});
}
