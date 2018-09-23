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

<fieldset>

	<legend>
    
    	<h4>
		
			<?php _e( 'Defaults for Ranked Choice', $this->plugin_name ); ?>
            
      	</h4>
        
   	</legend>
	
    <input type="hidden" name="<?php echo $this->plugin_name; ?>[ranked_min]" value="2" id="<?php echo $this->plugin_name; ?>-ranked_min" />
  
  	<div>
    
    	<span id="rangeVal">
		
			<?php if ( !empty( $ranked_max ) ) { echo $ranked_max; } else { echo 3; } ?>
            
       	</span>
        
        <input type="range" name="<?php echo $this->plugin_name; ?>[ranked_max]" min="2" max="6" value="<?php if ( !empty( $ranked_max ) ) { echo $ranked_max; } else { echo 3; } ?>" class="slider" id="<?php echo $this->plugin_name; ?>-ranked_max">
        
        <label for="<?php echo $this->plugin_name; ?>-ranked_max">&nbsp;<?php _e('Max Rankings', $this->plugin_name); ?></label>
        
  	</div>

</fieldset>

<script type="text/javascript">

( function( $ ) {

	$( '.slider' ).on( 'change', function() {

		$( '#rangeVal' ).html( $( this ).val() );

	} );

} ) ( jQuery );

</script>