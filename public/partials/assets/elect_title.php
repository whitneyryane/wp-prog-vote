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
 
$max_select = get_post_meta( $atts['id'], 'pv_election_max_select', true );

$es = get_post_meta( $atts['id'], 'pv_election_system', true );

if ( $es == 'RCV' ) {
	
	$election_system = __( 'Ranked Choice Voting', $this->plugin_name );
	
} else if ( $es == 'AV' ) {
	
	$election_system = __( 'Approval Voting', $this->plugin_name );
	
} else if ( $es == 'RV' ) {
	
	$election_system = __( 'Range Voting', $this->plugin_name );
	
} else if ( $es == 'PV' ){
	
	$election_system = __( 'Plurality Voting', $this->plugin_name );
	
} ?>
		
<h2>

	<?php echo get_the_title( $atts['id'] ); ?>

</h2>
		
<?php 
if ( $es ) { 
		
	echo $election_system;
			
	if ( $es != 'PV' ) { 
	
		echo ' ('.$max_select.' '.__( 'rank maximum', $this->plugin_name ).')';
		
	} // end if election system is plurality.
		
} // end if election system is set. ?>

<br />