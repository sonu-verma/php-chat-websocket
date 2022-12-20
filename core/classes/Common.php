<?php
class Common{
    public $db;

    public function __construct(){
       $db = new DB();
       $this->db = $db->connect();
    }

    function redirect($url){
        header("location:".BASE_URL.$url);
    }

    function isLoggedIn(){
        if(!isset($_SESSION['isLoggedIn'])){
            header('location:index.php');
        }
    }

    function logout(){
        $_SESSION =array();
        session_destroy();
        $this->redirect('index.php');
    }

    function user($userId){
        $stmt = $this->db->prepare("SELECT * FROM users WHERE userID = :userId");
        $stmt->bindParam(":userId",$userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    function hashPassword($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }

    function getTableData($table, $fields = array()){
        $where = " WHERE ";
        $sql = "SELECT * FROM {$table}";
        if(isset($fields)){
            foreach($fields as $key => $value){
                $sql .= "{$where} {$key} = :{$key}";
                $where = " AND ";
            }
        }

        $stmt = $this->db->prepare($sql);
        foreach ($fields as $key => $value){
            $stmt->bindValue(":{$key}",$value);
        }
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    function insertData($table, $fields = array()){
        $column = implode(",",array_keys($fields));
        $values = ":".implode(", :",array_keys($fields));

        $sql = "INSERT INTO {$table} ({$column}) VALUES({$values})";
        $stmt = $this->db->prepare($sql);
        foreach($fields as $key => $value){
            $stmt->bindValue(":{$key}",$value);
        }
        $stmt->execute();
        return $this->db->lastInsertId();

    }
}