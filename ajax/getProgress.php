<?php

require "../database/conn.php";

if(isset($_POST['videoId']) && isset($_POST['userLoggedIn'])){
	 $videoId = $_POST['videoId'];
	 $username = $_POST['userLoggedIn'];
     $query = $conn->prepare("SELECT progress FROM videoprogress WHERE username=:username AND videoId=:videoId");
     $query->bindValue(":username",$username);
     $query->bindValue(":videoId",$videoId);

     $query->execute();

     echo $query->fetchColumn();

 }else{
 		echo "No videoId or username passed into file";
 }



?>