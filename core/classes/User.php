<?php

    class User{
        public $db,$userId;

        public function __construct(){
            $db = new  DB;
            $this->db = $db->connect();
            $this->userId = $this->userID();
        }

        public function userID(){
            if(isset($_SESSION['isLoggedIn'])){
                return $_SESSION['user_id'];
            }
        }

        public function emailExist($email){
            $stmt = $this->db->prepare("SELECT * FROM `users` WHERE email = :email");
            $stmt->bindParam(":email",$email,PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function usersList($search){
            $stmt = $this->db->prepare("SELECT * FROM `users` where `username` LIKE ? AND userID != ?");
            $stmt->bindValue(1,$search."%",PDO::PARAM_STR);
            $stmt->bindValue(2, $this->userId,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }