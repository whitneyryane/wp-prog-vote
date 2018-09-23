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
		'tr'	// array tracking results.
		'rd' 	// array of redistribution.
		'tl' 	// total number of votes.
		'c' 	// all candidates for this race.
		'mw' 	// if race is multi winner.
		'wc' 	// number of winners.
		'th' 	// the threshold for winning.
		'mr' 	// maximum number of ranks for a race.
	); */

	$c = $r['va'];

	$ca = array();

	if ( count ( $r['ec'] ) ) {
		
		$k  = explode( ',' , $c );
		
		if ( in_array( $k[0], $r['pc'] ) ) {
		
		}
		
	} else {
		
	} // end if any candidates have been eliminated.
	
	foreach ( $r['c'] as $c ) {
				
		$cid = $c->post_id;
		
		if ( in_array ( $cid , $r['e'] ) || in_array ( $cid.'e' , $r['e'] ) ) { } else {
			
			$ec = count( $r['e'] );
			
			if ( $ec > ( $r['mr'] - 1 ) ) { $ec = ( $r['mr'] - 1 ); }
			
			$query = 'SELECT id 
			FROM '.$wpdb->prefix.'pv_votes 
			WHERE race = '.$r['id'].'
			AND (';
			
			for ( $j = ( $ec + 1 ); $j > 0; $j-- ) {

				if ( $j > 1 ) { $query .= '('; }
	
				$query .= 'rank'.( $j ).' = '.$cid;
	
				if ( $j > 1 ) { $query .= ' AND '; }	

				for ( $k = $j - 1; $k > 0; $k-- ) {
	
					$query .= '(';
					
					$m = 0;

					for ( $l = ( count( $r['e'] ) - 1); $l >= 0; $l-- ) {
	
						if ( $k == ( $j - 1)) {
							
							if ( substr( $r['e'][$l], -1 ) == 'e' ) {
						
								if ( $m ) { $query .= ' OR '; }
						
								$query .= 'rank'.( $k ).' = '.$r['e'][$l];
							
								$m++;
							}
						
						} else {
							
							$query .= 'rank'.( $k ).' = '.$r['e'][$l];
		
							if ( $l > 0 && $k != ( $j - 1)) { $query .= ' OR '; }
							
						}
						
					} // end for running through each eliminated candidate.

					$query .= ')';

					if ( $k > 1 ) { $query .= ' AND '; }

				} // end for itterating through ranks as $k.

				if ( $j > 1 ) { $query .= ')'; }

				if ( $j > 1 ) { $query .= ' OR '; }	

			} // for $j > 0.

			$query .= ')';
		
			$vc = $wpdb->query( $query );
			
			$r['temp'][$cid] = $vc;
		
		} // end if candidate has been eliminated skip else form query.	
		
		$ca[$cid] = $vc;	
		
	} // end foreach candidate as $c.
	
	if ( count( $r['ta'] ) > 0 ) {
	
		foreach ( $ca as $k => $v ) {
			
			$r['ta'][$k] = $v;
			
		}

	} else {
	
		foreach ( $r['ta'] as $k => $v ) {
			
			if( isset( $ca[$k] ) ) {
			
				$r['ta'][$k] += $ca[$k];
				
			} else { unset( $r['ta'][$k] ); }
			
		}
	
	}
	
	$r['tl'] = array_sum( $r['ta'] );
	
	arsort( $r['ta'] );
	
	foreach ( $r['ta'] as $k => $v ) {
			
		if ( ( ( $v / $r['tl'] ) * 100 ) > $r['th'] ) {
			
			$r = $this->redistribute( $k , $r );	
			
		}
	
	}
	
	// FROM there down.
		
	if ( count( $r['e'] ) < ( count( $r['c'] ) - 1 ) ) {
			
		return $r;
	
	} else {
	
		return false;
		
	} // end if all but one candidate has been eliminated.
	
} // end next_tab_round function.


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
				
				'tr'	=> 	array(),// array tracking results.
		
				'rd'	=>	array() // array of redistribution.
		
			);
			
			// getting candidates object array.
			$ra['c'] 	= 	$this->get_candidates( $ra['id'] );
			
			foreach ( $r['c'] as $c ) {
			
				array_push( $ra['pc'], $c->post_id );	
			
			}
	
			// total number of votes.			
			$ra['tl']	=	array_sum ( $ra['va'] );
		
			// determining if the race is multi-winner.
			$ra['mw']	= 	get_post_meta( $ra['id'], 'pv_race_multi_winner', true );
		
			if ( $ra['mw'] ) {
			
				// variable with the number of winners if multi-winner.
				$ra['wc']	=	(int)get_post_meta( $ra['id'], 'pv_race_winner_count', true );
			
			} else {
			
				// variable with the value of one if not multi-winner.
				$ra['wc'] 	= 	1;  
			
			} // end if race is mutli-winner.
		
			// The number of votes needed to win the election.
			$ra['th'] = ( ( ( 100 / ( $ra['wc'] + 1 ) ) * $ra['tl'] ) + 1 );  
	
			if ( $args['mr'] > count( $ra['c'] ) ) {
		
				$ra['mr'] = count( $ra['c'] );		
		
			} else { 
		
				$ra['mr'] = $args['mr']; 
			
			} // if max rank is larger than the number of candidates, then max rank for the race is equal to the number of candidates.
	
			if ( count( $ra['c'] ) > 1 ) {
			
				while ( $rt = $this->next_tab_round( $ra ) ) {
					// continue here after returning from function a not false value.
				
					$ra = $rt;
				
					$args['tab'][$ra['id']][( $ra['i'] - 1 )] = $ra['ta'];
						
					$total = array_sum ( $ra['ta'] );
				
					foreach ( $ra['rt'] as $key => $value ) {
							
						$keysVals = array(
							
							'election'	=> 	(int)$args['eid'],
							
							'race' 		=> 	(int)$ra['id'],
							
							'candidate' => 	(int)$key,
							
							'round' 	=> 	(int)$ra['i'],
							
							'number' 	=>	(int)$value,
								
							'total' 	=> 	(int)$total,
							
							'percent' 	=> 	(int)( ( $value / $total ) * 100 )
							
						);
							
						if ( in_array( $key, $ra['e'] ) ) {
							
							$keysVals['eliminated'] = 1;
							
						} else {
							
							$keysVals['eliminated'] = 0;	
							
						}
												
						if ( $keysVals['percent'] > ( 100 / ( (int)$ra['wc'] + 1 ) ) ) {
							
							// ADD CODE FOR REALLOCATION
							$rd = $this->get_redistribution( $ra );
												
							$keysVals['won'] = 1;
							
						} else {
								
							$keysVals['won'] = 0;
							
						}
					
						// make id => number array
					
						/*asort( $ca );
						
						$el = current( array_keys ( $ca ) );
				
						$e = array_intersect( $ca , array( $ca[$e] ) );
		
						foreach ( $e as $key => $val ) { $e[$key] = $val.'e'; }
					
						foreach ( $ra['e'] as $ke => $val ) {
					
							if ( substr( $val, -1 ) == 'e' ) { $ra['e'][$ke] = substr( $val, 0, -1 ); }
						
						}
						
						// Code for eliminated candidates.				
						$ra['e'] = array_merge( $ra['e'] , array_keys($ra['rt'][0]) ); */ 
							
						$query = 'SELECT id 
							FROM wp_pv_results 
							WHERE race = '.$keysVals['race'].'
							AND candidate = '.$keysVals['candidate'].'
							AND round = '.$keysVals['round'];
	
						if ( $wpdb->query( $query ) ) { } else {
						
							if ( $wpdb->insert( $wpdb->prefix.'pv_results', $keysVals ) ) { } else {
									
								$error[$keysVals['candidate'].'-'.$keysVals['round']] = $keysVals;
								
							}
							
						}
						
					}
						
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
							
						}
						
					}
			
				}	
		
			} // end if there is more than one candidate for the race.
		
		} // end foreach race as $r.

	} // end if tabulation has already been run.

} // end function


/**
*  runs the redistribution of votes.
*
*
* @since    1.0.0
*/
function redistribute( $id , $r ) {
	
	global $wpdb;
	
	/*
	$r = array(
		'id' 	// race id.
		'i' 	// round iteration.
		'va' 	// array of comma separated votes and counts
		'ec' 	// eliminated candidates array.
		'pc' 	// pending candidate array.
		'wc' 	// winning candidate array
		'rd' 	// array of redistribution.
		'tl' 	// total number of votes.
		'c' 	// all candidates for this race.
		'mw' 	// if race is multi winner.
		'wc' 	// number of winners.
		'th' 	// the threshold for winning.
		'mr' 	// maximum number of ranks for a race.
	);
	*/
	
	$ret = (int)$r['ta'][$id] - ( ( (int)$r['th'] / 100 ) * (int)$r['tl'] ); // the number of votes that need to be redistributed.
	
	if ( count( $r['e'] ) > 0 ) {
	
		$cases = '';
	
			
	
		$query = "SELECT ( CASE ".$cases. 
        
		//WHEN ... THEN ...
    
		"END ) as cid, count(*) 
		
		FROM ".$wpdb->prefix."pv_votes 
		
		WHERE race = 541 
		
		GROUP BY 
		
		( CASE ".$cases. 
        
		//WHEN ... THEN ...
    
		" END )";
	
	} else {
		
		$query = "SELECT rank2, count(*) 
		
		FROM ".$wpdb->prefix."pv_votes 
		
		WHERE race = ".$r['id']." 
		
		AND rank1 = ".$id." GROUP BY rank2";

		$red = $wpdb->get_results( $query, 'ARRAY_N' );
		
		foreach ( $red as $rd ) {
			
			$r['rd'][$id][$rd[0]] = ( (int)$rd[1] / (int)$r['ta'][$id] ) * $ret;
			
			$r['ta'][$rd[0]] += $r['rd'][$id][$rd[0]];
			
			$r['ta'][$id] -= $r['rd'][$id][$rd[0]];
			
			if ( $r['ta'][$rd[0]] > $r['th'] ) { $r = $this->redistribute( $rd[0] , $r ); }
			
		}
	
	}

	return $r;
	
} // end redistribute function.

?>