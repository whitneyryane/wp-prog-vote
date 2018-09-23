(function( $ ) {
	'use strict';
	 $( window ).load(function() {
		 
 		// Function that changes visibility of div with additional options depending on selection. 
	 	$('#prog-vote-default_voting').on('change', function(){
			
			var val = $(this).val();
			
			var el = $('.voting_defaults.visible-block').attr('id');
			
			if ( el != val+'_defaults_hold'){ 
				
				$('#'+el).removeClass('visible-block').addClass('not-visible');

				$('#'+val+'_defaults_hold').removeClass('not-visible').addClass('visible-block');
			
			}
			
		});
		
		//Function which randomly generates encryption key on button press.
		function keyGen(len){
    		var key = " ";

    		var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-={}[];:?/.,><~`";

    		for( var i=0; i < len; i++ )
        		
				key += charset.charAt(Math.floor(Math.random() * charset.length));

    		return key;
		}
		
		// Outputs random encryption key when button is pushed.
		$('#generate-key').on('click', function(){ 
		
			var ranKey = keyGen($(this).data('length'));
		
			$('#prog-vote-encryption').val(ranKey);
			
			return false;
		
		});
	 
	});

})( jQuery );
