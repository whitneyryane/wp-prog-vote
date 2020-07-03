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
?>

<div class="wrap">
	
	<h1>
	
    	<?php echo esc_html( get_admin_page_title() ); ?>
   	
    </h1>

	<form method="post" name="prog-vote-settings" action="options.php">
    
		<?php
        //Grab all options
        $options = get_option( $this->plugin_name ); 
            
		// Default Settings
		$org_name = $options['org_name'];
		
		$org_email = $options['org_email'];
		
		$encryption = $options['encryption'];
		
		if ( isset( $options['default_voting'] ) ) {
			
			$default_voting = $options['default_voting'];
		
		} else {
			
			$default_voting = 'RCV';
		
		}
		
		$ranked_min = $options['ranked_min'];
		
		$ranked_max = $options['ranked_max'];
		
		$approval_min = $options['approval_min'];
		
		$approval_max = $options['approval_max'];
		
		$multi_winner = $options['multi_winner'];
		
		$vote_groups = $options['vote_groups'];
		 
		settings_fields( $this->plugin_name );
		
		do_settings_sections( $this->plugin_name ); ?>
    
		<table class="form-table">
        
			<tr>
				
                <th scope="row">
                
                	<label for="<?php echo $this->plugin_name; ?>-org_name">
					
						<?php _e( 'Organization Name', $this->plugin_name ); ?>
                        
                 	</label>
                    
              	</th>
				
               	<td>
                
                	<input name="<?php echo $this->plugin_name; ?>[org_name]" type="text" id="<?php echo $this->plugin_name; ?>-org_name" value="<?php if ( !empty( $org_name ) ) { echo $org_name; } ?>" class="regular-text" />
                    
               	</td>
			
            </tr>
		
        	<tr>
			
            	<th scope="row">
                
                	<label for="<?php echo $this->plugin_name; ?>-org_email">
					
						<?php _e( 'Organization Email', $this->plugin_name ); ?>
                        
                 	</label>
                    
              	</th>
				
                <td>
                
                	<input name="<?php echo $this->plugin_name; ?>[org_email]" type="email" id="<?php echo $this->plugin_name; ?>-org_email" aria-describedby="org_email-decription" value="<?php if ( !empty( $org_email ) ) { echo $org_email; } ?>" class="regular-text" />
                 
                    <p class="description" id="org_email-decription">
                 
                        <?php _e( 'The email that you provide will recieve all updates to the elections and the final results.', $this->plugin_name ); ?>
                 
                    </p>
   
               	</td>
	
    		</tr>
		
        	<tr>
	
    			<th scope="row">
                
                	<label for="<?php echo $this->plugin_name; ?>-encryption">
					
						<?php _e( 'Encryption Key', $this->plugin_name ); ?>
                        
                  	</label>
                    
              	</th>
	
    			<td>
                
                	<input name="<?php echo $this->plugin_name; ?>[encryption]" type="text" id="<?php echo $this->plugin_name; ?>-encryption" aria-describedby="encryption-decription" value="<?php if ( !empty( $encryption ) ) { echo $encryption; } ?>" class="regular-text code" maxlength="32" />
                    
                    <button data-length="32" id="generate-key">
					
						<?php _e( 'Generate Key', $this->plugin_name ); ?>
                        
                   	</button>
                    
                    <p class="description" id="encryption-decription">
                    
                        <?php _e( 'Please enter 32 random characters. The charaters can include all numbers(0-9), upper and lowercase letters(A-Z, a-z), and many special characters(`~!@#$%^&*()_-=+[]{};,./?\|).', $this->plugin_name ); ?>
 
                    </p>
 
                </td>

			</tr>
            			
            <tr>

				<th scope="row">
                
                	<label for="<?php echo $this->plugin_name; ?>-default_voting">
					
						<?php _e( 'Default Voting Method', $this->plugin_name ); ?>
                
                	</label>
                
                </th>
                
				<td>
                	
                    <select name="<?php echo $this->plugin_name; ?>[default_voting]" id="<?php echo $this->plugin_name; ?>-default_voting">
                    
                        <option <?php if ( empty( $default_voting ) || $default_voting == 'RCV' ) { echo 'selected="selected"'; } ?> value='RCV'><?php _e( 'Ranked Choice', $this->plugin_name ); ?></option>
                        
                        <option <?php if ( $default_voting == 'AV' ) echo 'selected="selected"'; ?> value='AV' disabled="disabled"><?php _e( 'Approval - Future', $this->plugin_name ); ?></option>

                        <option <?php if ( $default_voting == 'PV' ) echo 'selected="selected"'; ?> value='PV' disabled="disabled"><?php _e( 'Plurality - Future', $this->plugin_name ); ?></option>
  
                  	</select>
                    
                    <hr />
                    
                    <div class="voting_defaults <?php if ( empty( $default_voting ) || $default_voting == 'RCV' ) { echo 'visible-block'; } else { echo 'not-visible'; } ?>" id="ranked_defaults_hold">
					
						<?php include_once( plugin_dir_path( __FILE__ ) . 'assets/prog-vote-ranked-default.php' ); ?>
                        
                  	</div>
                    
                    <div class="voting_defaults <?php if ( $default_voting == 'AV' ) { echo 'visible-block'; } else { echo 'not-visible'; } ?>" id="approval_defaults_hold">
					
						<?php include_once( plugin_dir_path( __FILE__ ) . 'assets/prog-vote-approval-default.php' ); ?>
                        
                   	</div>
                    
                    <div class="voting_defaults <?php if ( $default_voting == 'PV' ) { echo 'visible-block'; } else { echo 'not-visible'; } ?>" id="plurality_defaults_hold">
					
						<?php include_once( plugin_dir_path( __FILE__ ) . 'assets/prog-vote-plurality-default.php' ); ?>
                        
                  	</div> 

				</td>
			
            </tr>
            
	 		<tr>
			
            	<th scope="row">
                
                	<label for="<?php echo $this->plugin_name; ?>-multi_winner">
					
						<?php _e( 'Multi-Winner Elections', $this->plugin_name ); ?>
                        
                  	</label>
                    
              	</th>
				
                <td>
				
                	<input type="checkbox" name="<?php echo $this->plugin_name; ?>[multi_winner]" id="<?php echo $this->plugin_name; ?>-multi_winner" value="yes" <?php if ( empty( $ranked_choice_max ) || $multi_winner == 'yes' ) { echo 'checked="checked"'; } ?> />
                    
					&nbsp;<?php _e( 'Where there are multiple seats available in a race the default will be multiple winners from a single election.', $this->plugin_name ); ?>
                
                </td>

			</tr>
	
     		<tr>

				<th scope="row">
                
                	<label for="<?php echo $this->plugin_name; ?>-vote_groups">
					
						<?php _e( 'Vote groups', $this->plugin_name ); ?>
                        
                   	</label>
                    
              	</th>

				<td>
				
                	<input type="text" name="<?php echo $this->plugin_name; ?>[vote_groups]" id="<?php echo $this->plugin_name; ?>-vote_groups" value="<?php if ( $vote_groups ) { echo $vote_groups; } ?>" style="width:100%;" />
                    
                    <br />
					
					<?php _e( 'Enter a list of vote groups that can be applied to elections, races and voters. The groups must be separated by comas (,).', $this->plugin_name ); ?>
                    
                </td>
                
			</tr>
			
            <tr>
				
                <th scope="row">
                
                	<label for="">
					
						<?php _e( 'Timezone', $this->plugin_name ); ?>
                        
                  	</label>
                    
               	</th>
				
                <td>
				
                	<?php //include_once( plugin_dir_path( __FILE__ ) . 'assets/prog-vote-timezone-dropdown.php' );?>
                	
					<?php _e( 'Currently, the time zone will be that of the wordpress setting for the site. Future updates will provide other timezone options.', $this->plugin_name ); ?>
            
                </td>
			
            </tr>
			
            <tr>
			
            	<th scope="row">
				
					<?php _e( 'Date Format', $this->plugin_name ); ?>
                    
               	</th>
				
                <td>
                
                    <?php include_once( plugin_dir_path( __FILE__ ) . 'assets/prog-vote-date-format.php' );?>
				
                </td>
			
            </tr>
			
            <tr>
			
            	<th scope="row">
				
					<?php _e( 'Time Format', $this->plugin_name ); ?>
                    
              	</th>
			
            	<td>
				
                	<?php include_once( plugin_dir_path( __FILE__ ) . 'assets/prog-vote-time-format.php' );?>
				
                </td>
			
            </tr>
			
            <tr>
			
            	<th width="33%" scope="row">
                
                	<label for="WPLANG">
					
						<?php _e( 'Default Language', $this->plugin_name ); ?>
                        
                  	</label>
                    
              	</th>
				
                <td>
				
                	<?php //include_once( plugins_url() . '/prog-vote/assets/prog-vote-language-dropdown.php' );?>
                
                    <?php _e( 'This plugin is currently only available in english. Developers are free to produce translations to modify the plugin.', $this->plugin_name ); ?>
                    
                </td>
            
            </tr>
        
        </table>
		
        <p class="submit">
        	
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Save Changes', $this->plugin_name ); ?>"  />
        
        </p>
   	
    </form>

</div>