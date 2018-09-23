<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://www.ryanwhitney.us
 * @since      1.0.0
 *
 * @package    Prog_Vote
 * @subpackage Prog_Vote/public/partials/assets
 */
?>	
	
<div id="verifyContain">
	
	<div id="verifyPack">
		
        <div id="verifyBox">
		
        </div>

		<div id="verifyButtons">
	
    		<input type="button" id="confirm" value="<?php _e( 'CONFIRM', $this->plugin_name ); ?>" />
    	
    	    <input type="button" id="edit" style="background:#F00;" value="<?php _e( 'EDIT', $this->plugin_name ); ?>" />
	
    	</div>
	
    </div>
    
</div>

<script type="text/javascript">

( function( $ ) {
	
	var data = Array();
	
	$( 'input[type=radio]' ).css( { 'position': 'fixed', 'left': '-9999px', 'opacity': '0' } );
	
	// selects the label for the radio input and changes its color 
	$( 'input[type=radio]' ).on( 'click', function () {	

		var id = $( this ).attr( 'id' );

		var name = $( this ).attr( 'name' );

		var val = $( this ).val();

		var checked = $( 'input[value="'+val+'"]:checked' );

		var input = $( 'input[value="'+val+'"]' );
		
		
		
		if ( checked.length > 1 ) {
		
			$( this ).removeAttr( 'checked' );
		
			input.attr( 'checked', false );
		
			$( this ).attr( 'checked', 'checked' );
		
		}
		
		if ( $( 'label[for="'+id+'"]' ).hasClass( 'rankhover' ) ) { 
		
			$( this ).removeAttr( 'checked' );
		
			input.attr( 'checked', false );

			$( 'label[for="'+id+'"]' ).removeClass( 'rankhover' );
		
		} else {

			$( '.label'+val+'' ).removeClass( 'rankhover' );

			$( '.name'+name+'' ).removeClass( 'rankhover' );

			$( 'label[for="'+id+'"]' ).addClass( 'rankhover' );
		
		}

	} ); // click on raido
	
	// collects the data from the selected inputs and displays it for confirmation by voter.
	$( '#process' ).on( 'click', function() {

		var container = $( '#verifyContain' );

		var box = $( '#verifyBox' );

		var input = $( 'input:checked' );

		var a = Array();

		input.each( function( index ) {

			a[index] = [

				[$( this ).parents( 'table' ).data( 'race' )+$( this ).data( 'rank' )],

				[$( this ).parents( 'table' ).data( 'race' )],

				[$( this ).data( 'rank' )],

				[$( this ).data( 'candidate' )],

				[$( this ).data( 'voting' )]

			];
			
		} );

		a.sort( compareFirstColumn );

		function compareFirstColumn( a, b ) {

			if ( a[0] === b[0] ) {
				
				return 0;

			} else {
				
				return ( a[0] < b[0] ) ? -1 : 1;

			}

		}

		box.append( verifyData( a ) );

		$( '#verifyContain' ).show();

		$( '#ballot' ).hide();

		$( 'footer' ).hide();

		$( 'header' ).hide();
		
		return false;

	} ); // end process

	$( '#edit' ).on( 'click', function() {

		$( '#ballot' ).show();

		$( 'footer' ).show();

		$( 'header' ).show();

		$( '#verifyContain' ).hide();

		$( '#confirm' ).show();

		$( '#verifyBox' ).empty();
		
		return false;

	} ); // click on #edit

	$( '#clear' ).on( 'click', function() {

		$( 'input' ).removeAttr( 'checked' );

		$( 'input' ).attr( 'checked', false );

		$( 'label' ).removeClass( 'rankhover' );
		
		return false;

	} ); // click on #clear

	$( '#confirm' ).on( 'click', function() {
		
		$( 'input[name="verifiedVote"]' ).val( '1' );
		
		$( 'form#voteForm' ).submit();

	} ); // click on #confirm

	function verifyData( a ) {
		
		var html = '<h3><?php _e( 'Please verify your vote.', $this->plugin_name ); ?></h3>';
		
		html +=	'<p><?php _e( 'If there are any errors in your vote, click <strong>EDIT</strong>, otherwise click <strong>CONFIRM</strong>.', $this->plugin_name); ?></p>';
		
		html += '<table>';

		if ( a.length > 0 ) {

			var race = [];

			$.each( a, function( index, value ) {

				if ( $.inArray( value[1].toString(), race ) === -1 ) {
					
					html += '<tr class="lined"><th colspan="2">'+value[1]+'</th></tr>';
					
					if ( value[4] == '<?php _e( 'Plurality Voting', $this->plugin_name ); ?>' ) {
					
					} else {
					
						html += '<tr class="lined"><td><em><?php _e( 'Rank', $this->plugin_name ); ?></em></td><td><em><?php _e( 'Candidate', $this->plugin_name ); ?></em></td></tr>';
					
					}
				
					race.push( value[1].toString() );
					
				}
				
				if ( value[4] == '<?php _e( 'Plurality Voting', $this->plugin_name ); ?>' ) {
					
					html += '<tr><td colspan="2">&#10004; '+value[3]+'</td></tr>';	
			
				} else {
					
					html += '<tr><td><strong>'+value[2]+'</strong></td><td>'+value[3]+'</td></tr>';	
			
				}
				
			} );
		
		} else {
			
			html += '<tr><td><?php _e( 'NO DATA HAS BEEN SUBMITTED', $this->plugin_name ); ?></td></tr>';

			$( '#confirm' ).hide();
		
		}

		html += '</table>';

		return html;
	} // end verifyData

} )( jQuery );

</script>