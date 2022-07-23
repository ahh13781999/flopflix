<?php  

class VideoProvider{

     public static function getUpNext($conn,$currentVideo)
     {
     	$query = $conn->prepare("SELECT * FROM videos 
     		WHERE entityId=:entityId 
     		AND id!=:videoId 
     		AND (
     		      (season = :season AND episode > :episode)
     		      OR season > :season
     		    )
     		ORDER BY season, episode ASC LIMIT 1");
     	$entityId = $currentVideo->getAttribute('entityId');
     	$videoId = $currentVideo->getAttribute('id');
     	$season = $currentVideo->getAttribute('season');
     	$episode = $currentVideo->getAttribute('episode');
     	$query->bindValue(":entityId",$entityId);
     	$query->bindValue(":videoId",$videoId);
     	$query->bindValue(":season",$season);
     	$query->bindValue(":episode",$episode);
     	$query->execute();
          
          if($query->rowCount() == 0){
               $query = $conn->prepare("SELECT * FROM videos 
                                       WHERE season <= 1 AND   episode <= 1 AND 
                                             id != :videoId
                                             ORDER BY views DESC LIMIT 1");
          $videoId = $currentVideo->getAttribute('id');
          $query->bindValue(":videoId",$videoId);
          $query->execute();
          }          
          $row = $query->fetch(PDO::FETCH_ASSOC);
          return new Video($conn,$row);
     }

     public static function getEntityVideoForUser($conn, $entityId, $username)
     {
          $query = $conn->prepare("SELECT videoId FROM `videoprogress` INNER JOIN videos 
               ON videoprogress.videoId = videos.id 
               WHERE videos.entityId = :entityId 
               AND videoprogress.username = :username 
               ORDER BY videoprogress.dateModified DESC 
               LIMIT 1 ");
          $query->bindValue(":entityId",$entityId);
          $query->bindValue(":username",$username);
          $query->execute();

          if($query->rowCount() == 0){
               $query = $conn->prepare("SELECT id FROM videos WHERE entityId = :entityId
                    ORDER BY season, episode ASC LIMIT 1");
               $query->bindValue(":entityId",$entityId);
               $query->execute();
          }
       return $query->fetchColumn();
     }
}

?>