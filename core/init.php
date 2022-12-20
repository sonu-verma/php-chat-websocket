<?php
session_start();

require 'classes/DB.php';
require 'classes/User.php';
require 'classes/Messenger.php';
require 'classes/Common.php';

$userObj = new User();
$commonObj = new Common();
$messengerObj = new Messenger();

$userData = $commonObj->user($userObj->userId);
define("BASE_URL",'http://localhost/RnD/php-chat-websocket/');