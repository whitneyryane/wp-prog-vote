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
 
global $wpdb;

$election = "536";

$round = 0;
?>

<h1><?php _e( 'Ranked Choice Voting Election Example' ); ?></h1>

