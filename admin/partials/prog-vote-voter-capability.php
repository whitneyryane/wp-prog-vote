<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.ryanwhitney.us
 * @since      1.0.0
 *
 * @package    Prog_Vote
 * @subpackage Prog_Vote/admin/partials
 */

if ( current_user_can( 'edit_user' ) ) {  

		$options = get_option($this->plugin_name, array() );?>

		<h3><?php _e( "Eligible to vote?", $this->plugin_name); ?></h3>

        <table class="form-table">

            <tr>

         		<th>
              	
                	<label for="voter">
					
						<?php _e( "Voter", $this->plugin_name); ?>
                    
              		</label>
                
           		</th>

             	<td>
                
                	<input type="checkbox" name="voter" id="voter" value="1" <?php checked(get_user_meta($user->ID, 'voter', true), true, true); ?> /> &nbsp;
                
                    <span class="description">
                    
                        <?php 
						_e( 'Checking the box will give this user the ability to vote.', $this->plugin_name );
                        
                        if ( user_can( $user, 'vote' ) ) {
							
							echo '&#10003;'; 
							
						} // end if user can vote. ?>
                        
                    </span>
                    
	            </td>
            
    		</tr>
   		
        </table>
          
        <h3>
		
			<?php _e( 'Vote Groups', $this->plugin_name); ?>
            
       	</h3>
        
        <table class="form-table">
        
        	<tr>
            
              	<th>
                
                	<label for="voter_vote_groups">
					
						<?php _e( 'Vote Groups', $this->plugin_name); ?>
                        
                   	</label>
                    
               	</th>
              
              	<td>
                
                	<input type="text" name="voter_vote_groups" id="voter_vote_groups" value="<?php if(get_user_meta($user->ID, 'voter_vote_groups', true)){echo get_user_meta($user->ID, 'voter_vote_groups', true);} ?>" />
                    
                    <strong><?php if ( isset( $options['vote_groups'] ) ) { echo '['.$options['vote_groups'].']'; } else { _e( 'No vote groups set.', $this->plugin_name ); } ?></strong>
                    
                    <br />
                
                	<span class="description">
					
						<?php _e( 'Different groups that can be assigned to voters and elections to limit voting access. These are string values separated by comas (,).', $this->plugin_name); ?>
                        
                  	</span>
            	
                </td>
            
           	</tr>
          
      	</table>
     
		<?php
	    } ?>