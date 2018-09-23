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
?>

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

	<form method="post" action="prog-vote-process-vote.php" />

	    <input type="hidden" name="verifiedVote" value="0" />

		<?php 
		include_once( 'assets/elect_title.php' );
		
		if ( $atts['id'] ) {
			
			include_once( 'assets/elect_description.php' );
			
		}
		
		include_once('assets/voting_instructions.php');?>

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
			
				include_once('assets/no_races.php');
				
			} // end if has posts.

			foreach ( $race as $key => $value ) {

				$args = array(
			
					'post_type' 	=> 'pv_candidate',
			
					'orderby' 		=> 'title',
			
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

				<br />

				<table>	        

					<?php include( 'assets/race_title.php' ); ?>

					<tr>

						<td>
				
                			<table data-race="<?php echo $value[0]; ?>">	    

								<?php
								if ( $vm == __( 'Ranked Choice Voting', $this->plugin_name ) ) {

									include( 'assets/rcv_race_sub.php' );

								} else {

									include( 'assets/pv_race_sub.php' );

								} // end if voting method = ranked choice voting. 
								
								if ( $query->have_posts() ) {

									while ( $query->have_posts() ) {

										$query->the_post();
						
										$theID = get_the_ID();?>

										<tr>

											<?php include( 'assets/candidate_title.php' ); ?>

											<td>

												<?php 
												if ( $query->post_count > 2 || $election_system == __( 'Plurality Voting',$this->plugin_name ) ) {
								
													if ( $max_select > $query->post_count ) {
									
														$rank_num = $query->post_count;
								
													} else {
								
														$rank_num = $max_select;
								
													} // end if max selection is greater than number of posts.

													for ( $i = 0; $i < $rank_num; $i++ ) { 

														include( 'assets/rcv_loop.php' );

													} // end for $i less than max ranking.

												} else {

													include( 'assets/pv_loop.php' );

												} // end if count is more 2 or voting method is plurality. ?>

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
            
							<?php echo get_post_field( 'post_content', $key ); ?>
			
            			</td>

					</tr>
				
                </table>

			<?php
    		} // end foreach race as key => value. ?>

			<br />
		
			<?php include_once( 'assets/submit_buttons.php' ); ?>

		</div>
	
    </form>

</div>

<?php include_once( 'assets/verify_container.php' ); ?>