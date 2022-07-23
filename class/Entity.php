<?php

Class Entity{

     private $conn;
     private $entityData;

     public function __construct($conn,$inputEntity)
     {
     	$this->conn = $conn;

     	if(is_array($inputEntity)){
     	   $this->entityData = $inputEntity;
     	}else{
           $query = $this->conn->prepare("SELECT * FROM entities WHERE id=:id");
           $query->bindValue(":id",$inputEntity);
           $query->execute();
           $this->entityData = $query->fetch(PDO::FETCH_ASSOC);
     	}
     }

     public function getAttribute($value)
     {
     	return $this->entityData[$value];
     }

     public function getSeasons()
     {
      $entityId = $this->getAttribute('id');

      $query = $this->conn->prepare("SELECT * FROM videos WHERE entityId=:entityId AND isMovie=0 ORDER BY season, episode ASC");
      $query->bindValue(':entityId',$entityId,PDO::PARAM_INT);
      $query->execute();

      $seasons = array();
      $videos = array();

      $currentSeason = null;

      while($row = $query->fetch(PDO::FETCH_ASSOC)){

          if($currentSeason != null && $currentSeason != $row['season']){
               $seasons[] = new Season($currentSeason, $videos);
               $videos = array();

          }
               $currentSeason = $row["season"];
               $videos[] = new Video($this->conn, $row);

      }

      if(sizeof($videos) != 0){
          $seasons[] = new Season($currentSeason,$videos);
      }
      return $seasons;

     }


}


?>