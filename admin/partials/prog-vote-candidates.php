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
 
$raceArray = array();

$today = current_time( 'Y-m-d H:i:s' );

$Eargs = array(

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

$Equery = new WP_Query( $Eargs );

if ( $Equery->have_posts() ) {
	
	while ( $Equery->have_posts() ) {

		$Equery->the_post();

		$raceArray[] = get_the_ID();

	} // end while has posts.

} // end if has posts.
 
$args = array(

	'post_type'  => 'pv_race',

	'meta_key'   => 'pv_race_election',

	'orderby'    => 'meta_value',

	'order'      => 'ASC',

	'meta_query' => array(

		array(

			'key'     => 'pv_race_election',

			'value'   => $raceArray,

			'compare' => 'IN',

		),

	),

);

$query = new WP_Query( $args );

?>

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

            	    <label for="pv_candidate_race"><?php _e( 'Race', $this->plugin_name ); ?></label>

              	</th>

                <td>
                
                <?php
				if ( ! $this->voteTimeClose( get_post_meta( get_post_meta( $id, 'pv_candidate_race', true ), 'pv_race_election', true ) ) && ! $this->voteTimeNotOpen( get_post_meta( get_post_meta( $id, 'pv_candidate_race', true ), 'pv_race_election', true ) ) ) { 
				
					$assigned = get_post_meta( $id, 'pv_candidate_race', true );
				
					echo '<strong>'.__( 'Assigned Race' ).': ['.get_the_title( $assigned ).' ('.get_the_title(get_post_meta( $assigned, 'pv_race_election', true ) ).')]</strong><hr />';
							
					_e( 'The election this candidate is assigned to is ongoing. No changes can be made to an active election.' );
				
				} else {

					if ( $query->have_posts() ) { 
					
						if ( get_post_meta( $id, 'pv_candidate_race', true ) && $this->voteTimeClose( get_post_meta( get_post_meta( $id, 'pv_candidate_race', true ), 'pv_race_election', true ) ) ) {
							
							$assigned = get_post_meta( $id, 'pv_candidate_race', true );
								
							echo '<strong>'.__( 'Assigned Race', $this->plugin_name ).': ['.get_the_title( $assigned ).' ('.get_the_title(get_post_meta( $assigned, 'pv_race_election', true ) ).')]</strong><hr />';
							
							_e( 'You can assign this election to a different race below.<br />', $this->plugin_name );
							
						} else { $assigned = false; }?>
					
						<select name="pv_candidate_race" id="pv_candidate_race" autofocus="autofocus">
					
						<option class="non-select" disabled="disabled" <?php if ( empty( $race ) ) { echo 'selected="selected"'; } ?>>
						
							<?php _e( 'Select the race to which to add this candidate.', $this->plugin_name ); ?>
							
						</option>
					
						<?php 
						if ( $assigned ){ ?>
							
							<option value="<?php echo $assigned; ?>" data-open="<?php echo get_post_meta( get_post_meta( $assigned, 'pv_race_election', true ), 'pv_election_open', true ); ?>" data-close="<?php echo get_post_meta( get_post_meta( $assigned, 'pv_race_election', true ), 'pv_election_close', true ); ?>" <?php if ( $race == $assigned ) { echo 'selected="selected"'; } ?>>
						
								<?php echo get_the_title( $assigned ).' ('.__( 'race has been completed', $this->plugin_name ).')'; ?> 
								
							</option>
						
						<?php }
					
						while ( $query->have_posts() ) {
					
							$query->the_post(); ?>
					
							<option value="<?php echo get_the_ID(); ?>" data-a="" <?php if ( $race == get_the_ID() ) { echo 'selected="selected"'; } ?>>
							
								<?php echo get_the_title().' ('.__( 'Election:', $this->plugin_name ).' '.get_the_title( get_post_meta( get_the_ID(), 'pv_race_election', true ) ).')'; ?>
							
							</option>
					
						<?php } // end while has post ?>
					
						</select>
					
						<p>
							
							<?php _e( 'If you do not see your a race that you would like to select, either it is not created yet or has not been assigned to a valid election.', $this->plugin_name ); ?>
							
						</p>
						
						<?php /* Restore original Post Data */
						
						wp_reset_postdata();
						
					} else {?>
						
						<p>
						
						<input type="hidden" name="pv_candidate_race" value="<?php echo get_post_meta( get_the_ID(), 'pv_candidate_race', true ); ?>" />
						
						<?php _e( 'No future elections currently exist. Please go to the <a href="edit.php?post_type=pv_race">RACE TAB</a> and create a new race', $this->plugin_name ); 
						
						if ( get_post_meta( get_the_ID(), 'pv_candidate_race', true ) ) {
								
							echo ' <strong>['.get_the_title( get_post_meta( get_the_ID(), 'pv_candidate_race', true ) ).' ('.get_the_title( get_post_meta( get_post_meta( get_the_ID(), 'pv_candidate_race', true ), 'pv_race_election', true ) ).')]</strong>';
								
						} else { 
						
							echo ' <strong>['.__( 'NO RACE ASIGNED', $this->plugin_name ).']</strong>'; 
							
						} //end if get candidate race posts. ?>
						
						</p>
				   
					<?php 
					} // end if has posts. 
					
				} // end if race is active. ?>
		
          		</td>
    
       		</tr>
   	
    	</table>			
    
    </div>

</div>