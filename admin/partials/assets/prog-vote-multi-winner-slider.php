<style>
.slidecontainer {

    width: 100%;

}

.slider {

    -webkit-appearance: none;

    width: 100%;

    height: 25px;

    background: #d3d3d3;

    outline: none;

    opacity: 0.7;

    -webkit-transition: .2s;

    transition: opacity .2s;

}

.slider:hover {

    opacity: 1;

}

.slider::-webkit-slider-thumb {

    -webkit-appearance: none;

    appearance: none;

    width: 25px;

    height: 25px;

    background: #4CAF50;

    cursor: pointer;

}

.slider::-moz-range-thumb {

    width: 25px;

    height: 25px;

    background: #4CAF50;

    cursor: pointer;

}

#rangeVal {

	font-weight:bold;

}

</style>

<th width="50%">
                
    <label for="pv_election_max_select">
    
        <?php _e( 'Number of Winners', $this->plugin_name ); echo ' (2-15)';?>
        
    </label>
                
</th>
                
<td width="50%">

    <span id="rangeVal">
    
        <?php if ( !empty( $winner_count ) ) { echo $winner_count; } else { echo 2; } ?>
        
    </span>
    
    <input type="range" id="pv_race_winner_count" name="pv_race_winner_count" min="2" max="15" value="<?php if ( ! empty( $winner_count ) ) { echo $winner_count; } else { echo 2; } ?>" class="slider" >   
                
</td>

<script type="text/javascript">

( function( $ ) {

	$( '.slider' ).on( 'change', function() {

		$( '#rangeVal' ).html( $( this ).val() );

	} );
	
	// Function that changes visibility of div with additional options depending on selection. 
	$('input[name=pv_race_multi_winner]').on('change', function(){
		
		var val = $(this).val();
		
		if ( val == 'yes' && $('#winner_count_hold').not(':visible') ){ 
			
			$('#winner_count_hold').removeClass('not-visible');
		
		} else if ( val != 'yes' && $('#winner_count_hold').is(':visible') ){ 
			
			$('#winner_count_hold').addClass('not-visible');
		
		}
		
		
	});

} ) ( jQuery );

</script>