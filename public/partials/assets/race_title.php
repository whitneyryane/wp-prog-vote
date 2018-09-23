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
?>		

<tr>

    <th>
    
        <?php 
        echo $value[0].' <small style="float:right;">|';
        
        if ( $query->post_count > 2 ) {
        
            if ( !$value[1] ) {
				
				$vm = $election_system;
		
			} else if ( $value[1] == 'SAE' ) {
				
				$vm = $election_system;
				
			} else if ( $value[1] == 'RCV' ) {
				
				$vm = __( 'Ranked Choice Voting', $this->plugin_name );
				
			} else if ( !$value[1] == 'AV' ) {
				
				$vm = __( 'Approval Voting', $this->plugin_name );
				
			} else if ( !$value[1] == 'RV' ) {
				
				$vm = __( 'Range Voting', $this->plugin_name );
				
			} else if ( !$value[1] == 'PV' ) {
				
				$vm = __( 'Plurality Voting', $this->plugin_name );
				
			}
            
        } else {
			
			$vm = __( 'Plurality Voting', $this->plugin_name );
			
		}
        
        echo $vm;

        if ( $vm == __( 'Ranked Choice Voting', $this->plugin_name ) ) {
            
            if ( $value[2] == 'yes' ) {
            
                if ( ( int )$value[3] > 1 ) {
            
                    echo '|'.__( 'Multi-Winner', $this->plugin_name ).' ('.$value[3].')';
            
                }
				
            }
			
        }

        echo '|</small>';
        
        ?>
        
    </th>

</tr>