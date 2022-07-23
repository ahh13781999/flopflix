<?php
class PreviewProvider {

   private $conn;
   private $userEmail;

   public function __construct($conn,$userEmail)
   {
   	 $this->conn = $conn;
   	 $this->userEmail = $userEmail;
   }

   public function createcategoryPreviewVideo($categoryId)
   {                                                              $entitiesArray = EntityProvider::getEntites($this->conn,$categoryId,1);

      if(sizeof($entitiesArray) == 0){
         ErrorMessage::show("No Categories to display");
      }      
      return $this->createVideoPreview($entitiesArray[0]);
   }

   public function createTVShowPreviewVideo()
   {                                                              $entitiesArray = EntityProvider::getTVShowEntites($this->conn,null,1);

      if(sizeof($entitiesArray) == 0){
         ErrorMessage::show("No TV shows to display");
      }      
      return $this->createVideoPreview($entitiesArray[0]);
   }

   public function createMoviesPreviewVideo()
   {                                                              $entitiesArray = EntityProvider::getMoviesEntites($this->conn,null,1);

      if(sizeof($entitiesArray) == 0){
         ErrorMessage::show("No Movies to display");
      }      
      return $this->createVideoPreview($entitiesArray[0]);
   }

   public function createVideoPreview($entity)
   {

   	  if($entity == null){
   	  	 $entity = $this->getRandomEntity();
   	  }

   	  $id = $entity->getAttribute("id");
   	  $name = $entity->getAttribute("name");
   	  $thumbnail = $entity->getAttribute("thumbnail");
   	  $preview = $entity->getAttribute("preview");

      // 
      $videoId = VideoProvider::getEntityVideoForUser($this->conn,$id,$this->userEmail);
      $video = new Video($this->conn,$videoId);
      $video->isMovie();

      $seasonEpisode = $video->getSeasonAndNumber();
      $subHeading = $video->isMovie() ? "" : "<h3 class='text-white text-xl mb-4 font-semibold'>$seasonEpisode</h3>";
      $isProgress = $video->isInProgress($this->userEmail);
      $playButtonText = $isProgress ? "Continue watching" : "Play";
      // 

   	  return "<div class='flex relative'>
				<img id='previewThumbnail' class='hidden w-full h-full' src='$thumbnail'>
				<video onended='previewEnded(this)' id='previewVideo' class='w-full h-full' autoplay muted>
					<source src='$preview' type='video/mp4'>
				</video>
				<div class='w-full h-full absolute bg-gray-500/40'>
				  <div class='relative top-1/3 ml-10 flex flex-col'>
				     <h2 class='text-white text-5xl mx-0 my-5'>$name</h2>
                     $subHeading
				     <div class='flex flex-row items-center gap-x-4'>
				       <button onclick='watchVideo($videoId)' class='bg-gray-900/40 text-white w-56 h-16 font-semibold text-xl rounded hover:bg-white hover:text-gray-800 px-2'><i class='fa-solid fa-play mr-1'></i>$playButtonText</button>
				       <button onclick='volumeToggle(this)' class='bg-gray-900/40 text-white w-48 h-16 font-semibold text-xl rounded hover:bg-white hover:text-gray-800'><i class='fa-solid fa-volume-xmark mr-1'></i>Mute</button>
				     </div>
				  </div>
				</div>
			  </div>";
   }

   public function createEntityProviderSquare($entity)
   {
       $id = $entity->getAttribute('id');
       $name = $entity->getAttribute('name');
       $thumbnail = $entity->getAttribute('thumbnail');

       return "<div class='flex flex-col items-center w-56 gap-y-2 mx-4 shrink-0 mb-4'>
                <a href='entity.php?id=$id'><img src='$thumbnail' class='h-56 w-56 object-cover'/></a>
                <h2 class='text-white font-semibold self-start hover:opacity-70'><a href='entity.php?id=$id'>$name</a></h2>
               </div>";

   }

   public function getRandomEntity()
   {
        $entity = EntityProvider::getEntites($this->conn,null,1);

        return $entity[0];
   }

}

?>