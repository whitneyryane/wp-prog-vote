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
 
$election = $_POST['election'];

$_POST['verifiedVote'] = 1;

$race = array(); 
 
ksort($_POST); 
 
?>		

<h2><?php _e( 'Your Javascript is disabled', $this->plugin_name ); ?></h2>

<p><?php _e( 'You are seeing this confirmation form because your javascript is disabled. For the full experience of this website, please enable your javascript.', $this->plugin_name ); ?></p>

<h3><?php _e( 'Please verify your vote.', $this->plugin_name ); ?></h3>

<p><?php _e( 'If there are any errors in your vote, click <strong>EDIT</strong>, otherwise click <strong>CONFIRM</strong>.', $this->plugin_name ); ?></p>

<hr />

<form method="post" action="" >

<table>

	<tr>
    
    	<td>
			
			<h3>
				
                <center>
                
					<?php echo get_the_title( $election ); ?>
          	
            	</center>
            
            </h3>
            
        </td>
   	
    </tr>
    
    <tr>
    
    	<td>
        
        	<table>

			<?php 
            
            if ( count( $_POST ) > 2 ) {
	
				foreach ( $_POST as $key => $value ) {
		
					if ( $key == 'verifiedVote' || $key == 'election' ) { 
			
						echo '<input type="hidden" name="'.$key.'" value="'.$value.'" />';
						
					} else {
			
						$k = explode( '-', $key );
			
						echo '<input type="hidden" name="'.$key.'" value="'.$value.'" />'; ?>
			
						<tr>
							
							<th>
							
								<?php echo get_the_title( $k[0] ); ?>
					
							</th>
							
							<td>
							
								<?php echo $k[1]; ?>
					
							</td>
							
							<td>
							
								<?php echo get_the_title( $value ); ?>
					
							</td>
				
                		</tr>
                
				
					<?php }
	
				} ?>
			
            </table>
		
		<?php } else {

		}?>

	</table>			

	<input type="submit" value="CONFIRM" /> 

</form>

<form method="post" action=""><input type="submit" value="EDIT" style="background-color:#999;" /></form>