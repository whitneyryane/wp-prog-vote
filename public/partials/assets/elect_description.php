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
	
<div id="description">
    
    <table>

        <tr>
        
            <th>
			
				<?php _e( 'ELECTION DESCRIPTION', $this->plugin_name ); ?>
                
          	</th>
        
        </tr>
        
        <tr>
        
            <td>
			
				<?php echo get_post_field( 'post_content', $atts['id'] ); ?>
                
          	</td>

        </tr>
        
    </table>
        
</div>

<br />