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

global $wpdb;

(string)$userId;

$election;

$electurl = $_SERVER['REQUEST_URI'];

$race = array();

$voteArray = array();

$voteArray['election'] = $election;

$voteArray['voter'] = $userId;

$voteString = '';

$errorArray = array();

$table = $wpdb->prefix . "pv_votes";

ksort( $post );

foreach ( $post as $key => $value ) {
	
	if( $key == 'verifiedVote' || $key == 'action' || $key == 'election' ) {} else { 
		
		$raceRank = explode( "-", $key );
		
		$rank = 'rank'.$raceRank[1];
		
		if ( ! in_array( $raceRank[0], $race, true ) ) {
		
			$voteString = '';
		
		}
		
		$voteString .= $value.' ';
		
		if( in_array( $raceRank[0], $race, true ) ) {
		
			if( $wpdb->update( 
			
				$table, 
			
				array( 
			
					$rank => $value, 
			
					'voteArray' => trim( $voteString )
			
				), 
			
				array( 
			
					'voter' => $userId, 
			
					'election' => $election,
			
					'race' => $raceRank[0], 
			
				)
			
			) ) {
				
				$voteArray[$raceRank[0]][$raceRank[1]] = $value;
			
			} else {
			
				$errorArray[$raceRank[0]][$raceRank[1]] = $value;
				
			} // end if vote has been updated in the database.
		
		} else { 
		
			if( $wpdb->insert( 
				
				$table, 
				
				array( 
				
					'voter' => $userId, 
				
					'election' => $election,
				
					'race' => $raceRank[0],
				
					$rank => $value
				
				) 
			
			) ) {
			
				$voteArray[$raceRank[0]][$raceRank[1]] = $value;
			
			} else {
			
				$errorArray[$raceRank[0]][$raceRank[1]] = $value;
				
			} // end if vote has been inserted in the database.
		
		} // end if race has already been inserted in the database to prevent duplication.
		
		array_push( $race, $raceRank[0] );
		
	} // end if key is verifyVote, action, or election (to exclude them).		

} // end foreach loop for post data.

if( count( $errorArray ) > 0 ) {

	$result = $wpdb->get_results (
        "
        SELECT * 
        FROM  wp_pv_votes 
        WHERE election =  $election
		AND voter = $userId
        "
    );

	foreach ( $result as $r ) {
		
		$wpdb->delete( 'wp_pv_votes', array( 'id' => $r->id ) );	
	
	} // end foreach to delete vote entry when there is an error.
	
	echo __( 'There was an error while submitting your votes. Please try voting again.', $this->plugin_name ).' <a href="'.$electurl.'">'.__( 'GO TO ELECTION', $this->plugin_name ).'</a>';

} else {
	
	if ( is_user_logged_in() ) {
		
		$history = get_user_meta( $userId, 'vote_history', false );
		
		$newHistory[$election]  = $voteArray;
		
		if ( isset( $history ) ) {
			
			update_user_meta( $userId, 'vote_history', $newHistory );
		
		} else {
			
			add_user_meta( $userId, 'vote_history', $newHistory, true );  
		
		}
		
		_e( 'Your vote was successfully submitted. Thank you for voting.', $this->plugin_name );
	
		echo '<hr />';
	
		echo '<h3><center>' . __( 'YOUR VOTE', $this->plugin_name ) . '</h3></center>';
	
		$this->voteRecord( get_userdata( (int)$userId ), $election );
	
	} else { 
	
		_e( 'Your vote was successfully submitted. Thank you for voting.', $this->plugin_name );
				
	} // end if the user is logged in.

} // end if there are errors. ?>