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
 * @subpackage Prog_Vote/public/partials
 */

if ( !is_user_logged_in() && get_post_meta($atts['id'], 'pv_election_info_voter_only', true ) ) {

	_e( 'You must be logged in and have permission to view this election info.', $this->plugin_name );

	echo '<hr />';

	echo'<h3>'.__( 'Login Form', $this->plugin_name ).'</h3>';

	wp_login_form();

	echo '<a href="'.wp_lostpassword_url( get_permalink() ).'" title="Lost Password">'.__( 'Lost Password', $this->plugin_name ).'</a>';

} else {

	if ( $this->canVote( $atts['id'] ) || !get_post_meta( $atts['id'], 'pv_election_info_voter_only', true ) ) {?>

<style>

	.doubleTable{

		float:left;

	 	min-width:50%;
	
	}
	
	.candidate {
	
		float:left;

		padding:8px;

		margin:5px;

		background:#E8E8E8;

		border-radius:6px;

	}

	@media only screen and (max-width: 600px) {

		.doubleTable {
		
			 min-width:100%;
		
		}

	}

</style>

<h2>

	<?php echo get_the_title( $atts['id'] ); ?>
    
</h2>

<small>

	<?php
	_e( 'Voting Groups: ', $this->plugin_name );
	
	if( get_post_meta( $atts['id'], 'pv_election_vote_groups', true ) ) {
		
		echo ' ['.get_post_meta( $atts['id'], 'pv_election_vote_groups', true ).']';
	
	} // end if vote groups. ?>
    
</small>

<div>

	<div class="doubleTable">

    	<table>
    
    	    <tr>
        
        	    <th colspan="4">
				
					<?php _e( 'VOTING OPENS', $this->plugin_name ); ?>
                    
               	</th>
        
        	</tr>
        
        	<tr>
            
            	<td style="font-weight:bold;">
				
					<?php _e( 'Date', $this->plugin_name ); ?>
                    
               	</td>
            
            	<td>
				
					<?php
					if ( get_post_meta( $atts['id'], 'pv_election_open_date', true ) ) {
					
						echo get_post_meta( $atts['id'], 'pv_election_open_date', true );
						
					} else {
					
						_e( 'NONE PROVIDED', $this->plugin_name );
					
					} // end if has open date ?>
           	
            	</td>
            
            	<td style="font-weight:bold;">
				
					<?php _e( 'Time', $this->plugin_name ); ?>
                    
             	</td>
            
            	<td>
				
					<?php 
					if( get_post_meta( $atts['id'], 'pv_election_open_time', true ) ) {
						
						echo get_post_meta( $atts['id'], 'pv_election_open_time', true );
						
					} else {
					
						_e( 'NONE PROVIDED', $this->plugin_name );
						
					} // end if has open time. ?>
            
            	</td>
        
        	</tr>
    
    	</table>
    
    </div>
	
    <div class="doubleTable">
    
    	<table>
        	
            <tr>
            
            	<th colspan="4">
				
					<?php _e( 'VOTING CLOSES', $this->plugin_name ); ?>
                    
               	</th>
        
        	</tr>
        
        	<tr>
            
            	<td style="font-weight:bold;">
				
					<?php _e( 'Date', $this->plugin_name ); ?>
                    
              	</td>
            
            	<td>
				
					<?php 
					if ( get_post_meta( $atts['id'], 'pv_election_close_date', true ) ) {
                        
                        echo get_post_meta( $atts['id'], 'pv_election_close_date', true );
                    
                    } else {
                    
                        _e( 'NEEDED', $this->plugin_name );
                        
                    } // end if has close date. ?>
                
            	</td>
                
            	<td style="font-weight:bold;">
				
					<?php _e( 'Time', $this->plugin_name ); ?>
              	
                </td>
            
            	<td>
			
					<?php 
					if ( get_post_meta( $atts['id'], 'pv_election_close_time', true ) ) {
					
						echo get_post_meta( $atts['id'], 'pv_election_close_time', true );
					
					} else {
					
						_e( 'NEEDED', $this->plugin_name );
					
					} // end if has close time. ?>
                    
           		</td>
        
        	</tr>
    
    	</table>
	
    </div>

</div>

<div>

	<table>
    
        <tr>
    
            <th>
			
				<?php _e( 'DEFAULT ELECTION SYSTEM', $this->plugin_name ); ?>
                
           	</th>
    
        </tr>
        
        <tr>
        
            <td>
		
        		<?php 				
				$es = get_post_meta( $atts['id'], 'pv_election_system', true );
				
				if ( $es == 'RCV' ) {
					
					$election_system = __( 'Ranked Choice Voting', $this->plugin_name );
				
				} else if ( $es == 'AV' ) {
					
					$election_system = __( 'Approval Voting', $this->plugin_name );
					
				} else if ( $es == 'RV' ) {
					
					$election_system = __( 'Range Voting', $this->plugin_name );
					
				} else if ( $es == 'PV' ) {
					
					$election_system = __( 'Plurality Voting', $this->plugin_name );
				
				} // end if election system, assign to variable.
					
				if ( $es ) { 
				
					echo $election_system;
					
					if ( $es != 'PV' ) {
						
						echo ' ('.get_post_meta( $atts['id'], 'pv_election_max_select', true ).' '.__( 'rank maximum', $this->plugin_name ).')';
					
					} // end if election system is plurality.
					
				} // end if election system is set. ?>
            
            </td>
      	
        </tr>
    
    </table>

</div>

<br />

<div>
	
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

<h4>

	<?php _e( 'RACES', $this->plugin_name ); ?>
    
</h4>

<div>
	
	<?php	
	$args = array(
	
		'post_type'  => 'pv_race',
	
		'orderby'    => 'title',
	
		'order'      => 'ASC',
	
		'meta_query' => array(
			
			array(
			
				'key'     => 'pv_race_election',
			
				'value'   => $atts['id'],
			
				'compare' => '=',
			
			),
	
		),
	
	);

	$query = new WP_Query( $args );

	$race = array();

	$candidate = array();

	if ( $query->have_posts() ) {
	
		while( $query->have_posts() ) {
	
			$query->the_post();
			
			$race[get_the_ID()] = array(
			
				get_the_title(),
				
				get_post_meta( get_the_ID(), 'pv_race_voting', true ),
				
				get_post_meta( get_the_ID(), 'pv_race_multi_winner', true ),
				
				get_post_meta( get_the_ID(), 'pv_race_winner_count', true )
			
			);
			
		} // end while has post  
	
		wp_reset_postdata(); 
	
	} else { ?>
	
    <table>
    
    	<tr>
        
        	<td>
			
				<?php _e( 'No races are assigned to this election. Please go to the <a href="edit.php?post_type=pv_race">RACE TAB</a> and assign an election to each relevant race.', $this->plugin_name  ); ?>
                
          	</td>
            
       	</tr>
        
   	</table>
    
	<?php
	} // end if has posts. 
    	
	foreach( $race as $key => $value ) { 
	
		$args = array(
		
			'post_type'  	=> 'pv_candidate',
		
			'orderby'    	=> 'title',
		
			'posts_per_page'=>'50',
		
			'order'      	=> 'ASC',
		
			'meta_query' 	=> array(
		
				array(
		
					'key'     => 'pv_candidate_race',
		
					'value'   => $key,
		
					'compare' => '=',
		
				),
		
			),
		
		);
		
		$query = new WP_Query( $args ); ?>	
		
		<table>	        
		
			<tr>
		
				<th>
		
					<?php		
					echo $value[0].' <small style="float:right;">|';
						
					if ( !$value[1] ) {
						
						$vm = $election_system;
						
					} else if ( $value[1] == 'SAE' ) {
						
						$vm = $election_system;
						
					} else if ( $value[1] == 'RCV' ) {
						
						$vm = __( 'Ranked Choice Voting', $this->plugin_name );
					
					} else if ( !$value[1] == 'AV' ) {
						
						$vm = __( 'Approval Voting', $this->plugin_name );
						
					} else if ( !$value[1] == 'RV' ) {
						
						$vm = __( 'Range Voting', $this->plugin_name );
						
					} else if ( !$value[1] == 'PV' ) {
						
						$vm = __( 'Plurality Voting', $this->plugin_name );
						
					}
					
					echo $vm;
					
					if ( $vm == __( 'Ranked Choice Voting', $this->plugin_name ) ) {
						
						if ( $value[2] == 'yes' ) {
							
							if ( (int)$value[3] > 1 ) {
								
								echo '|'.__( 'Multi-Winner', $this->plugin_name ).' ('.$value[3].')';
								
							} // end if max vote count is greater than 1
						
						} // end if multi-winner == yes
					
					} // end if $vm == RCV
					
					echo '|</small>'; ?>
					
				</th>
			
			</tr>
			
			<tr>
			
				<td>	
		
					<?php 
					
					if ( $query->have_posts() ) {
			
						while ( $query->have_posts() ) {
					
							$query->the_post(); ?>
			
							<a href="<?php echo get_the_guid( get_the_ID() ); ?>" target="_blank">
							
								<div id="<?php echo get_the_ID(); ?>" class="candidate">
								
									<?php echo get_the_title(); ?>
									
								</div>
								
							</a>
			
							<?php 
					
						} // end while has post
					
					} // end if has post ?>
				
				</td>
	
			</tr>
	
			<tr>
	
				<td>
	
					<?php echo get_post_field( 'post_content', $value[0] );?>
	
				</td>
			
			</tr>
		
		</table>
	
	<?php } ?>
    
  	<table>

		<tr>
            
           	<td>

				<center>
    
                    <?php
                    if ( get_post_meta( $atts['id'], 'tabulated', true ) ) {
            
                        _e( 'This election\'s results have been tabulated. You can see the results at the following link.' , $this->plugin_name ); 
            
                        echo '<br />';
                        
                        echo '<a href="'.get_site_url().'/prog-vote/?electionId='.$atts['id'].'&display=results" target="_blank">'.get_site_url().'/prog-vote/?electionId='.$atts['id'].'&display=results</a>';
        
                    } // end if election results. ?>

				</center>

			</td>
                
         </tr>
            
	</table>

</div>

<?php 	} else {
					
		echo '<h3>'.__( 'You do not have permission to view this election info.', $this->plugin_name ).'</h3>';

	} // End check if voter is elegible to see election info.

} // End check if voter is logged in (or needs to be). ?>