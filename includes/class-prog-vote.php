<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.ryanwhitney.us
 * @since      1.0.0
 *
 * @package    Prog_Vote
 * @subpackage Prog_Vote/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Prog_Vote
 * @subpackage Prog_Vote/includes
 * @author     Ryan Whitey <ryan@ryanwhitney.us>
 */
class Prog_Vote {


	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Prog_Vote_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;


	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;


	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;


	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'prog-vote';

		$this->version = '1.0.0';

		$this->load_dependencies();

		$this->set_locale();

		$this->define_admin_hooks();

		$this->define_public_hooks();

	}


	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Prog_Vote_Loader. Orchestrates the hooks of the plugin.
	 * - Prog_Vote_i18n. Defines internationalization functionality.
	 * - Prog_Vote_Admin. Defines all hooks for the admin area.
	 * - Prog_Vote_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {


		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-prog-vote-loader.php';


		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-prog-vote-i18n.php';


		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-prog-vote-admin.php';


		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-prog-vote-public.php';

		$this->loader = new Prog_Vote_Loader();

	}


	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Prog_Vote_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Prog_Vote_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}


	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Prog_Vote_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		// Add and save user option for voter status
		$this->loader->add_action( 'show_user_profile', $plugin_admin, 'add_vote_capability_box');

		$this->loader->add_action( 'edit_user_profile', $plugin_admin, 'add_vote_capability_box');

		$this->loader->add_action( 'user_new_form', $plugin_admin, 'add_vote_capability_box' );

		$this->loader->add_action( 'edit_user_profile_update', $plugin_admin, 'save_vote_capability' );

		$this->loader->add_action( 'personal_options_update', $plugin_admin, 'save_vote_capability' );

		$this->loader->add_action( 'user_register', $plugin_admin, 'save_vote_capability');
		
		// Add additional user contact fields
		$this->loader->add_filter( 'user_contactmethods', $plugin_admin, 'modify_user_contact_methods' );
		
		// Add menu items
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );
		
		// Registser custom post types
		$this->loader->add_action( 'init', $plugin_admin, 'register_election_post_type' );

		$this->loader->add_action( 'init', $plugin_admin, 'register_race_post_type' );

		$this->loader->add_action( 'init', $plugin_admin, 'register_candidate_post_type' );
		
		// Add default custom fields for custom post types
		$this->loader->add_action( 'edit_form_advanced', $plugin_admin, 'my_post_submitbox_misc_actions' );

		$this->loader->add_action( 'edit_form_top', $plugin_admin, 'my_post_after_header_misc_actions' );

		//$this->loader->add_action( 'edit_form_side', $plugin_admin, 'election_meta_box' );
		
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'election_register_meta_boxes' );

		$this->loader->add_action( 'save_post_pv_election', $plugin_admin, 'save_election_custom' );

		$this->loader->add_action( 'save_post_pv_race', $plugin_admin, 'save_race_custom' );

		$this->loader->add_action( 'save_post_pv_candidate', $plugin_admin, 'save_candidate_custom' );
		
		// change table columns that are visible for custom post types
		$this->loader->add_filter( 'manage_pv_election_posts_columns', $plugin_admin, 'set_custom_edit_columns_election' );

		$this->loader->add_action( 'manage_pv_election_posts_custom_column', $plugin_admin, 'custom_column_election', 10, 2 );

		$this->loader->add_filter( 'manage_pv_race_posts_columns', $plugin_admin, 'set_custom_edit_columns_race' );

		$this->loader->add_action( 'manage_pv_race_posts_custom_column', $plugin_admin, 'custom_column_race', 10, 2 );

		$this->loader->add_filter( 'manage_pv_candidate_posts_columns', $plugin_admin, 'set_custom_edit_columns_candidate' );

		$this->loader->add_action( 'manage_pv_candidate_posts_custom_column', $plugin_admin, 'custom_column_candidate', 10, 2 );
		
		// Make custom columns sortable
		$this->loader->add_filter( 'manage_edit-pv_election_sortable_columns', $plugin_admin, 'custom_election_cols_sortable' );		

		$this->loader->add_filter( 'manage_edit-pv_race_sortable_columns', $plugin_admin, 'custom_race_cols_sortable' );		

		$this->loader->add_filter( 'manage_edit-pv_candidate_sortable_columns', $plugin_admin, 'custom_candidate_cols_sortable' );
		
		// Add Settings link to the plugin
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' );

		$this->loader->add_filter( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );
		
		// Update settings options for plugin
		$this->loader->add_action( 'init', $plugin_admin, 'options_update');
		
		$this->loader->add_action( 'wp_ajax_tab_election', $plugin_admin, 'tab_election' );
		
		$this->loader->add_action( 'wp_ajax_export_votes', $plugin_admin, 'export_votes' );
		
		//$this->loader->add_action( 'admin_post_print.csv', $plugin_admin, 'pv_votes_print_csv' );

	}
	
	
	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Prog_Vote_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_styles', $plugin_public, 'enqueue_styles' );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		
		// Register Shortcodes
		$this->loader->add_shortcode( 'prog_vote', $plugin_public, 'prog_vote_short' );
		
		// Get candidate page template
		$this->loader->add_filter('single_template', $plugin_public, 'get_pv_candidate_template');
			
	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

		$this->loader->run();

	}


	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {

		return $this->plugin_name;

	}


	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Prog_Vote_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {

		return $this->loader;

	}


	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {

		return $this->version;

	}

}