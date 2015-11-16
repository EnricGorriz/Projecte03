/* Simple VanillaJS to toggle class */
/*
document.getElementById('toggleProfile').addEventListener('click', function () {
  [].map.call(document.querySelectorAll('.profile'), function(el) {
    el.classList.toggle('profile--open');
  });
}); 		

document.getElementById('toggleProfile').onclick=muestra;
function muestra(){
	alert(this);
	this.className="profile--open";
};*/
function muestra2() {
  [].map.call(document.querySelectorAll('.profile'), function(el) {
    el.classList.toggle('profile--open');
  });
};