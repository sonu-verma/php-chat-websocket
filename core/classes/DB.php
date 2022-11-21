<?php

class DB{
    function connect(){
        $db = new PDO("mysql:host=localhost;db-name:php-chat-websocket","root","");
        return $db;
    }
}