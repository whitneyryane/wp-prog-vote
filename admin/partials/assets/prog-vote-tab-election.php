<form method="post" action="">
	
    <p id="dataReturn"><?php _e( 'To tabulate the election results click on the button below.', 'prog-vote' ); ?></p>
    		
	<input type="hidden" name="election_id" value="'.$post->ID.'" />
				
	<input type="hidden" name="tab_election" value="1" />
					
	<input type="button" value="TABULATE" id="tab_election" style="cursor:pointer;" />
				
</form>

<script type="text/javascript">

(function( $ ) {
	'use strict';

$( '#tab_election' ).on( 'click', function(){
	
	var data = {
			'action': 'tab_election',
			'electionId': <?php echo $post->ID; ?>
		};

		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		jQuery.post(ajaxurl, data, function(response) {
			$('#dataReturn').html(response);
	});
	
	return false;

});


})( jQuery );

</script>