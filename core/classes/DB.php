<?php

class DB{
    function connect(){

        try{
            $db = new PDO("mysql:host=127.0.0.1;dbname=php-chat-websocket","root","");
            return $db;
        }catch (PDOException $exception){
            die('database not connected: '.$exception->getMessage());
        }

    }
}