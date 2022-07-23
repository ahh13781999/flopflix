<?php 
    require "../database/conn.php";

    if(isset($_POST['videoId']) && isset($_POST['userLoggedIn']) && isset($_POST['progress'])){
       $videoId = $_POST['videoId'];
       $username = $_POST['userLoggedIn'];
       $progress = $_POST['progress'];

       $query = $conn->prepare("UPDATE videoprogress SET progress=:progress, dateModified=NOW() WHERE username=:username AND videoId=:videoId");
       $query->bindValue(":progress",$progress);
       $query->bindValue(":username",$username);
       $query->bindValue(":videoId",$videoId);
       $query->execute();

    }else{
	echo "No videoId or username or progress passed into file";
    }




?>