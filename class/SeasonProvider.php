<?php
Class SeasonProvider{

	private $conn;
	private $userEmail;

   public function __construct($conn,$userEmail)
   {
   	 $this->conn = $conn;
   	 $this->userEmail = $userEmail;
   }


   public function create($entity)
   {
     $seasons = $entity->getSeasons();   	
     if(sizeof($seasons) == 0){
      return;
     }

     $seasonsHtml = "";
     foreach ($seasons as $season) {
       $seasonNumber = $season->getSeasonNumber();

       $videosHtml = "";
 
      foreach ($season->getVideos() as $video) {
        $videosHtml .= $this->createVideoSquare($video);
      }

       $seasonsHtml .= "<div class='flex flex-col gap-y-4 my-10'>
                           <h3 class='text-white text-2xl font-semibold ml-4 mb-4'>Season $seasonNumber</h3>
                             <div class='flex flex-row overflow-x-scroll px-4'>
                                $videosHtml
                             </div>
                        </div>";
     }

     return $seasonsHtml;
   }

   private function createVideoSquare($video)
   {
     $id = $video->getAttribute('id');
     $thumbnail = $video->getThumbnail();
     $title = $video->getAttribute('title');
     $description = $video->getAttribute('description');
     $episodeNumber = $video->getAttribute('episode');
     $hasSeen = $video->hasSeen($this->userEmail) ? "<i class='fas fa-check-circle absolute text-xl text-green-400 top-0 left-0'></i>" : "";

       return "<div class='flex flex-col items-center w-56 gap-y-2 mx-4 shrink-0 mb-4'>
                <a class='relative' href='watch.php?id=$id'>
                <img src='$thumbnail' class='h-56 w-56 object-cover'/>
                 $hasSeen
                </a>
                <div class='flex flex-col gap-y-2'>
                <h2 class='text-white font-semibold self-start hover:opacity-70'><a href='watch.php?id=$id'>$title</a></h2>
                 <p class='text-white'>$description</p>
                </div>
               </div>";
   }

}
?>