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
 
if ( $current_user ) { } else { $current_user = wp_get_current_user(); }
		
if ( $current_user->vote_history && count( $current_user->vote_history ) > 0 ) {
		
	$history = $current_user->vote_history; 
		
	foreach ( $history as $key => $val ) { 

		if ( $election && $key == $election || !$election ) { ?>
			
			<table>
		
				<tr>
						
					<th>
				
						<h4>
								
							<center>
									
								<?php echo get_the_title( $val['election'] ); ?>
								
							</center>
								
						</h4>
				
					</th>
					
				</tr>
			
				<?php foreach ( $val as $ke => $va ) {?>

					<?php if ( $ke != 'election' && $ke != 'voter' ) { ksort( $va );?>

						<tr>
								
							<th>
							
								<?php echo get_the_title( $ke ); ?>

							</th>
	
						</tr>
				
						<tr>
					
							<td>
	
								<?php foreach ( $va as $k => $v ) { ?>
		
									<a href="<?php echo get_the_guid( $v ); ?>" target="_blank">

										<div style="float:left; margin:5px; padding:5px; border-left:thin solid; border-right:thin solid;">

											<?php echo $k.': '; echo get_the_title( $v ); ?>

										</div>

									</a>
						
								<?php } ?>                                
		
							</td>
	
						</tr>

					<?php } ?>

				<?php } ?>

			</table>

		<?php } // end if $election is set. ?>

	<?php } // end foreach $history as $key => $value.

} else { echo '<h5><center>'.__( 'None', $this->plugin_name ).'</center></h5>'; } // end if user has vote history. ?>