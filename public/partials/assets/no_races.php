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

<br />
    
<table>

    <tr>
    
        <td>

	        <?php _e( 'No races are assigned to this election. Please go to the <a href="edit.php?post_type=pv_race">RACE TAB</a> and assign an election to each relevant race.', $this->plugin_name ); ?>

        </td>
        
    </tr>
    
</table>