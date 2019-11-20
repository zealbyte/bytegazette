import './scss/bytegazette-admin.scss';
import jQuery from 'jquery';

jQuery(document).ready( function($) {
	// toggle
	$('.if-js-closed').removeClass('if-js-closed').addClass('closed');

	postboxes.add_postbox_toggles( window.bytegazetteData.hook_suffix );

	// display spinner
	$('#fx-smb-form').submit( function(){
			$('#publishing-action .spinner').css('display','inline');
	});

	// confirm before reset
	$('#delete-action .submitdelete').on('click', function() {
			return confirm('Are you sure want to do this? This will delete everything!');
	});
});
