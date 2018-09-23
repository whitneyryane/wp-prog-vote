<?php

/**
*  runs the rounds of tabulation.
*
*
* @since    1.0.0
*/
function next_tab_round( $r ) {
	
	/* $r = array(
		'id'	// race id.
		'i' 	// round iteration.
		'va' 	// array of comma separated votes and counts
		'ec' 	// eliminated candidates array.
		'pc' 	// pending candidate array.
		'wc' 	// winning candidate array.
		'rm'	// array with results makeup.
		'tr'	// array tracking results.
		'rd' 	// array of redistribution.
		'tl' 	// total number of votes.
		'c' 	// all candidates for this race.
		'mw' 	// if race is multi winner.
		'nw' 	// number of winners.
		'th' 	// the threshold for winning.
		'mr' 	// maximum number of ranks for a race.
	); */

	if ( count( $r['wc'] ) < $r['nw'] ) {

		if ( $r['i'] > 1 ) {
		
			$tr = $r['tr'];
			
			asort( $tr );
						
			$el = current( array_keys ( $tr ) );
				
			$e = array_intersect( $tr , array( $tr[$el] ) );
			
			if ( count( $e ) > 1 ) {
				
				global $wpdb;
				
				$finalE = false;
				
				$compE = array();
				
				$iE = 1;
				
				while ( ! $finalE ) {
				
					if ( $iE <= $r['mr'] ) {
						
						$ee = $e;
								
						foreach ( $ee as $ke => $va ) {
							
							$q = $wpdb->query( 'SELECT id FROM '.$wpdb->prefix.'pv_votes WHERE race = '.$r['id'].' AND rank'.$iE.' = '.$ke ); 
							
							$compE[$ke] = $q;
							
						} // end foreach potential eliminated.
						
						asort( $compE );
						
						$cel = current( array_keys ( $compE ) );
				
						$ce = array_intersect( $compE , array( $compE[$cel] ) );
						
						if ( count( $ce ) > 1 ) {
							
							$ee = $ce;
							
							$iE++;
						
						} else {
							
							$finalE = $ce;
						
						} // if there is more than one candidate tied for last place for the rank.
					
					} else {
						 
						$finalE = $compE;
					
					} // if current rank <= the max rank.
					
				} // end while finalE false.
				
				$e = array_keys( $finalE );
				
			} // if more than one candidate is tied for last place.
		
			foreach ( $e as $val ) {
						
				$r = $this->redistribute( $r, $val );	

			} // end foreach eliminated as key => val.

		} else {

			$v = $r['va'];
 	
			foreach ( $v as $key => $val ) {	
				
				$k  = explode( ', ' , $key );
					
				$r['rm'][$k[0]][$key] = $val;
			
			} // end foreach rank vote groups value pair. 
			
			foreach ( $r['pc'] as $c ) {
			
				$r['tr'][$c] =	array_sum( $r['rm'][$c] );  		
			
			} // end foreach pending candidate.
		
		} // end if past first round.
	
		return $r;

	} else { 
	
		return false; 
		
	} // end if number of winning candidates is less than number of positions. 
	
} // end next_tab_round function.



/**
*  runs the redistribution of votes.
*
*
* @since    1.0.0
*/
function redistribute( $r, $el = false ) {
	
		/* $r = array(
		'id'	// race id.
		'i' 	// round iteration.
		'va' 	// array of comma separated votes and counts
		'ec' 	// eliminated candidates array.
		'pc' 	// pending candidate array.
		'wc' 	// winning candidate array.
		'rm'	// array with results makeup.
		'tr'	// array tracking results.
		'rd' 	// array of redistribution.
		'tl' 	// total number of votes.
		'c' 	// all candidates for this race.
		'mw' 	// if race is multi winner.
		'nw' 	// number of winners.
		'th' 	// the threshold for winning.
		'mr' 	// maximum number of ranks for a race.
	); */
	
	if ( $el ){
		
		if ( ! is_array( $el ) ) { $el = array( $el ); }

		foreach ( $el as $e ) {
			
			array_push( $r['ec'], $e );
						
			$can = array_search($e, $r['pc']);
						
			unset( $r['pc'][$can] );
			
			foreach ( $r['rm'][$e] as $ke => $va ) {
					
				$rmArray = explode( ', ', $ke );
				
				$ind = array_search($e, $rmArray);
				
				for ( $i = $ind + 1; $i != 0; $i++ ) {
					
					if ( in_array( $rmArray[$i], $r['pc'] ) ) {
						
						$r['rm'][$e][$ke] -= $va;
						
						$r['rm'][$rmArray[$i]][$ke] = $va;
				
						$r['rd'][$e][$ke] = $va;
						
						$r['tr'][$e] -= $va;
						
						$r['tr'][$rmArray[$i]] += $va;
													
						$i = 0;
						
					} else { 
						
						$i++; 
						
						if ( ! isset( $rmArray[$i] ) ) {
						
							$i = 0;
						
						} // end if there are no more ranked candidates.
						
					} // end if next candidate not won or eliminated.
				
				} // end for index loop.
			
			} // end foreach results makeup as key => value.
		
		} // end foreach eliminated candidates array.
			
	} else {
		
		foreach ( $r['tr'] as $key => $val ) {
			
			if ( $val > $ra['th'] ) {
								
				if ( ! in_array( $key, $r['wc'] ) ) {
			
					array_push( $r['wc'], $key );
					
					$can = array_search($key, $r['pc']);
					
					unset( $r['pc'][$can] );
					
					$cr = 1 - ( $ra['th'] / $val );
					
					foreach ( $r['rm'][$key] as $ke => $va ) {
					
						$rmArray = explode( ', ', $ke );
						
						$ind = array_search($key, $rmArray);
						
						for ( $i = $ind + 1; $i != 0; $i++ ) {
							
							if ( in_array( $rmArray[$i], $r['pc'] ) ) {
							
								$tran = $va * $cr;
								
								$r['rm'][$key][$ke] -= $tran;
								
								$r['rm'][$rmArray[$i]][$ke] = $tran;
						
								$r['rd'][$key][$ke] = $tran;
								
								$r['tr'][$key] -= $tran;
								
								$r['tr'][$rmArray[$i]] += $tran;
															
								$i = 0;
								
							} else { 
								
								$i++; 
								
								if ( ! isset( $rmArray[$i] ) ) {
								
									$i = 0;
								
								} // end if there are no more ranked candidates.
								
							} // end if next candidate not won or eliminated.
						
						} // end for index loop.
					
					} // end foreach results makeup as key => value.
				
				} // end if candidate is not already in winner array.
				
			} // end if vote count is greater than threshold.
	
		} // for each result as key => val.

	} // end if eliminated id included.
	
	return $r;
	
} // end redistribute function.



/**
*  function intitiates tabulation and sets variables.
*
*
* @since    1.0.0
*/
function tab_election(){
	$args = array(
		
		'eid' 	=> 	$electionId,
		
		// get the maximum number of ranks.
		'mr' 	=>	get_post_meta( $electionId, 'pv_election_max_select' , true ),
		
		// associative array for tabulation.
		'tab'	=> 	array()
		
	);	

	if ( get_post_meta( $electionId, 'tabulated', true ) ) {
			
		echo '<center><strong>'.__( 'You cannot tabulate this election again. This election\'s results have been tabulated. They are available at the following url:', 'prog-vote' ).' <a href="'.get_site_url().'/vote-results/?electionId='.$args['eid'].'" target="_blank" >'.get_site_url().'/vote-results/?electionId='.$args['eid'].'</a></center></strong>';	
	
		wp_die();
			
	} else { 
	
		global $wpdb;
	
		// races object for election.
		$args['r'] 	= 	$this->get_races( $args['eid'] ); 
	
		foreach( $args['r'] as $r ) { 
		
			// votes in a comma separated value string ordered by rank.
			$votearray = $wpdb->get_results('SELECT votearray, count(*) FROM '.$wpdb->prefix.'pv_votes WHERE race = '.$r->post_id.' GROUP BY votearray', 'ARRAY_N');

			// totoal number of votes for race.
			$votetotal = $wpdb->query('SELECT votearray FROM '.$wpdb->prefix.'pv_votes WHERE race = '.$r->post_id);
	
			$va = array();
	
			foreach ( $votearray as $v ) {
			
				$va[$v[0]] = $v[1];
			
				$query = 'SELECT id 
					FROM wp_pv_results 
					WHERE race = '.$r->post_id.'
					AND candidate = '.$v[0].'
					AND round = 0';
	
				if ( $wpdb->query( $query ) ) { } else {
				
					$keyVals = array (
					
						'election' 		=> 	$args['eid'],
						
						'race'			=>	$r->post_id,
						
						'candidate'		=>	$v[0],
						
						'round'			=>	0,
					
						'number'		=> 	$v[1],
						
						'total'			=>	$votetotal,
						
						'percent'		=>	( ( $v[1] / $votetotal ) * 100 ),
						
						'eliminated'	=>	0,
						
						'won'			=> 	0,
						
						'redistribute'	=>	''
					
					);
					
					if ( $wpdb->insert( $wpdb->prefix.'pv_results', $keyVals ) ) { 
					
					} else {
								
						$error[$v[0].'-0'] = $v[1];
							
					} // end if insert results.
						
				} // end if value already exists.
			
			} // end foreach vote array [0] = vote, [1] = quanitity
		
			// value that denotes if the race is still tabulating.
			$rt	= 1;

			$ra = array(
	
				'id'	=> 	$r->post_id, // race id.
	
				'i'		=> 	1, // round iteration.
		
				'va'	=> $va, // the vote array.
	
				'ec'	=>	array(), // eliminated candidates array.
			
				'pc'	=> 	array(), // pending cadidates array.
		
				'wc'	=> 	array(), // winning candidates array.
				
				'rm'	=> 	array(), // array with results makeup.
				
				'tr'	=> 	array(),// array tracking results.
		
				'rd'	=>	array() // array of redistribution.
		
			);
			
			// getting candidates object array.
			$ra['c'] 	= 	$this->get_candidates( $ra['id'] );
			
			foreach ( $r['c'] as $c ) {
			
				array_push( $ra['pc'], $c->post_id );	
			
			} // end foreach candidate.
	
			// total number of votes.			
			$ra['tl']	=	array_sum ( $ra['va'] );
		
			// determining if the race is multi-winner.
			$ra['mw']	= 	get_post_meta( $ra['id'], 'pv_race_multi_winner', true );
		
			if ( $ra['mw'] ) {
			
				// variable with the number of winners if multi-winner.
				$ra['nw']	=	(int)get_post_meta( $ra['id'], 'pv_race_winner_count', true );
			
			} else {
			
				// variable with the value of one if not multi-winner.
				$ra['nw'] 	= 	1;  
			
			} // end if race is mutli-winner.
		
			// The number of votes needed to win the election.
			$ra['th'] = ( ( ( ( 100 / ( $ra['nw'] + 1 ) ) / 100 ) * $ra['tl'] ) + 1 );  
	
			if ( $args['mr'] > count( $ra['c'] ) ) {
		
				$ra['mr'] = count( $ra['c'] );		
		
			} else { 
		
				$ra['mr'] = $args['mr']; 
			
			} // if max rank is larger than the number of candidates, then max rank for the race is equal to the number of candidates.
	
			if ( count( $ra['c'] ) > 1 ) {
			
				while ( $rt = $this->next_tab_round( $ra ) ) { //-----------------------------------------------------------------------------------------
					// continue here after returning from function a not false value.
				
					$ra = $rt;
				
					$ra = $this->redistribute( $ra );					
				
					$args['tab'][$ra['id']][$ra['i']]['totals'] = $ra['tr'];
					
					$args['tab'][$ra['id']][$ra['i']]['makeup'] = $ra['rm'];
					
					$args['tab'][$ra['id']][$ra['i']]['eliminated'] = $ra['ec'];
					
					$args['tab'][$ra['id']][$ra['i']]['won'] = $ra['wc'];
			
					foreach ( $ra['tr'] as $key => $value ) {
						
						$keysVals = array(
							
							'election'	=> 	$args['eid'],
							
							'race' 		=> 	$ra['id'],
							
							'candidate' => 	$key,
							
							'round' 	=> 	$ra['i'],
							
							'number' 	=>	$value,
								
							'total' 	=> 	$ra['tl'],
							
							'percent' 	=> 	( ( $value / $ra['tl'] ) * 100 )
							
						);
							
						if ( in_array( $key, $ra['ec'] ) ) {
							
							$keysVals['eliminated'] = 1;
							
						} else {
							
							$keysVals['eliminated'] = 0;	
							
						} // end if candidate is in the eliminated array.
												
						if ( in_array( $key, $ra['wc'] ) ) {
							
							$keysVals['won'] = 1;
							
						} else {
								
							$keysVals['won'] = 0;
							
						} // end if candidate is in winner array.
						
						if ( isset( $ra['rd'][$key] ) ) {
							
							$keysVals['redistribute'] = $ra['rd'][$key]; 
							
						} // end if redistribut is set.
							
						$query = 'SELECT id 
							FROM wp_pv_results 
							WHERE race = '.$keysVals['race'].'
							AND candidate = '.$keysVals['candidate'].'
							AND round = '.$keysVals['round'];
	
						if ( $wpdb->query( $query ) ) { } else {
						
							if ( $wpdb->insert( $wpdb->prefix.'pv_results', $keysVals ) ) { } else {
									
								$error[$keysVals['candidate'].'-'.$keysVals['round']] = $keysVals;
								
							} // end if instered into database.
							
						} // end if already exists in the database.
						
					} // foreach tracked result as key => value.
						
					$ra['i']++;
				
				} // end while rounds of tabulation are still needed.
		
			} else {
			
				foreach ( $ra['c'] as $c ) {
				
					$keysVals = array(
							
						'election' 		=>	(int)$args['eid'],
							
						'race' 			=>	(int)$ra['id'],
							
						'candidate' 	=> 	(int)$c->post_id,
							
						'round' 		=> 	1,
							
						'number' 		=> 	0,
							
						'total' 		=> 	0,
							
						'percent' 		=> 	0,
									
						'eliminated'	=> 	0,	
												
						'won' 			=> 	1,
					
						'redistribute'	=> 	0
				
					);			
				
					$query = 'SELECT id 
						FROM wp_pv_results 
						WHERE race = '.$keysVals['race'].'
						AND candidate = '.$keysVals['candidate'].'
						AND round = '.$keysVals['round'];
	
					if ( $wpdb->query( $query ) ) { } else {
					
						if ( $wpdb->insert( $wpdb->prefix.'pv_results', $keysVals ) ) { } else {
								
							$error[$keysVals['candidate'].'-'.$keysVals['round']] = $keysVals;
							
						} // end if insert candidate results is sucessful. 
						
					} // end if row for candidate already exists.
			
				} // end foreach candidate as c.	
		
			} // end if there is more than one candidate for the race.
		
		} // end foreach race as $r.

	} // end if tabulation has already been run.

} // end function

?>