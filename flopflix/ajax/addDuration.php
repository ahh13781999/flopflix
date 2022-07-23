<?php
require "../database/conn.php";

if(isset($_POST['videoId']) && isset($_POST['userLoggedIn'])){
	 $videoId = $_POST['videoId'];
	 $username = $_POST['userLoggedIn'];
     $query = $conn->prepare("SELECT * FROM videoprogress WHERE username=:username AND videoId=:videoId");
     $query->bindValue(":username",$username);
     $query->bindValue(":videoId",$videoId);

     $query->execute();

     if($query->rowCount() == 0){
     	$query = $conn->prepare("INSERT INTO videoprogress (username,videoId) VALUES(:username, :videoId)");
        $query->bindValue(":username",$username);
        $query->bindValue(":videoId",$videoId);
     	$query->execute();
     }

}else{
	echo "No videoId or username passed into file";
}




?>