/* Styles */
import './scss/bytegazette-site.scss';
import './sections/slideshow.js';
import './sections/slider/slider.js';
import Masonry from 'masonry-layout/masonry.js';
import lozad from 'lozad';
import imagesLoaded from 'imagesloaded';

var contentContainer = document.getElementById("content");

// Get the header
var stickies = document.getElementsByClassName("sticktotop");

// Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
window.onscroll = function() {
	const offsetMargin = window.getComputedStyle(document.getElementsByTagName("html")[0]).marginTop;
	var i;

	for ( i=0; i < stickies.length; i++ ) {
		var offset = stickies[i].offsetTop;
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
};

document.addEventListener("DOMContentLoaded", function() {
	const lazyImages = document.querySelectorAll('.lazy');
	const gridElement = document.querySelector('.grid');
	var gridMasonry;

	// Stat masonry on grid if it exists
	if ( gridElement ) {
		gridMasonry = new Masonry( gridElement, {
			itemSelector: '.grid-item',
			columnWidth: '.empty-item'
		});
	}

	// Lazy load images and update masonry
	const observer = lozad(lazyImages, {
		loaded: function( el ) {
			el.classList.add( 'loaded' );

			if ( gridMasonry ) {
				imagesLoaded( gridElement, function() {
					gridMasonry.layout();
				});
				gridMasonry.layout();
			}
		}
	});

	observer.observe();
});

