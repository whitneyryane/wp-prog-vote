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
    
        <?php _e( 'Max Selection', $this->plugin_name ); ?> (2-6)
        
    </label>
                
</th>
                
<td width="50%">

    <span id="rangeVal">
    
        <?php if ( !empty( $max_select ) ) { echo $max_select; } else { echo 3; } ?>
        
    </span>
    
    <input type="range" id="pv_election_max_select" name="pv_election_max_select" min="2" max="6" value="<?php if ( ! empty( $max_select ) ) { echo $max_select; } else { echo 3; } ?>" class="slider" >   
                
</td>

<script type="text/javascript">


( function( $ ) {

	$( '.slider' ).on( 'change', function() {

		$( '#rangeVal' ).html( $( this ).val() );

	} );
	
	// Function that changes visibility of div with additional options depending on selection. 
	$('#pv_election_system').on('change', function(){
		
		var val = $(this).val();
		
		if ( val == 'RCV' && $('#pv_max_select_hold').not(':visible') ){ 
			
			$('#pv_max_select_hold').removeClass('not-visible');
		
		} else if ( val != 'RCV' && $('#pv_max_select_hold').is(':visible') ){ 
			
			$('#pv_max_select_hold').addClass('not-visible');
		
		}
		
		
	});

} ) ( jQuery );

</script>