var modalBtns = [...document.querySelectorAll(".ps-button")];
modalBtns.forEach(function(btn){
  btn.onclick = function() {
    var modal = btn.getAttribute('data-modal');
    document.getElementById(modal).style.display = "block";
  }
});

var closeBtns = [...document.querySelectorAll(".ps-close")];
closeBtns.forEach(function(btn){
  btn.onclick = function() {
    var modal = btn.closest('.ps-modal');
    modal.style.display = "none";
  }
});

window.onclick = function(event) {
  if (event.target.className === "ps-modal") {
    event.target.style.display = "none";
  }
}