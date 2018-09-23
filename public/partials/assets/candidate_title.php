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
?>

<td id="<?php echo $theID; ?>" style="width:33%;">
                            
    <a href="<?php echo get_the_guid( $theID ); ?>" target="_blank">

        <div>
		
			<?php echo get_the_title();?>
            
       	</div>

    </a>

</td>