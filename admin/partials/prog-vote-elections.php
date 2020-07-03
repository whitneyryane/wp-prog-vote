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

$options = get_option($this->plugin_name, array() );
?>
<style>

.not-visible {

	display:none;

}

</style>

<div id="votingdiv" class="postbox" >

	<button type="button" class="handlediv button-link" aria-expanded="true">

       	<span class="screen-reader-text">
		
			<?php _e( 'Toggle panel: Voting', $this->plugin_name ); ?>
            
       	</span>
    	
        <span class="toggle-indicator" aria-hidden="true"></span>
   	
    </button>
    
    <h2 class='hndle'>
    
    	<span>
		
			<?php _e( 'Voting', $this->plugin_name ); ?>
            
      	</span>
   	
    </h2>
    
	<div class="inside">
	
    	<div class='hide-if-js'>
    
           	<p>
    
               	<?php _e( 'JavaScript must be enabled to use this feature.', $this->plugin_name ); ?>
           	
            </p>
       	
        </div>
        
        <table width="100%" cellpadding="10px" class="thin-border">
        
            <tr>
        
                <th>
        
                    <label for="">
					
						<?php _e( 'Privilages', $this->plugin_name ); ?>
                        
                  	</label>
         
                </th>
         
                <td>
         
                    <div>
                    
                    	<input type="checkbox" id="pv_election_info_voter_only" name="pv_election_info_voter_only" value="1" <?php checked( $info_voter_only, true, true ); ?> />
                        
                        <label for="pv_election_info_voter_only"> 
							
                            &nbsp;<?php _e( 'Only voters can see election details page.', $this->plugin_name ); ?>
                            
                      	</label>
                        
                   	</div>
                    
                    <hr />
                    
                    <div>
                    
                    	<input type="checkbox" id="pv_election_results_voter_only" name="pv_election_results_voter_only" value="1" <?php checked( $results_voter_only, true, true ); ?> />
                        
                        <label for="pv_election_results_voter_only">
						
							&nbsp;<?php _e( 'Only voters can see election results.', $this->plugin_name ); ?>
                            
                      	</label>
                        
                   	</div>
                    
                    <hr />
                    
                    <div>
                    
                    	<input type="checkbox" id="pv_election_data_voter_only" name="pv_election_data_voter_only" value="1" <?php checked( $data_voter_only, true, true ); ?> />
                        
                        <label for="pv_election_data_voter_only">
                        
							&nbsp;<?php _e('Only voters can see election data table.',$this->plugin_name); ?>
                            
                      	</label>
                        
                 	</div>
                    
                    <hr />
                    
                    <div>
                    
                    	<input type="checkbox" id="pv_election_open_vote" name="pv_election_open_vote" value="1" <?php checked( $open_vote, true, true ); ?> />
                        
                        <label for="pv_election_ip_vote">
                        
							&nbsp;<?php _e( 'Open voting', $this->plugin_name ); ?>
                            
                       	</label>
                        <p> Limit open voting (1 per IP Address)? <input type="radio" id="pv_election_ip_vote_yes" name="pv_election_ip_vote" value="1" <?php checked( $ip_vote, true, true ); ?> />  Yes <input type="radio" id="pv_election_ip_vote_no" name="pv_election_ip_vote" value="0" <?php checked( $ip_vote, false, true ); ?> /> NO </p>

                        
                  	</div>
                
                </td>
            
            </tr>
          	
            <tr>
            
                <th>
            
                    <label for="pv_election_open">
					
						<?php _e( 'Voting Opens', $this->plugin_name ); ?>
                        
                  	</label>
                
                </th>
                
                <td>
                
                    <input type="date" id="pv_election_open_date" name="pv_election_open_date" style="width:100%" value="<?php if ( ! empty( $voting_open_date ) ) { echo $voting_open_date; } ?>" />
                    
                    <input type="time" id="pv_election_open_time" name="pv_election_open_time" style="width:100%" value="<?php if ( ! empty( $voting_open_time ) ) { echo $voting_open_time; } ?>" />
                    
                    <br />
                
                </td>
            
           	</tr>
            
            <tr>
            
                <th>
            
                    <label for="pv_election_close">
					
						<?php _e( 'Voting Close', $this->plugin_name ); ?>
                        
                  	</label>
            
                </th>
                
                <td>
                
                    <input type="date" id="pv_election_close_date" name="pv_election_close_date" style="width:100%" value="<?php if ( ! empty( $voting_close_date ) ) { echo $voting_close_date; } ?>" required="required" />
                
                    <input type="time" id="pv_election_close_time" name="pv_election_close_time" style="width:100%" value="<?php if ( ! empty( $voting_close_time ) ) { echo $voting_close_time; } ?>" required="required" />
                
                </td>
            
            </tr>
            
            <tr>
            
                <th>
            
                    <label for="pv_election_system">
					
						<?php _e( 'Election System', $this->plugin_name ); ?>
                        
                  	</label>
                
                </th>
                
                <td>
                
                    <select id="pv_election_system" name="pv_election_system" style="width:100%">
                
                        <option value="RCV" <?php if ( $election_system == 'RCV' ) { echo 'selected="selected"'; } ?>>
						
							<?php _e( 'Ranked Choice', $this->plugin_name ); ?>
                            
                       	</option>
                        
                        <option value="AV" <?php if ( $election_system == 'AV' ) { echo 'selected="selected"'; } ?> disabled="disabled">
						
							<?php _e( 'Approval - Future', $this->plugin_name ); ?>
                            
                      	</option>
                        
                        <option value="RV" <?php if ( $election_system == 'RV' ) { echo 'selected="selected"'; } ?> disabled="disabled">
						
							<?php _e( 'Range - Future', $this->plugin_name ); ?>
                            
                      	</option>
                        
                        <option value="PV" <?php if ( $election_system == 'PV' ) { echo 'selected="selected"'; } ?> disabled="disabled">
						
						<?php _e( 'Plurality - Future', $this->plugin_name ); ?>
                        
                        </option>
                        
                    </select>
                
                </td>
                
            </tr>
            
            <tr id="pv_max_select_hold" class="<?php if ( $election_system != 'RCV' ) { echo 'not-visible'; } ?>" >
                
                <?php include_once( plugin_dir_path( __FILE__ ) . 'assets/prog-vote-max-select-slider.php' ); ?>
            
            </tr>
            
            <tr>
            
                <th>
            
                    <label for="pv_election_vote_groups">
					
						<?php _e( 'Default Vote Groups', $this->plugin_name ); ?>
                        
                  	</label>
            
                </th>
            
                <td>
            
                    <input type="text" id="pv_election_vote_groups" name="pv_election_vote_groups" style="width:100%" value="<?php if ( ! empty( $default_vote_groups ) ) { echo $default_vote_groups; } ?>" />
                    	
                        <strong><?php if ( isset( $options['vote_groups'] ) ) { echo '['.$options['vote_groups'].']'; } else { echo 'No vote groups set.'; } ?></strong>
                        
                        <br />
                        
                        <small><?php _e( 'Enter one or more elegible vote groups with comas separating each (Ex: members, leadership, partners). If no vote groups are entered, then the election will be available to all voters.' ); ?></small>
                
                </td>
            
            </tr>
        
        </table>			
    
    </div>

</div>
