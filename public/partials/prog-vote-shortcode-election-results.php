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

if ( !is_user_logged_in() && get_post_meta( $atts['id'],'pv_election_results_voter_only', true ) ) {
				
	_e( 'You must be logged in and have permission to view these election results.', $this->plugin_name );

	echo '<hr />';

	echo'<h3>'.__( 'Login Form', $this->plugin_name ).'</h3>';

	wp_login_form();

	echo '<a href="'.wp_lostpassword_url( get_permalink() ).'" title="Lost Password">'.__( 'Lost Password', $this->plugin_name ).'</a>';

} else {

	if ( $this->canVote( $atts['id'] ) || !get_post_meta( $atts['id'], 'pv_election_results_voter_only', true ) ) {
		
		if ( $this->voteTimeClose( $atts['id'] ) ) {

			if (  get_post_meta( $atts['id'], 'tabulated', true ) ) { ?>

<style> 

.rounds_table { 

	display:none; 
	
} 

div.toggle_rounds_table { 

	margin-bottom:5px; 
	
	cursor:pointer; 
	
} 

div.toggle_rounds_table div { 

	width:35px; 
	
	height:4px; 
	
	background-color:black; 
	
	margin:4px auto; 
	
}

</style>

<h2>

	<?php echo get_the_title( $atts['id'] ); ?>
    
    <br />
    
    <small><?php _e( 'ELECTION RESULTS', $this->plugin_name ); ?></small>
    
</h2>

<hr />

<table>
	
	<?php
	
	$output = array(); 
	
	$results = $this->get_election_results( $atts['id'] );
    
	$i = 0;
	
	$wonArray = array();
	
	foreach ( $results as $r ) {
	
		$output[$r->race][$r->round][$r->id] = array( 'candidate' => $r->candidate, 'number' => round ( $r->number, 2 ), 'total' => $r->total, 'percent' => round ( $r->percent, 2 ), 'won' => $r->won );
		
		if ( !in_array( $r->candidate, $wonArray ) && $r->won == 1 ) {
		
			$output[$r->race]['won'][$i] = array($r->candidate,$r->percent);
			
			array_push( $wonArray, $r->candidate );
			
			$i++;
				
		}
		
	}
	
	foreach ( $output as $k => $v ) { 
	
		asort($v); ?>
        	
		<tr>
    	
    	    <th>
        
    	    	<center>
        
    	    		<?php
    	            echo '<strong>'.get_the_title( $k );
			
					if ( get_post_meta( $k, 'pv_race_multi_winner', true ) == 'yes' ) { echo ' <small>['.get_post_meta( $k, 'pv_race_winner_count', true ).' '.__( 'Winners' ).']</small>'; }
				
					echo '</strong>'; ?>
        
        		</center>
     	
        	</th>
    
    	</tr>
     
    	<?php foreach ( $output[$k]['won'] as $won) { ?>
    
        	<tr>
            
        	    <td style="background-color:#3C3; color:#FFF">
            
        	        <center>
                
        		        <strong>
            
            			    <?php echo get_the_title( $won[0] ).' &#10004;  ('.$won[1].'%)';?>
            
                		</strong>
            
 	               </center>
            
    	        </td>
        
        	</tr>

		<?php } ?>

    	<tr>

    		<td>
            
        	    <div class="toggle_rounds_table">
            	
        	        <div></div>

					<div></div>

					<div></div>
			
        	    </div>

				<div class="rounds_table">	
            
        	        <table> 
                        
                        <?php 
                        foreach ( $v as $a => $b ) {
                            
        	                if ( $a == 'won' ) {} else {?>
                            
        		                <tr>
                        
                		            <td colspan="6">
                        
                    		            <center>
                        
                        		            <em>
                        
                            		            <?php echo __( 'Round', $this->plugin_name ).' '.$a;?>
                        
                                    		</em>
                        
                                		</center>
                        
                       	     		</td>
                        
                        		</tr>
                        
                        		<tr>    
                                    
                            		<td>
                                    
                                    	<small><?php echo __( 'CANDIDATE', $this->plugin_name );?></small>
                                        
                                  	</td>
                            
                            		<td>
                                    
                                    	<small><?php echo __( 'VOTE COUNT', $this->plugin_name );?></small>
                                        
                                  	</td>
                            
                            		<td>
                                    
                                    	<small><?php echo __( 'TOTAL VOTES', $this->plugin_name );?></small>
                                        
                                  	</td>
                            
                            		<td>
                                    
                                    	<small><?php echo __( '% OF VOTE', $this->plugin_name );?></small>
                                        
                                   	</td>
                            
                            		<td>
                                    
                                    	<small><?php echo __( 'WON?', $this->plugin_name );?></small>
                                        
                                  	</td>
                        
                        		</tr>
                        
                        		<?php 
                        		foreach ( $b as $c ) { 
                        
									arsort($c);
						
                        			$style = '';
                        
                        			if ( $c['won'] ) { 
                        
                            			$style = ' style="background-color:#CFC;"';
									
									} ?>
                        
                        			<tr>    
                                    
                            			<td<?php echo $style; ?>>
										
											<?php echo get_the_title($c['candidate']);?>
                                            
                                      	</td>
                            
                            			<td<?php echo $style; ?>>
										
											<?php echo $c['number'];?>
                                            
                                      	</td>
                            
                            			<td<?php echo $style; ?>>
										
											<?php echo $c['total'];?>
                                            
                                      	</td>
                            
                            			<td<?php echo $style; ?>>
										
											<?php echo $c['percent'].'%';?>
                                            
                                       	</td>
                            
                            			<td<?php echo $style; ?>>
										
											<?php 
											echo 'Won: '; 
											
											if ($c['won']){
												
												echo 'YES';
												
											} else {
												
												echo 'NO';
												
											}?>
                                            
                                       	</td>
                        
                        			</tr>
                        
                        		<?php } 
								
							} 
								
						}?>
                        
                	</table>
            
            	</div>

    		</td>

    	</tr>
	
	<?php }?>
    
</table>

<script type="text/javascript"> 

(function($){

    $('.toggle_rounds_table').on('click',function(){

        var table = $(this).parent('td').children('.rounds_table');

        if(table.is(':visible')){

            table.slideUp('slow','swing');

        } else {

            table.slideDown('slow','swing');

        }

    });

})( jQuery );

</script>

<?php } else {
				
				echo '<h3>'.__( 'The results for this election have not yet been tabulated.', $this->plugin_name ).'</h3>';
				
				echo '<p>'.__( 'Further action is need to be taken by the election administrator for this election\'s results to be available. If you have any question please contact the election administrator.', $this->plugin_name ).'</p>';
			
			}
			
		} else {
			
			echo '<h3>'.__( 'The election has not yet concluded.', $this->plugin_name ).'</h3>';
		
		}

	} else {

		echo '<h3>'.__( 'You do not have permission to view these election results.', $this->plugin_name ).'</h3>';

	} // End check if can vote

} // End check if logged in ?>