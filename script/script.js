let a = document.getElementById('myphoto');

a.onclick = function myPhoto() {
  let x = document.getElementById("menu");

  if (x.className == "menu") {
    x.className += " active";
  } else {
    x.className = "menu";
  }
};
