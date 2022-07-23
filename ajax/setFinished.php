<?php
require "../database/conn.php";

if($_POST['videoId'] && $_POST['userLoggedIn']){
       $videoId = $_POST['videoId'];
       $username = $_POST['userLoggedIn'];

       $query = $conn->prepare("UPDATE videoprogress SET finished=1, dateModified=NOW() WHERE videoId=:videoId AND username=:username");
       $query->bindValue(":videoId",$videoId);
       $query->bindValue("username",$username);
       $query->execute();

}else{
   	echo "No videoId or username passed into file";
}

?>