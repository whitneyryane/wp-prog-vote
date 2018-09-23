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

if ( !is_user_logged_in() && get_post_meta( $atts['id'], 'pv_election_data_voter_only', true ) ) {
				
							_e( 'You must be logged in and have permission to view the election data.', $this->plugin_name );
					
							echo '<hr />';
							
							echo'<h3>'.__( 'Login Form', $this->plugin_name ).'</h3>';
					
							wp_login_form();
					
							echo '<a href="'.wp_lostpassword_url( get_permalink() ).'" title="Lost Password">'.__( 'Lost Password', $this->plugin_name ).'</a>';
					
						} else {

							if ( $this->canVote( $atts['id'] ) || !get_post_meta( $atts['id'], 'pv_election_data_voter_only', true ) ) { ?>
                            
<h1>

	This page is under development.
    
</h1>

<hr />

<h2>

	This page will provide access to vote data in a future update.

</h2>

<?php 	} else {

			_e( 'You do not have permission to view the election data.', $this->plugin_name );

		} // End check if can vote

	} // End check if logged in ?>