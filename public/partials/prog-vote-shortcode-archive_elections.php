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
 
$elections = get_elections_ids();

$archived = array();
 
if( count( $elections ) ){ 

	foreach( $elections as $e ){

		$race = get_races_ids( $e );

		if( count( $race ) ){ 

			$a = array();

			foreach( $race as $r ){ 

				$c = get_candidates_ids( $r ); 

				array_push( $a, $c ); 

			} // end foreach race as r.
			
			$ar=array_combine( $race, $a );
			
			$archived[(int)$e] = $ar;
			
		} else {
			
			$archived[] = (int)$e;
		
		} // end if there are races.
	
	} // end foreach elections as e.
	
} // end if there are elections. ?>

<table width="100%" cellpadding="10px" class="thin-border">
    	    
    <tr>
    
        <th>
		
			<?php _e( 'Election Archive', $this->plugin_name ); ?>
            
       	</th>
    
    </tr>
    
    <tr>
        
        <td>
		
			<?php 
            if ( count( $archived ) ) {
                
                foreach ( $archived as $a => $b ) {
                    
                    if ( !is_array( $b ) ) { $a = $b; } ?>
            
                    <div id="<?php echo $a; ?>" class="election_hold">
                        
                        <h5>
                        
                            <?php echo get_the_title( $a ); ?>
                            
                        </h5>
                        
                        <table>
                            
                            <tr>
                            
                                <th colspan="1">
                                
                                    <?php _e( 'Start Date', $this->plugin_name ); ?>
                                    
                                </th>
                                
                                <td colspan="1">
                                
                                    <?php echo get_post_meta( $a, 'pv_election_open_date', true ); ?>
                                    
                                </td>
                                
                                <th colspan="1">
                                
                                    <?php _e( 'Start Time', $this->plugin_name ); ?>
                                    
                                </th>
                                
                                <td colspan="1">
                                
                                    <?php echo get_post_meta( $a, 'pv_election_open_time', true ); ?>
                                    
                                </td>
                                
                            </tr>
                                
                            <tr>
                  
                                <th colspan="1">
                                
                                    <?php _e( 'End Date', $this->plugin_name ); ?>
                                    
                                </th>
                  
                                <td colspan="1">
                                
                                    <?php echo get_post_meta( $a, 'pv_election_close_date', true ); ?>
                                    
                                </td>
                  
                                <th colspan="1">
                                
                                    <?php _e( 'End Time', $this->plugin_name ); ?>
                                    
                                </th>
                  
                                <td colspan="1">
                                
                                    <?php echo get_post_meta( $a, 'pv_election_close_time', true ); ?>
                                    
                                </td>
                  
                            </tr>
                            
                            <tr>
                                
                                <th>
                                
                                    <?php _e( 'Races', $this->plugin_name ); ?>
                                    
                                </th>
                                
                                <td colspan="3">
                                
                                    <?php 
                                    if ( is_array( $b ) && count( $b ) ) { 
                                        
                                        foreach ( $b as $c => $d ) { ?>
                                    
                                            <div id="<?php echo $c; ?>" class="race_hold">
                                        
                                            <strong><em><?php echo get_the_title( $c ); ?></em></strong>
                                        
                                            <table>
                                                
                                                <tr>
                                                
                                                    <th>
                                                    
                                                        <?php _e( 'Candidates', $this->plugin_name ); ?>
                                                        
                                                    </th>
                                            
                                                </tr>
                                            
                                                <?php 
                                                if ( is_array( $d ) && count( $d ) ) {
                                                     
                                                    foreach ( $d as $e ) { ?>
                                                    
                                                        <tr>
                                                        
                                                            <td>
                                                            
                                                                <?php echo get_the_title( $e ); ?>
                                                                
                                                            </td>
                                                            
                                                        </tr>
                                            
                                                    <?php 
                                                    } // end foreach d as e.
                                                    
                                                } else { ?>
                                                
                                                    <tr>
                                                    
                                                        <td>
                                                        
                                                            <?php _e( 'There are no candidates assigned to this race.', $this->plugin_name ); ?>
                                                            
                                                        </td>
                                                        
                                                    </tr>
                                            
                                                <?php
                                                }?>
                                            
                                            </table>
                                                
                                        </div>
                                    
                                        <?php
                                        } // end foreach b as c => d.
                                        
                                    }else{?>
                                        
                                        <p>
                                        
                                            <?php _e( 'There are no races assigned to this election.', $this->plugin_name ); ?>
                                            
                                        </p>
                                        
                                    <?php
                                    } // end if there is b and b is array. ?>
                                    
                                </td>
                                
                            </tr>
                            
                        </table>
                        
                    </div>
        
                <?php 
                } // end foreach archived as a => b.
        
                /* Restore original Post Data */
                wp_reset_postdata();
                
            } else { ?>
                
                <p>
                
                    <?php _e( 'No archived elections currently exist.', $this->plugin_name ); ?>
                    
                </p>
                
           <?php
           } // end if there is archived.  ?>
           
        </td>
 
    </tr>
    
</table>

<?php
function get_elections_ids() {

	$today = current_time( 'Y-m-d H:i:s' );

	$data = array();

	$args = array(

		'post_type'  => 'pv_election',

		'meta_key'   => 'pv_election_close',

		'orderby'    => 'meta_value',

		'order'      => 'ASC',

		'meta_query' => array(

			array(

				'key'     => 'pv_election_close',

				'value'   => $today,

				'compare' => '<',

			),

		),

	);

	$query = new WP_Query( $args );
	
	if ( $query->have_posts() ) { 
		
		while ( $query->have_posts() ) {
		
			$query->the_post();
		
			$data[] = (int)get_the_ID();
		
		} // end while has posts.
		
	} // end if has posts.
	
	return $data;

} // end get_elections_ids function.

function get_races_ids( $id ) {

	$data = array();

	$args = array(

		'post_type'  => 'pv_race',

		'meta_key'   => 'pv_race_election',

		'orderby'    => 'meta_value',

		'order'      => 'ASC',

		'meta_query' => array(

			array(

				'key'     => 'pv_race_election',

				'value'   => $id,

				'compare' => 'IN',

			),

		),

	);

	$query = new WP_Query( $args );
	

	if ( $query->have_posts() ) { 

		while ( $query->have_posts() ) {

			$query->the_post();

			$data[] = (int)get_the_ID();

    	} // end while has posts.

	} // end if has posts.

	return $data;

} // end get_races_ids function.

function get_candidates_ids( $id ) { 
	
	$data = array();
	
	$args = array(
	
		'post_type'  => 'pv_candidate',
	
		'meta_key'   => 'pv_candidate_race',
	
		'orderby'    => 'meta_value',
	
		'order'      => 'ASC',
	
		'meta_query' => array(
	
			array(
	
				'key'     => 'pv_candidate_race',
	
				'value'   => $id,
	
				'compare' => 'IN',
	
			),
	
		),
	
	);
	
	$query = new WP_Query( $args ); 
	
	if ( $query->have_posts() ) { 
	
		while ( $query->have_posts() ) {
	
			$query->the_post();
    
	    	$data[] = (int)get_the_ID();
	
		} // end while has posts.
	
	} // end if has posts.
	
	return $data;

} // end get_candidates_ids function. ?>