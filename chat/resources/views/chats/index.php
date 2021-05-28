<div class="container-fluid">
	<div class="messaging">
		<div class="inbox_msg">
			<div class="inbox_people">
				<div class="headind_srch">
					<div class="recent_heading">
						<h4>Recientes</h4>
					</div>

					<div class="srch_bar">
						<div class="stylish-input-group">
							<input type="text" class="search-bar" placeholder="Buscar">
							<span class="input-group-addon">
								<button type="button" class="search-btn">
									<i class="fa fa-search" aria-hidden="true"></i>
								</button>
							</span>
						</div>
					</div>
				</div>

				<div class="inbox_chat">
					<div class="search-chats"></div>

					<div class="chats">
						<?php if (conversations()): ?>
							<?php foreach (conversations() as $conversation): ?>
								<div onClick="chat_list(this)" class="chat_list" data-user="<?php echo $conversation['id']; ?>" data-name="<?php echo $conversation['name'] ?>" data-photo="<?php echo $conversation['photo']; ?>">
									<div class="chat_people">
										<div class="chat_img">
											<img height="38px" width="38px" src="<?php echo $conversation['photo']; ?>" alt="sunil">
										</div>

										<div class="chat_ib" data-info="<?php echo $conversation['id']; ?>">
											<h5>
												<?php echo $conversation['name']; ?>
											</h5>

											<?php if ($conversation['read'] == 0 && $conversation['sender'] != logged('id')): ?>
												<p class="text-success">Mensajes sin leer</p>
											<?php endif; ?>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<div class="mesgs">
			</div>
		</div>
	</div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.css">
<link rel="stylesheet" href="<?php asset('css/chat.css'); ?>">

<script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.12/push.js"></script>
<script src="<?php asset('js/chat.js'); ?>"></script>
