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

<label for="<?php echo $theID.'-1';?>" class="rank label<?php echo $theID; ?> name<?php echo $key.'-1'; ?>" style="width:<?php echo 1/$query->post_count*100;?>%;">
	
    <input type="radio" id="<?php echo $theID.'-1';?>" data-candidate="<?php echo get_the_title();?>" data-rank="1" data-voting="<?php echo $vm;?>" name="<?php echo $key.'-1'; ?>" value="<?php echo $theID; ?>" class="<?php echo 'can-'.$theID.' rank-1';?>" style="position:inherit; left:auto; opacity:1;" />

    <?php _e( 'SELECT', $this->plugin_name ); ?>

</label>