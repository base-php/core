<?php

// Chats
$route->get('/chats', 'Chats@index');
$route->get('/chats/messages/{id}', 'Chats@messages');
$route->post('/chats/send', 'Chats@send');
$route->get('/chats/receive', 'Chats@receive');
$route->get('/chats/read/{id}', 'Chats@read');
$route->get('/chats/users', 'Chats@users');
$route->get('/chats/delete/conversation/{id}', 'Chats@conversation');
$route->get('/chats/delete/message/{timestamp}', 'Chats@message');
$route->post('/chats/file', 'Chats@file');
