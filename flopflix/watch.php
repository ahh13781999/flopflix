<?php

$hideNavBar = true;

require "./includes/header.php";


if (isset($_GET['id'])) {
	$videoId = $_GET['id'];
	$video = new Video($conn, $videoId);
	$video->incrementViews();
	$upNextVideo = VideoProvider::getUpNext($conn, $video);
} else {
	ErrorMessage::show('no id passed into page');
}

?>
<div class="flex flex-col bg-[#141414] h-full">
	<div class="w-full h-full relative">
		<div id="videoNavbar" class="absolute top-0 left-0 w-full z-30 flex flex-row items-center bg-black/30">
			<button onclick="window.history.back()" class="text-white text-3xl p-6 cursor-pointer"><i class="fas fa-arrow-left bg-transparent"></i></button>
			<h1 class="text-3xl text-white font-semibold"><?= $video->getAttribute('title') ?></h1>
		</div>
		<div id="upNext" class="hidden flex flex-row items-center justify-center text-white top-1/2  left-1/2 absolute z-20 -translate-x-1/2 -translate-y-1/2">
			<button onclick="resetVideo()" class="text-5xl font-semibold p-6"><i class="fas fa-redo"></i></button>	
		    <div class="flex flex-col items-center justify-center gap-y-4">
				<h2 class="text-xl md:text-3xl font-semibold">Up Next:</h2>
				<h3 class="text-xl md:text-2xl"><?= $upNextVideo->getAttribute('title'); ?></h3>
				<h3 class="text-base md:text-xl"><?= $upNextVideo->getSeasonAndNumber() ?></h3>
				<button onclick="watchVideo(<?= $upNextVideo->getAttribute('id') ?>)" class="p-0 text-2xl md:text-5xl font-semibold">
					<i class="fas fa-play mr-1"></i>Play
				</button>
			</div>
	    </div>
		<video id="videoPlayer" class="w-full h-full" controls autoplay="">
			<source src="<?= $video->getAttribute('filePath') ?>" type="video/mp4">
		</video>
	</div>
</div>
</main>
<script type="text/javascript" src="./src/script.js"></script>
<script type="text/javascript">initVideo("<?php echo $video->getAttribute('id'); ?>","<?php echo $_SESSION['userEmail'] ?>")</script>
</body>

</html>