<?php 
Class Auth {

public static function userLogedIn()
{
   if(isset($_SESSION['userEmail'])){
    header("Location: index.php");
   }else{
    header("Location: login.php");
   }
}
}
?>