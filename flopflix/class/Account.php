<?php

class Account
{
	
	private $conn;

	public function __construct($conn)
	{
		$this->conn = $conn;
	}

   public function updatePassword($oldPassword,$newPassword,$passwordConfirmation,$username)
   {
      $this->validateOldPassword($oldPassword,$username);
      $this->validatePassword($newPassword);
      $this->confirmPassword($newPassword,$passwordConfirmation);
      
     if(empty($_SESSION['error'])){
        $newPassword = hash('sha512', $newPassword);
        $query = $this->conn->prepare("UPDATE users SET password=:password WHERE email=:username");
        $query->bindValue(':username',$username);
        $query->bindValue(':password',$newPassword);
        return $query->execute();

     }
     return false;
   }
   
   public function updateDetails($firstName, $lastName, $email,$username)
   {
   		  $this->validateFirstName($firstName);
		     $this->validateLastName($lastName);
		     if($email !== $username){
             $this->validateNewEmail($email,$username);
           }


           if(empty($_SESSION['error'])){
              $query = $this->conn->prepare("UPDATE users SET firstName=:firstName, lastName=:lastName, email=:email WHERE email=:username");
              $query->bindValue(':firstName',$firstName);
              $query->bindValue(':lastName',$lastName);
              $query->bindValue(':email',$email);
              $query->bindValue(':username',$username);
              $_SESSION['userEmail'] = $email; 
              return $query->execute();

           }
           return false;
   }
    
	public function register($firstName, $lastName, $email, $password, $passwordConfirmation)
	{
		     $this->validateFirstName($firstName);
		     $this->validateLastName($lastName);
		     $this->validateEmail($email);
		     $this->validatePassword($password);
		     $this->confirmPassword($password,$passwordConfirmation);


             if(empty($_SESSION['error'])){
	             $password = hash("sha512", $password);

			     $query = $this->conn->prepare("INSERT INTO users (firstName,lastName,email,password) VALUES (:fn,:ln,:em,:pw)");
			     $query->bindValue(":fn",$firstName);
			     $query->bindValue(":ln",$lastName);
			     $query->bindValue(":em",$email);
			     $query->bindValue(":pw",$password);

			     return $query->execute();
             }

             return false;
	}
    
    public function login($email,$password)
    {
	    $this->validateLoginEmail($email);
	    $this->validatePassword($password);

	    if(empty($_SESSION['error'])){
	    $password = hash('sha512', $password);

    	$query = $this->conn->prepare("SELECT * FROM users WHERE email=:em AND password=:pw");
        $query->bindValue(":em",$email);
        $query->bindValue(":pw",$password);
        $query->execute();
        
        if($query->rowCount() == 1){
            return true;
        }
        array_push($_SESSION['error'],Constants::$loginFailed); 
        return false;
	    }    	
    }

     
    private function validateFirstName($firstName){
    	if(empty($firstName)) return array_push($_SESSION['error'], Constants::$firstNameRequired);
    	if(strlen($firstName) < 3 || strlen($firstName) > 255){
    		return array_push($_SESSION['error'], Constants::$firstNameCharacters);
    	}
    }

     private function validateLastName($lastName){
    	if(empty($lastName)) return array_push($_SESSION['error'], Constants::$lastNameRequired);
    	if(strlen($lastName) < 3 || strlen($lastName) > 255){
    		return array_push($_SESSION['error'], Constants::$lastNameCharacters);
    	}
    }

     private function validateEmail($email){
    	if(empty($email)) return array_push($_SESSION['error'], Constants::$emailRequired);
    	if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    		return array_push($_SESSION['error'], Constants::$emailValid);
    	}
    	$query = $this->conn->prepare("SELECT * FROM users WHERE email=:email");
    	$query->bindValue(":email",$email);
    	$query->execute();

    	if($query->rowCount() != 0){
    		return array_push($_SESSION['error'], Constants::$emailExists);
    	}
    }

    private function validatePassword($password){
    	if(empty($password)) return array_push($_SESSION['error'], Constants::$passwordRequired);
    	if(strlen($password) < 8){
    		return array_push($_SESSION['error'], Constants::$passwordMin);
    	}else if(strlen($password) > 255) {
    		return array_push($_SESSION['error'], Constants::$passwordMax);

    	}
    }

    private function confirmPassword($password, $passwordConfirmation)
    {
       if(empty($password)) return array_push($_SESSION['error'], Constants::$passwordConfirm);
       if($password !== $passwordConfirmation){
    		return array_push($_SESSION['error'], Constants::$passwordMatch);
       }
         
    }

    private function validateLoginEmail($email){
    	if(empty($email)) return array_push($_SESSION['error'], Constants::$emailRequired);
    	if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    		return array_push($_SESSION['error'], Constants::$emailValid);
    	}
       }

   private function validateNewEmail($email){
    	if(empty($email)) return array_push($_SESSION['error'], Constants::$emailRequired);
    	if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    		return array_push($_SESSION['error'], Constants::$emailValid);
    	}
    	$query = $this->conn->prepare("SELECT * FROM users WHERE email=:email");
    	$query->bindValue(":email",$email);
      $query->execute();

    	if($query->rowCount() != 0){
    		return array_push($_SESSION['error'], Constants::$emailExists);
    	}
    }


    private function validateOldPassword($oldPassword,$username)
    {
       $oldPassword = hash('sha512', $oldPassword);
       $query = $this->conn->prepare("SELECT * FROM users WHERE email=:username AND password=:password");
       $query->bindValue(":username",$username);
       $query->bindValue(":password",$oldPassword);
       $query->execute();

       if($query->rowCount() == 0){
         array_push($_SESSION['error'], Constants::$oldPassword);
       }


    }


    public function getError($error)
    {
    	if(in_array($error, $_SESSION['error'])){
    		return "<p class='text-sm text-red-500'>".$error."</p>";
    	}
    }


}