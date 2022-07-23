<?php


try{
      $conn = new PDO("mysql:host=localhost;dbname=php_js","root","");
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch(PDOException $e){
          echo $e->getMessage();
}








?>