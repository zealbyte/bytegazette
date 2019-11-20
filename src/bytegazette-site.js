/* Styles */
import './scss/bytegazette-site.scss';
import './sections/slideshow.js';

var contentContainer = document.getElementById("content");

// Get the header
var stickies = document.getElementsByClassName("sticktotop");

// Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {
	var i;

	for ( i=0; i < stickies.length; i++ ) {
		var offset = stickies[i].offsetTop;
		var offsetMargin = window.getComputedStyle(document.getElementsByTagName("html")[0]).marginTop;
		var contentPadding = stickies[i].offsetHeight;

		if (window.pageYOffset > offset) {
			stickies[i].style.position = "fixed";
			stickies[i].style.top = offsetMargin;
			stickies[i].classList.add("stuck");
			contentContainer.style.paddingTop = ( parseInt(contentPadding, 10) ) + "px";
		} else {
			stickies[i].removeAttribute("style");
			stickies[i].classList.remove("stuck");
			contentContainer.removeAttribute("style");
		}
	}
}

// When the user scrolls the page, execute myFunction
window.onscroll = function() {
	myFunction()
};
