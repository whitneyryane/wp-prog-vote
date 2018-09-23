<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.ryanwhitney.us
 * @since             1.0.0
 * @package           Prog_Vote
 *
 * @wordpress-plugin
 * Plugin Name:       Prog Vote by Ryan Whitney
 * Plugin URI:        http://www.ryanwhitney.us
 * Description:       The most extensive plugin for ranked choice voting on your wordpress site. It includes the ability to asign elegibility, accept candidacy, perform single transferable and multimember elections.
 * Version:           1.0.0
 * Author:            Ryan Whitey
 * Author URI:        http://www.ryanwhitney.us
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       prog-vote
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {

	die;

}


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-prog-vote-activator.php
 */
function activate_prog_vote() {

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-prog-vote-activator.php';

	Prog_Vote_Activator::activate();

}


/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-prog-vote-deactivator.php
 */
function deactivate_prog_vote() {

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-prog-vote-deactivator.php';

	Prog_Vote_Deactivator::deactivate();

}

register_activation_hook( __FILE__, 'activate_prog_vote' );

register_deactivation_hook( __FILE__, 'deactivate_prog_vote' );


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-prog-vote.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_prog_vote() {

	$plugin = new Prog_Vote();

	$plugin->run();

}

run_prog_vote();