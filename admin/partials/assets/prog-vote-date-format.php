<fieldset>

    <legend class="screen-reader-text">

        <span>

            <?php _e( 'Date Format', $this->plugin_name ); ?>

        </span>

    </legend>

    <label>

        <input type='radio' name='date_format' value='F j, Y' checked='checked' />

        <span class="date-time-text format-i18n">

            May 18, 2017

        </span>

        <code>F j, Y</code>

    </label>

    <br />

    <label>

        <input type='radio' name='date_format' value='Y-m-d' />

        <span class="date-time-text format-i18n">

            2017-05-18

        </span>

        <code>Y-m-d</code>

    </label>

    <br />

    <label>

        <input type='radio' name='date_format' value='m/d/Y' />

        <span class="date-time-text format-i18n">

            05/18/2017

        </span>

        <code>m/d/Y</code>

    </label>

    <br />

    <label>

        <input type='radio' name='date_format' value='d/m/Y' />

        <span class="date-time-text format-i18n">

            18/05/2017

        </span>

        <code>d/m/Y</code>

    </label>

    <br />
   
   <label>

        <input type="radio" name="date_format" id="date_format_custom_radio" value="\c\u\s\t\o\m"/>
     
		<span class="date-time-text date-time-custom-text">
 
            <?php _e( 'Custom:', $this->plugin_name ); ?>

		</span>
        
        <span class="screen-reader-text"> 
            
        	<?php _e( 'enter a custom date format in the following field', $this->plugin_name ); ?>
            
      	</span>
            
    </label>
    
    <label for="date_format_custom" class="screen-reader-text">
    
        <?php _e( 'Custom date format:', $this->plugin_name ); ?>
    
    </label>
    
    <input type="text" name="date_format_custom" id="date_format_custom" value="F j, Y" class="small-text" />
 
    <span class="screen-reader-text">
        
		<?php _e( 'example:', $this->plugin_name ); ?> 
    
    </span>
    
    <span class="example">
    
        May 18, 2017
    
    </span>
    
    <span class='spinner'></span>

</fieldset>