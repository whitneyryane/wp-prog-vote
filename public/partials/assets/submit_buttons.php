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

<input type="submit" id="process" value="<?php _e( 'SUBMIT', $this->plugin_name ); ?>" />

<input type="reset" id="clear" style="background: #CCC;" value="<?php _e( 'CLEAR', $this->plugin_name ); ?>" />