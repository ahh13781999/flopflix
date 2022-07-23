<?php 
class User{
 
    private $conn,$sqlData;

    public function __construct($conn,$username)
    {
    	$this->conn = $conn;

    	$query = $this->conn->prepare("SELECT * FROM users WHERE email=:username");
    	$query->bindValue(":username",$username);
    	$query->execute();

    	$this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getFirstName()
    {
    	return $this->sqlData['firstName'];
    }

    public function getLastName()
    {
    	return $this->sqlData['lastName'];
    }

    public function getEmail()
    {
        return $this->sqlData['email'];
    }

}