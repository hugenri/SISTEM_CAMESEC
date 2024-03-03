
function responsive_topnav() {
  var x = document.getElementById("myTopnav");
  if (x.className === "custom-topnav ") {
    x.className += " responsive";
  } else {
    x.className = "custom-topnav ";
  }
}
