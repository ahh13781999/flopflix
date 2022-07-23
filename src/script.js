function volumeToggle(button) {
  var volume = document.getElementById("previewVideo");
  volume.muted = !volume.muted;
  if (volume.muted == true) {
    button.firstElementChild.classList.remove("fa-volume-up");
    button.firstElementChild.classList.add("fa-volume-xmark");
  } else {
    button.firstElementChild.classList.remove("fa-volume-xmark");
    button.firstElementChild.classList.add("fa-volume-up");
  }
}

function previewEnded(video) {
  video.classList.add("hidden");
  document.getElementById("previewThumbnail").classList.remove("hidden");
}

function initVideo(videoId, userLoggedIn) {
        setStartTime(videoId, userLoggedIn);
        updateProgressTimer(videoId, userLoggedIn);
}

function updateProgressTimer(videoId, userLoggedIn) {
  addDuration(videoId, userLoggedIn)
  var timer;
  document.getElementById("videoPlayer").onplay = (event) => {

    timer = setInterval(() => updateProgress(videoId, userLoggedIn, event.target.currentTime),3000);
  }
  document.getElementById("videoPlayer").onended = () => {
    document.getElementById("upNext").classList.remove("hidden");
    setFinished(videoId, userLoggedIn);
    clearInterval(timer);
  }
}

function addDuration(videoId, userLoggedIn) {
  var r = new XMLHttpRequest(); 
  r.open("POST", "ajax/addDuration.php", true);
  r.setRequestHeader("Content-type", "application/x-www-form-urlencoded charset=UTF-8");
  r.onreadystatechange = function () {
    if (r.readyState != 4 || r.status != 200) return; 
    console.log(r.responseText);
  };
  r.send("videoId="+videoId+"&userLoggedIn="+userLoggedIn);
   
}

function updateProgress(videoId, userLoggedIn, progress) {

   var xhttp = new XMLHttpRequest();
   xhttp.open("POST", "ajax/updateDuration.php", true);
   xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded charset=UTF-8");
   xhttp.onreadystatechange = function() {
    if(xhttp.readyState != 4 || xhttp.status != 200) return;
    console.log(xhttp.responseText);
   }; 
   xhttp.send("videoId="+videoId+"&userLoggedIn="+userLoggedIn+"&progress="+progress);
}


function setFinished(videoId, userLoggedIn) {
 
  var sf = new XMLHttpRequest();
  sf.open("POST", "ajax/setFinished.php", true);
  sf.setRequestHeader("Content-type", "application/x-www-form-urlencoded charset=UTF-8");
  sf.onreadystatechange = function() {
    if(sf.readyState != 4 || sf.status != 200) return;
    console.log(sf.responseText);
  };
  sf.send("videoId="+videoId+"&userLoggedIn="+userLoggedIn);
}

function setStartTime(videoId, userLoggedIn) {
 
 var gp = new XMLHttpRequest();
 gp.open("POST","ajax/getProgress.php",true);
 gp.setRequestHeader("Content-type", "application/x-www-form-urlencoded charset=UTF-8");
 gp.onreadystatechange = function(){
  if(gp.readyState != 4 || gp.status != 200){
   return;
   console.log(gp.responseText); 
   }else{
  
     const videoPlayer = document.getElementById("videoPlayer");
       videoPlayer.addEventListener("canplay", function(){
       videoPlayer.currentTime = gp.responseText;      
      },{
        once: true
      });

  }
};
 gp.send("videoId="+videoId+"&userLoggedIn="+userLoggedIn);

}

function resetVideo() {
 
  const video = document.getElementById("videoPlayer");
  video.currentTime = 0;
  video.play();
  document.getElementById("upNext").classList.add("hidden");

}

function watchVideo(videoId) {
  location.href = "watch.php?id=" + videoId;
}



function scrollNavBar() {
   var navBar = document.getElementById("topBar");
   if(document.documentElement.scrollTop > navBar.offsetHeight){
     navBar.classList.add("bg-[#141414]");
   }else{
    navBar.classList.remove("bg-[#141414]");
   }
}


var searchTimer;

function searchInputFun(input,username) {
   clearTimeout(searchTimer);
   searchTimer = setTimeout( () => {
     var term = input.value
     if(term != ""){
        var xsearch = new XMLHttpRequest();
        xsearch.open("POST","ajax/getSearchResults.php",true);
        xsearch.setRequestHeader("Content-type", "application/x-www-form-urlencoded charset=UTF-8");
        xsearch.onreadystatechange = (() => {
          if(xsearch.readyState != 4 || xsearch.status != 200) return;
            document.getElementById("results").innerHTML = xsearch.responseText ;
        });
        xsearch.send(`term=${term}&username=${username}`);
     }else{

     } 
   },500)
}