<fieldset>

	<legend>
    
    	<h4>
		
			<?php _e( 'Defaults for Approval', $this->plugin_name ); ?>
            
      	</h4>
        
   	</legend>

	<input type="number" name="<?php echo $this->plugin_name; ?>[approval_min]" id="<?php echo $this->plugin_name; ?>-approval_min" value="<?php if ( !empty( $approval_min ) ) { echo $approval_min; } else { echo 2; } ?>" min="2" max="40">
    
    <label for="<?php echo $this->plugin_name; ?>-approval_min">&nbsp;<?php _e( 'Min Selection', $this->plugin_name ); ?></label>

	<br />

	<input type="number" name="<?php echo $this->plugin_name; ?>[approval_max]" id="<?php echo $this->plugin_name; ?>-approval_max" value="<?php if ( !empty( $approval_max ) ) { echo $approval_max; } else { echo 12; } ?>" min="2" max="40">
    
    <label for="<?php echo $this->plugin_name; ?>-approval_max">&nbsp;<?php _e( 'Max Selection', $this->plugin_name ); ?></label>

</fieldset>