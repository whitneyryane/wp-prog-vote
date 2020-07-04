<fieldset>
  	
    <legend class="screen-reader-text">
    
    	<span>
		
			<?php _e( 'Time Format', $this->plugin_name ); ?>
            
       	</span>
        
   	</legend>
    
    <label>
    
    	<input type='radio' name='time_format' value='g:i a' checked='checked' /> 
        
        <span class="date-time-text format-i18n">
        
        	11:16 pm
            
       	</span>
        
        <code>g:i a</code>
        
    </label>
    
    <br />
    
    <label>
    
    	<input type='radio' name='time_format' value='g:i A' /> 
        
        <span class="date-time-text format-i18n">
        
        	11:16 PM
            
      	</span>
        
        <code>g:i A</code>
        
    </label>
    
    <br />
    
    <label>
    
    	<input type='radio' name='time_format' value='H:i' /> 
        
        <span class="date-time-text format-i18n">
        
        	23:16
      	
        </span>
        
        <code>H:i</code>
        
   	</label>
    
    <br />
    
    <label>
    
    	<input type="radio" name="time_format" id="time_format_custom_radio" value="\c\u\s\t\o\m"/> 
        
        <span class="date-time-text date-time-custom-text">
        
        	<?php _e('Custom:', $this->plugin_name ); ?>
            
            <span class="screen-reader-text"> 
			
				<?php _e(' enter a custom time format in the following field', $this->plugin_name ); ?>
                
          	</span>
            
      	</span>
        
  	</label>
    
    <label for="time_format_custom" class="screen-reader-text">
	
		<?php _e(' Custom time format:', $this->plugin_name ); ?>
        
   	</label>
    
    <input type="text" name="time_format_custom" id="time_format_custom" value="g:i a" class="small-text" />
    
    <span class="screen-reader-text">
	
		<?php _e( 'example:', $this->plugin_name ); ?> 
        
  	</span>
    
    <span class="example">11:16 pm</span><span class='spinner'></span>

	<p class='date-time-doc'>
    
    	<a href="https://codex.wordpress.org/Formatting_Date_and_Time"><?php _e( 'Documentation on date and time formatting', $this->plugin_name ); ?></a>.
  	
    </p>
    
</fieldset>