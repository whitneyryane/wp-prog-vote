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
 
$options = get_option( $this->plugin_name, array() );

$today = current_time( 'Y-m-d H:i:s' );

$args = array(

	'post_type'  => 'pv_election',

	'meta_key'   => 'pv_election_open',

	'orderby'    => 'meta_value',

	'order'      => 'ASC',

	'meta_query' => array(

		array(

			'key'     => 'pv_election_open',

			'value'   => $today,

			'compare' => '>',

		),

	),

);

$query = new WP_Query( $args );

?>

<style>
.not-visible {
	display:none;
}
</style>

<div id="votingdiv" class="postbox " >

	<button type="button" class="handlediv button-link" aria-expanded="true">

    	<span class="screen-reader-text">
		
			<?php _e( 'Toggle panel: Voting', $this->plugin_name ); ?>
            
      	</span>

        <span class="toggle-indicator" aria-hidden="true"></span>

   	</button>

   	<h2 class='hndle'>

       	<span>
		
			<?php _e( 'Specifics', $this->plugin_name ); ?>
            
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

            	    <label for="pv_race_election"><?php _e( 'Election', $this->plugin_name ); ?></label>

              	</th>
               	
                <td>
                
				<?php 
				if ( !empty( get_post_meta( $post->ID, 'price_list_category1', true ) ) && ! $this->voteTimeClose( get_post_meta( $id, 'pv_race_election', true ) ) && ! $this->voteTimeNotOpen( get_post_meta( $id, 'pv_race_election', true ) ) ) {
					
					$assigned = get_post_meta( $id, 'pv_race_election', true );
				
					echo '<strong>'.__( 'Assigned Election' ).': ['.get_the_title( $assigned ).' ('.get_post_meta( $assigned, 'pv_election_open_date', true ).')]</strong><hr />';
							
					_e( 'The election this race is assigned to is ongoing. No changes can be made to an active election.' );
					
				} else {
					
					if ( $query->have_posts() ) { 
						
						if ( get_post_meta( get_the_ID(), 'pv_race_election', true ) && $this->voteTimeClose( get_post_meta( get_the_ID(), 'pv_race_election', true ) ) ) {
							
							$assigned = get_post_meta( get_the_ID(), 'pv_race_election', true );
								
							echo '<strong>'.__( 'Assigned Election' ).': ['.get_the_title().' ('.get_the_title(get_post_meta( get_the_ID(), 'pv_race_election', true )).')]</strong><hr />';
							
							_e( 'You can assign this election to a different race below.<br />' );
							
						} else { $assigned = false; }?>
						
						<select name="pv_race_election" id="pv_race_election" autofocus="autofocus">
					
						   <option class="non-select" disabled="disabled" <?php if ( empty( $election ) ) { echo 'selected="selected"'; } ?>><?php _e( 'Select the election to which to add this race.', $this->plugin_name ); ?></option>
					
							<?php if ( $assigned ){ ?>
								
								<option value="<?php echo $assigned; ?>" data-open="<?php echo get_post_meta( $assigned, 'pv_election_open', true ); ?>" data-close="<?php echo get_post_meta( $assigned, 'pv_election_close', true ); ?>" <?php if ( $election == $assigned ) { echo 'selected="selected"'; } ?>>
							
									<?php echo get_the_title( $assigned ).' (election has been completed)'; ?> 
									
								</option>
							
							<?php }
							
							while ( $query->have_posts() ) {
					
							$query->the_post(); ?>
					
							<option value="<?php echo get_the_ID(); ?>" data-open="<?php echo get_post_meta( get_the_ID(), 'pv_election_open', true ); ?>" data-close="<?php echo get_post_meta( get_the_ID(), 'pv_election_close', true ); ?>" <?php if ( $election == get_the_ID() ) { echo 'selected="selected"'; } ?>>
								
								<?php echo get_the_title( get_the_ID() ).' ('.get_post_meta( get_the_ID(), 'pv_election_open_date', true ).')'; ?> 
									
							</option>
		 
							<?php } ?>
		 
						</select>
		 
						<p>
						
							<?php _e( 'If you do not see the election that you would like to select, either it is not created, published, or it has not specified valid dates.', $this->plugin_name ); ?>
						
						</p>
						
						<?php
						/* Restore original Post Data */
						wp_reset_postdata(); 
						
						} else { ?>
						
						<p>
						
							<input type="hidden" name="pv_race_election" value="<?php echo get_post_meta( get_the_ID(), 'pv_race_election', true ); ?>" />
						
							<?php 
							if ( get_post_meta( get_the_ID(), 'pv_race_election', true ) ) {
								
								echo '<strong>'.__( 'Assigned Election' ).': ['.get_the_title().' ('.get_the_title(get_post_meta( get_the_ID(), 'pv_race_election', true )).')]</strong><hr />';
								
							} else {
								
								echo '<strong>['.__( 'NO ELECTION ASIGNED' ).']</strong><hr />';
								
							}
							
							echo __( 'No future elections currently exist.', $this->plugin_name ).' '.__( 'Go to the', $this->plugin_name ).' <a href="edit.php?post_type=pv_election">'.__( 'ELECTIONS TAB', $this->plugin_name ).'</a>'.' '.__( 'and create a new election', $this->plugin_name ); ?>
							
						</p>
						
					<?php
					} 
				
				}?>
					
               	</td>
          	
            </tr>
          
            <tr>
        	
                <th>
            
            	    <label for="pv_race_voting">
					
						<?php _e( 'Race Specific Voting System', $this->plugin_name ); ?>
                        
                   	</label>
            
              	</th>
                
                <td>
                
                	<select name="pv_race_voting" id="pv_race_voting">
                
                        <option <?php if ( empty( $race_voting ) || $race_voting == 'SAE' ) { echo 'selected="selected"'; } ?> value='SAE'>
						
							<?php _e( 'Same as Election', $this->plugin_name ); ?>
                        
                        </option>
                        
                        <option <?php if ( $race_voting == 'RCV' ) { echo 'selected="selected"'; } ?> value='RCV'>
						
							<?php _e( 'Ranked Choice', $this->plugin_name ); ?>
                            
                       	</option>
                        
                        <option <?php if ( $race_voting == 'AV' ) { echo 'selected="selected"'; } ?> value='AV' disabled="disabled">
						
							<?php _e( 'Approval - Future', $this->plugin_name ); ?>
                        
                        </option>
                        
                       	<option <?php if ( $race_voting == 'RV' ) { echo 'selected="selected"'; } ?> value='RV' disabled="disabled">
						
							<?php _e( 'Range - Future', $this->plugin_name ); ?>
                        
                        </option>
                        
                        <option <?php if ( $race_voting == 'PV' ) { echo 'selected="selected"'; } ?> value='PV' disabled="disabled">
						
							<?php _e( 'Plurality - Future', $this->plugin_name ); ?>
                        
                        </option>
                        
                  	</select>
               
               </td>
          	
            </tr>
            
            <tr>
        	
                <th>
            
            	    <label for=""><?php _e( 'Muli-Winner Race', $this->plugin_name ); ?></label>
            
              	</th>
            
                <td>
                	
                    <label for="pv_race_muliti_winner_yes">
					
						<?php _e( 'YES', $this->plugin_name ); ?>
                        
                   	</label>
                    
                    <input type="radio" name="pv_race_multi_winner" id="pv_race_muliti_winner_yes" value="yes" <?php if ( $multi_winner == 'yes' || ( empty( $multi_winner ) && $multi_winner == 'yes' ) ) { echo 'checked'; }?> />
                    
                    <label for="pv_race_muliti_winner_no">
					
						<?php _e( 'NO', $this->plugin_name ); ?>
                       
                  	</label>
                    
                    <input type="radio" name="pv_race_multi_winner" id="pv_race_muliti_winner_no" value="no" <?php if ( $multi_winner == 'no' || ( empty( $multi_winner ) && ( $multi_winner == '' || $multi_winner == false || empty($multi_winner ) ) ) ) { echo 'checked'; }?> />
               
               </td>
          	
            </tr>
           
            <tr id="winner_count_hold" class="<?php if ( $multi_winner != 'yes' || ( empty( $multi_winner ) && $multi_winner != 'yes' ) ) {  echo "not-visible"; }?>">
            
            	<?php include_once( plugin_dir_path( __FILE__ ) . 'assets/prog-vote-multi-winner-slider.php' ); ?>
            
            </tr>
            
             <tr>
    
                <th width="50%">
    
                    <label for="pv_race_vote_groups">
					
						<?php _e( 'Race Vote Groups', $this->plugin_name ); ?>
                    
                    </label>
    
                </th>
    
                <td width="50%">
    
                    <input type="text" id="pv_race_vote_groups" name="pv_race_vote_groups" style="width:100%" value="<?php if ( ! empty( $vote_groups ) ) { echo $vote_groups; } ?>" /> 
                    
                    <strong><?php if ( isset( $options['vote_groups'] ) ) { echo '['.$options['vote_groups'].']'; } else { echo 'No vote groups set.'; } ?></strong>
                    
                    <br />
                    
                    <small><?php _e( 'Enter one or more elegible vote groups with comas separating each (Ex: members, leadership, partners). If no vote groups are entered, then the race will default to the election vote groups.' ); ?></small>
                
                </td>
            
            </tr>
            
        </table>			
    
    </div>

</div>
