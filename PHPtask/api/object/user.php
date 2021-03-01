<?php
class User{
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $password;
 
    public function __construct($db){
        $this->conn = $db;
    }
    // signup user
    function signup(){
    
        if($this->isAlreadyExist()){
            return false;
        }
        // query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    username=:username, password=:password";
    
        $stmt = $this->conn->prepare($query);
    
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->password=htmlspecialchars(strip_tags($this->password));

    
        // bind values
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);

    
        // execute query
        if($stmt->execute()){
            $this->id = $this->conn->lastInsertId();
            return true;
        }
    
        return false;
        
    }
    // login user
    function login(){
        // select all query
        $query = "SELECT
                    `id`, `username`, `password`
                FROM
                    " . $this->table_name . " 
                WHERE
                    username='".$this->username."' AND password='".$this->password."'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function isAlreadyExist(){
        $query = "SELECT *
            FROM
                " . $this->table_name . " 
            WHERE
                username='".$this->username."'";
        
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return true;
        }
        else{
            return false;
        }
    }
}