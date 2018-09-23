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

<div id="instructions">
    
    <table>

        <tr>

            <th>
			
				<?php _e( 'VOTING INSTRUCTIONS', $this->plugin_name ); ?>
                
           	</th>

        </tr>
        
        <tr>
            
            <td>
            
            	<img src="<?php echo plugin_dir_url( __FILE__ );?>Img/CakeVote.jpg" width="300" style="margin-right:30px;" alt="RCV Example" align="left" />
                
                <p>
                
                <ol>
                
                <li><?php _e( 'Select "1st" next to the choice you most prefer (Your first choice).', $this->plugin_name ); ?></li>
                
                <li><?php _e( 'Rank backup choices in order of preference ("2nd" for second choice, "3rd" for third, ect).', $this->plugin_name ); ?></li>
                
                <li><?php _e( 'You may only select one choice per number and only one number per choice.', $this->plugin_name ); ?></li>
                
                <li><?php _e( 'You can select as few choices as you like.', $this->plugin_name ); ?></li>
                
                </ol>
                
                </p>
                
           	</td>

        </tr>
        
    </table>
    
</div>