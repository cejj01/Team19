//Keeps header stuck to top of the screen
window.onscroll = function() {myFunction()};

var header = document.getElementById("headLinks");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > (sticky)) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}

//Shows/Hides notifications tab.
function toggleNotifications(){
    var notifs = document.getElementById("notif_container");
    if (notifs.style.display === "none"){
		document.getElementById("acc_container").style.display = "none";
        notifs.style.display = "block";
    } else {
        notifs.style.display = "none";
    }
}

//Shows/Hides Account drop down
function toggleAccountDrop(){
    var acc = document.getElementById("acc_container");
    if (acc.style.display === "none"){
		document.getElementById("notif_container").style.display = "none";
        acc.style.display = "block";
    } else {
        acc.style.display = "none";
    }
}
