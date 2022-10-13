(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
     * 

	 */

     $(document).ready(function(){
        $.ajax({
			type: 'POST',
			url: my_account_vars.ajax_url,
			data:{
				'page' : 1,
				'action': my_account_vars.my_subscription.action,
				'nonce': my_account_vars.my_subscription.nonce
			},			
			success: function (data) {
				$('.data-list-paginated').html( data );
			}
		});
    });

    // click item halaman
    $(document).on('click','.page-link',function(e){
		e.preventDefault();
		
		var page = $(this).attr('data-page');

		$.ajax({
			type: 'POST',
			url: my_account_vars.ajax_url,
			data:{
				'page' : page,
				'action': my_account_vars.my_subscription.action,
				'nonce': my_account_vars.my_subscription.nonce
			},
			beforeSend: function() {
				$('.ls-data tr').remove();				
				$('.ls-data').prepend('tr').html('<td colspan="3"> Loading data... </td>');
			},			
			success: function (data) {
				$('.data-list-paginated').html( data );
			}
		});

    });

})( jQuery );
