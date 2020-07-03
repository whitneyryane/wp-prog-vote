<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.ryanwhitney.us
 * @since      1.0.0
 *
 * @package    Prog_Vote
 * @subpackage Prog_Vote/admin/partials
 */
?>

<div id="shortcodediv" class="postbox" >
	
    <blockquote>
    
    	<strong><?php _e( 'SHORTCODE:', $this->plugin_name ); ?></strong> <font color="#0000FF">[prog_vote id="<?php echo $id; ?>" election="vote"]</font>
        
        <br />
        
        <br />
        
        <small><?php _e( 'ALSO: ', $this->plugin_name ); ?><font color="#0000FF">[prog_vote id="<?php echo $id; ?>" election="info"]</font> <?php _e( 'and', $this->plugin_name ); ?> <font color="#0000FF">[prog_vote id="<?php echo $id; ?>" election="results"]</font> <?php _e( 'and', $this->plugin_name ); ?> <font color="#0000FF">[prog_vote id="<?php echo $id; ?>" election="data"]</font></small>
        
   	</blockquote>			

</div>

<div id="shortcodediv" class="postbox" >
	
    <blockquote>
    
    	<strong><?php _e( 'LINK:', $this->plugin_name ); ?></strong> <a href="<?php echo site_url().'/prog-vote/?electionId='.$id.'&display=vote'; ?>" target="_blank" ><?php _e( 'BALLOT', $this->plugin_name ); ?></a> | <a href="<?php echo site_url().'/prog-vote/?electionId='.$id.'&display=info'; ?>" target="_blank" ><?php _e( 'INFO', $this->plugin_name ); ?></a> | <a href="<?php echo site_url().'/prog-vote/?electionId='.$id.'&display=results'; ?>" target="_blank" ><?php _e( 'RESULTS', $this->plugin_name ); ?></a> | <a href="<?php echo site_url().'/prog-vote/?electionId='.$id.'&display=data'; ?>" target="_blank" ><?php _e( 'VOTE DATA', $this->plugin_name ); ?></a>

   	</blockquote>			

</div>