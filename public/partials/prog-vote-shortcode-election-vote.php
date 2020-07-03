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
 
if ( !is_user_logged_in() && !get_post_meta($atts['id'], 'pv_election_ip_vote', true ) ) {

	_e( 'You must be logged in and have permission to vote in this election.', $this->plugin_name );

	echo '<hr />';

	echo'<h3>'.__( 'Login Form', $this->plugin_name ).'</h3>';

	wp_login_form();

	echo '<a href="'.wp_lostpassword_url( get_permalink() ).'" title="Lost Password">'.__( 'Lost Password', $this->plugin_name ).'</a>';

} else {

	if ( ( $this->canVote( $atts['id'] ) || get_post_meta( $atts['id'], 'pv_election_ip_vote', true ) ) ) {

		if ( $interval = $this->voteTimeNotOpen( $atts['id'] ) ) {

			echo '<h3>'.__( 'Voting for this election has not yet opened.', $this->plugin_name ).'</h3>';
			
			echo '<p>'.__( 'There is', $this->plugin_name );

			echo ' <strong>'.$interval->format( '%a '.__( 'days', $this->plugin_name ).', %h '.__( 'hours', $this->plugin_name ).', %i '.__( 'minutes', $this->plugin_name ).', and %s '.__( 'seconds', $this->plugin_name ) ).'</strong> ';

			echo __( 'until voting begins.', $this->plugin_name ).'</p>';

		} else {

			if ( $this->voteTimeClose( $atts['id'] ) ) {

				echo '<h3>'.__( 'Voting for this election has closed.', $this->plugin_name ).'</h3>';

				if ( get_post_meta( $atts['id'], 'tabulated', true ) ){
				
					echo '<p>'.__( 'This election\'s results have been tabulated. They are available at the following url:', $this->plugin_name ).' <a href="'.get_site_url().'/prog-vote/?electionId='.$atts['id'].'&display=results" target="_blank" >'.get_site_url().'/prog-vote/?electionId='.$atts['id'].'&display=results</a></p>';
				
				} // end if election has results

			} else {

				if ( $this->not_voted( $atts['id'] ) ) {
			
					if ( count( $_POST ) > 0 ) {
					
						if ( $_POST['verifiedVote'] ) {
					
							$this->prog_vote_insert_vote( $_POST );
				
						} else {
					
							include_once( 'assets/verify_vote.php' );
						
						} // End check if vote has been verified.
			
					} else {?>

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

	.rank {

		background:#CCC;

		border:#fff thin solid;	

		text-align:center;

		font-weight:bold;

		color:#000;

		display:block;

		float:left;	

	}

	.rank:hover {

		background:#fff;

		border:#4caf50 thin solid;

	}

	.rankhover {

		background: #fff;

		border:#4caf50 thin solid;

	}

	#verifyContain {

		position:fixed;

		overflow:auto;

		z-index:1000;

		width:100%;

		top:0px;

		left:0px;

		height:100%;

		background:#FFF;

		display:none;

	}

	#verifyPack {

		margin:auto 0px;

		padding:30px;

		background:#FFFFFF;

	}

	#verifyBox {

		margin:80px 15px;

	}

	#verifyButtons {

		margin:15px;

	}

	.lined {

		color: #4caf50;

		border-bottom: #999 2px solid;

	}

	@media only screen and (max-width: 600px) {

		.doubleTable {

			min-width:100%;

		}

	}	

</style>

<div id="ballot">

	<form method="post" action="" id="voteForm" />

	    <input type="hidden" name="election" value="<?php echo $atts['id'];?>" />

	    <input type="hidden" name="verifiedVote" value="0" />

		<?php 
		include_once( 'assets/elect_title.php' );
		
		if ( $atts['id'] ) {
			
			include_once( 'assets/elect_description.php' );
			
		} // end if election id.
		
		include_once( 'assets/voting_instructions.php' );?>

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
    
                while ( $query->have_posts() ) {
    
                    $query->the_post();
    
                    $race[get_the_ID()] = array(
                    
                        get_the_title(),
                    
                        get_post_meta( get_the_ID(), 'pv_race_voting', true ),
    
                        get_post_meta( get_the_ID(), 'pv_race_multi_winner', true ),
    
                        get_post_meta( get_the_ID(), 'pv_race_winners_count', true )
        
                    );
        
                } // end while has posts.
    
                wp_reset_postdata();
        
            } else {
                
                include_once( 'assets/no_races.php' );
                
            } // end if has posts

			foreach ( $race as $key => $value ) {

				$a = get_user_meta( get_current_user_id(), 'voter_vote_groups', true );
					
    			$a1 = explode( ",", $a );
                
    			$a2 = array_map( 'trim', $a1 );
    
   	 			$b = get_post_meta( $key, 'pv_race_vote_groups', true );
    
    			$b1 = explode( ",", $b );
                
    			$b2 = array_map( 'trim', $b1 );
    
    			if( count( array_intersect( $b2, $a2 ) || !get_post_meta( $key, 'pv_race_vote_groups', true ) ) > 0 ) {
                        
					$args = array(
	
						'post_type' 	=> 	'pv_candidate',
	
						'orderby' 		=> 	'title',
	
						'posts_per_page'=>	'50',
	
						'order'      	=> 	'ASC',
	
						'meta_query' 	=> 	array(
	
							array(
	
								'key'    	=> 	'pv_candidate_race',
	
								'value'		=> 	$key,
	
								'compare' 	=> 	'=',
	
							),
	
						),
	
					);
	
					$query = new WP_Query( $args );?>
	
					<br />
	
					<table>	        
	
						<?php include( 'assets/race_title.php' );?>
	
						<tr>
	
							<td>
					
								<table data-race="<?php echo $value[0]; ?>">	    
	
									<?php
									if( $vm == __( 'Ranked Choice Voting', $this->plugin_name ) ) {
	
										include( 'assets/rcv_race_sub.php' );
	
									} else {
	
										include( 'assets/pv_race_sub.php' );
	
									} // end if voting method is ranked choice. ?>
	
									<?php
									if ( $query->have_posts() ) {
	
										while ( $query->have_posts() ) {
	
											$query->the_post();
							
											$theID = get_the_ID();?>
	
											<tr>
	
												<?php include( 'assets/candidate_title.php' );?>
	
												<td>
	
													<?php 
                                                    if ( $query->post_count > 2 || $election_system == __( 'Plurality Voting', $this->plugin_name ) ) {
                                                        
                                                        if ( $max_select > $query->post_count ) {
                                                            
                                                            $rank_num = $query->post_count;
                                                        
                                                        } else {
                                                        
                                                            $rank_num = $max_select;
                                                        
                                                        } // end evaluation if max ranks is less than number of candidates
                        
                                                        for ( $i = 0; $i < $rank_num; $i++ ) { 
                        
                                                            include( 'assets/rcv_loop.php' );
                        
                                                        } // end ranked choice loop.
                        
                                                    } else {
                        
                                                        include( 'assets/pv_loop.php' );
                        
                                                    } // end if candidate count is greater than 2. ?>
                        
												</td>
	
											</tr>
	
										<?php 
                                        } // end while has posts.
	
									} // end if has posts. ?>
	
								</table>
				
							</td>
	
						</tr>
			
						<tr>
	
							<td>
				
								<?php echo get_post_field( 'post_content', $key );?>
				
							</td>
	
						</tr>
		
					</table>

				<?php 
                } // end if race has vote groups and user is in vote groups.
		 
			} // end foreach $race as $key => $value. ?>

			<br />
	
			<?php include_once( 'assets/submit_buttons.php' );?>

		</div> <!-- end div -->
    
	</form> <!-- end #voteForm form -->

</div> <!-- end #ballot div -->

<?php include_once( 'assets/verify_container.php' ); 

} // End check if POST data has been passed.
		
				} else { 
			
					echo '<h3>'.__( 'You have already voted in this election.', $this->plugin_name ).'</h3>';

					if ( get_post_meta( $atts['id'], 'pv_election_ip_vote', true ) ) {
	
						echo '<p>'.__( ' This election is limited to one vote per IP. If you have not voted, it is possible that someone with your same IP (uses the same wifi network for instance) has already voted.', $this->plugin_name ).'</p>';
						
						if ( $interval = $this->voteTimeNotClose( $atts['id'] ) ) { echo '<p>'.__( 'There is', $this->plugin_name );

			echo ' <strong>'.$interval->format( '%a '.__( 'days', $this->plugin_name ).', %h '.__( 'hours', $this->plugin_name ).', %i '.__( 'minutes', $this->plugin_name ).', and %s '.__( 'seconds', $this->plugin_name ) ).'</strong> ';

			echo __( 'until voting ends.', $this->plugin_name ).' After it ends the votes can be tabulated by the administrator and the results will become available at this link. Please stand by.</p>';}
	
					} // End check if voting is via IP Address.

				}// End check if user has voted
	
			} // End check if voting has closed
			
		} // end check if voting has not opened.

	} else {
		
		_e( 'You are not elegible to vote in this election.', $this->plugin_name );

		
	} // End check if has permission to vote
	
} // End check if logged in (or needs to be). ?>
