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
 
if ( !is_user_logged_in() ) {
				
	_e( 'You must be logged in to access your account.', $this->plugin_name );

	echo '<hr />';

	echo '<h3>'.__( 'Login Form', $this->plugin_name ).'</h3>';

	wp_login_form();

	echo '<a href="'.wp_lostpassword_url( get_permalink() ).'" title="Lost Password">'.__( 'Lost Password', $this->plugin_name ).'</a>';
		
} else {
		
	if ( $this->canVote() ) {?>

<style>

	.edit_profile {
	
		display:none;
	
	}

	#open_edit {
	
		cursor:pointer;
	
	}

</style>

<?php
$current_user = wp_get_current_user();

$photo_url = get_avatar_url( $current_user->ID ); ?>

<h2>

	<?php _e( 'Hello', $this->plugin_name ); ?> <span class="disp_title"><?php echo $current_user->title; ?></span> <span class="disp_first"><?php echo $current_user->first_name; ?></span> <span class="disp_last"><?php echo $current_user->last_name; ?></span>

</h2>
    
<div class="display_profile">
    
	<h3><?php _e( 'Our records show the following information:', $this->plugin_name ); ?></h3>
     
    <table>
    	
        <tr>
        	
            <th>
            
            	<?php _e( 'Profile Photo:', $this->plugin_name ); ?>
                
          	</th>
            
            <td>
            	
                <span class="profile_thumb"><?php if ( $photo_url ) { ?><img src="<?php echo esc_url( $photo_url ); ?>" class="thumbnail profile_photo" /><?php } else { echo '<strong>'.__( 'None', $this->plugin_name ).'</strong>'; } ?></span>
        
           	</td>
       
       	</tr>
            
       	<tr>
        
        	<th>
            
            	<?php _e( 'Website:', $this->plugin_name ); ?>
                
           	</th>
            
            <td>
            	
                <strong class="disp_website">
				
				<?php if ( $current_user->user_url ) { echo '<a href="'.$current_user->user_url.'" target="_new" >'.$current_user->user_url.'</a>'; } else { _e( 'None', $this->plugin_name ); } ?>
                
                </strong>
            
           	</td>
            
    	</tr>
   
        <tr>
        
        	<th>
            
            	<?php _e( 'Email:', $this->plugin_name ); ?>
                
           	</th>
            
            <td>
            	
                <strong class="disp_email">
				
				<?php if ( $current_user->user_email) { echo '<a href="mailto:'.$current_user->user_email.'" target="_new" >'.$current_user->user_email.'</a>'; }else { _e( 'None', $this->plugin_name ); } ?>
                
                </strong>
          
          	</td>
            
      	</tr>
        
        <tr>
        
        	<th>
            
            	<?php _e( 'Phone:', $this->plugin_name ); ?>
                
           	</th>
            
            <td>
            	
                <strong class="disp_phone"><?php if ( $current_user->phone ) { echo $current_user->phone; } else { _e( 'None', $this->plugin_name ); } ?></strong>
                
           	</td>
            
      	</tr>
        
        <tr>
        
        	<th>
            
            	<?php _e( 'Address:', $this->plugin_name ); ?>
                
           	</th>
            
            <td>
            	
                <strong class="disp_Address">
                        
                    <?php 
                    if ( $current_user->address1 || $current_user->city || $current_user->county || $current_user->state || $current_user->zip ) {
    
                        if ( $current_user->address1 ) {
                            
                            echo $current_user->address1; 
                        
                        }
                    
                        if ( $current_user->address2 ) {
                                
                            echo ', '.$current_user->address2; 
                            
                        }
                                
                        echo '<br />';
                    
                        if ( $current_user->city ) {
                        
                            echo $current_user->city; 
                            
                        }
                    
                        if ( $current_user->county ) {
                                
                            echo ', '.$current_user->county.' '.__( 'county', $this->plugin_name ); 
                            
                        }
                            
                        if ( $current_user->state ) {
                                
                            echo ', '.$current_user->state; 
                            
                        }
                    
                        if ( $current_user->zip ) {
                        
                            echo ' '.$current_user->zip; 
                            
                        }
                            
                    } else { 
                    
                        _e( 'None', $this->plugin_name ); 
                        
                    } // end if address info. ?>
              	
                </strong>
                
           	</td>
       	
        </tr>

        <tr>
        
        	<th>
            
            	<?php _e( 'Voting Groups:', $this->plugin_name ); ?>
                
           	</th>
            
            <td>
            	
                <strong class="disp_vote_groups">
					
					<?php 
					if ( $current_user->voter_vote_groups ) {
						
						echo $current_user->voter_vote_groups;
						
					} else { 
					
						_e( 'None', $this->plugin_name ); 
						
					} // end if current user vote groups. ?>
                    
              	</strong>
                
          	</td>
       
       	</tr>   
        
        <tr>
        
        	<th colspan="2">
            
            	<?php _e( 'Vote History:', $this->plugin_name ); ?>
                
           	</th>
            
      	</tr>
        
        <tr>
        	
            <td colspan="2">
			
				<?php $this->voteRecord( $current_user ); ?>
                
    		</td>
               
       	</tr>
        
    </table>
    
</div>    
    
<hr />
	
<a href="<?php echo wp_logout_url( get_permalink() ); ?>"><?php _e( 'Logout', $this->plugin_name ); ?></a>

<?php } else {
	 
		echo '<h3>'.__( 'You have not been asigned voting privileges.', $this->plugin_name ).'</h3>';
	
	} // End check if can vote.			
							
} // End check if logged in?>