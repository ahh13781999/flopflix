<?php
Class Video{

private $conn;
private $entityData;
private $entity;

public function __construct($conn,$inputEntity)
{
	$this->conn = $conn;

	if(is_array($inputEntity)){
		$this->entityData = $inputEntity;
	}else{
		$query = $this->conn->prepare("SELECT * FROM videos WHERE id=:id");
		$query->bindValue(':id',$inputEntity);
		$query->execute();
		$this->entityData = $query->fetch(PDO::FETCH_ASSOC);

	}
	$this->entity = new Entity($conn, $this->entityData['entityId']);
}

public function getAttribute($value)
{
	return $this->entityData[$value];
}

public function getThumbnail()
{
	return $this->entity->getAttribute("thumbnail");
}

public function getSeasonAndNumber()
{
	if($this->isMovie()){
      return;
	}
	$season = $this->getAttribute('season');
	$episode = $this->getAttribute('episode');

	return "Season $season, Episode $episode";
}

public function isMovie()
{
	return $this->getAttribute('isMovie') == 1;
}

public function incrementViews()
{
	$query = $this->conn->prepare("UPDATE videos SET views = views + 1 WHERE id=:id");
	$query->bindValue(":id",$this->getAttribute('id'));
    $query->execute();
}

public function isInProgress($username)
{
	$query =  $this->conn->prepare("SELECT id FROM videoprogress WHERE videoId = :videoId 
		AND username = :username
		AND finished = 0");
	$query->bindValue(":videoId",$this->getAttribute("id"));
	$query->bindValue(":username",$username);
	$query->execute();
	return $query->rowCount() != 0;
}

public function hasSeen($username)
{
	$query = $this->conn->prepare("SELECT id FROM videoprogress WHERE videoId = :videoId 
		AND username = :username
		AND finished = 1");

	$query->bindValue(":videoId",$this->getAttribute("id"));
	$query->bindValue(":username",$username);
	$query->execute();
	return $query->rowCount() != 0;
}

}
?>