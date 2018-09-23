<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.ryanwhitney.us
 * @since      1.0.0
 *
 * @package    Prog_Vote
 * @subpackage Prog_Vote/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and for 
 * enqueueing the admin-specific stylesheet and JavaScript.
 *
 * @package    Prog_Vote
 * @subpackage Prog_Vote/admin
 * @author     Ryan Whitey <ryan@ryanwhitney.us>
 */

if ( ! defined( 'ABSPATH' ) ) {
	
	exit; // Exit if accessed directly

}
		


class Prog_Vote_Admin {


	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;


	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;

		$this->version = $version;

	}


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/prog-vote-admin.css', array(), $this->version, 'all' );

	}


	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/prog-vote-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	
	/**
	 * Add voting capability checkbox to user.
	 *
	 * @since    1.0.0
	 */
	public function add_vote_capability_box( $user ) { 
	
		if ( current_user_can( 'edit_user' ) ) {  

		$options = get_option($this->plugin_name, array() );?>

		<h3><?php _e( "Eligible to vote?", $this->plugin_name); ?></h3>

        <table class="form-table">

            <tr>

         		<th>
              	
                	<label for="voter">
					
						<?php _e( "Voter", $this->plugin_name); ?>
                    
              		</label>
                
           		</th>

             	<td>
                
                	<input type="checkbox" name="voter" id="voter" value="1" <?php checked(get_user_meta($user->ID, 'voter', true), true, true); ?> /> &nbsp;
                
                    <span class="description">
                    
                        <?php 
						_e( 'Checking the box will give this user the ability to vote.', $this->plugin_name );
                        
                        if ( user_can( $user, 'vote' ) ) {
							
							echo '&#10003;'; 
							
						} // end if user can vote. ?>
                        
                    </span>
                    
	            </td>
            
    		</tr>
   		
        </table>
          
        <h3>
		
			<?php _e( 'Vote Groups', $this->plugin_name); ?>
            
       	</h3>
        
        <table class="form-table">
        
        	<tr>
            
              	<th>
                
                	<label for="voter_vote_groups">
					
						<?php _e( 'Vote Groups', $this->plugin_name); ?>
                        
                   	</label>
                    
               	</th>
              
              	<td>
                
                	<input type="text" name="voter_vote_groups" id="voter_vote_groups" value="<?php if(get_user_meta($user->ID, 'voter_vote_groups', true)){echo get_user_meta($user->ID, 'voter_vote_groups', true);} ?>" />
                    
                    <strong><?php if ( isset( $options['vote_groups'] ) ) { echo '['.$options['vote_groups'].']'; } else { echo 'No vote groups set.'; } ?></strong>
                    
                    <br />
                
                	<span class="description">
					
						<?php _e( 'Different groups that can be assigned to voters and elections to limit voting access. These are string values separated by comas (,).', $this->plugin_name); ?>
                        
                  	</span>
            	
                </td>
            
           	</tr>
          
      	</table>
     
		<?php
	    }
	
	} // end add_vote_capability_box function.
	
	
	/**
	 * Save voter checkbox status and adds or removes voter status..
	 *
	 * @since    1.0.0
	 */
	public function save_vote_capability( $user ) {

		$saved = false;

  		if ( current_user_can( 'edit_user', $user ) ) {
			
			$userI = new WP_User( $user );
			
			if ( isset( $_POST['voter'] ) ) {
			
				update_user_meta( $user, 'voter', $_POST['voter'] );
			
			} else {
				
				delete_user_meta( $user, 'voter' );
			
			}
				
			if ( !user_can( $user, 'vote' ) && isset( $_POST['voter'] ) ) {
			
				$userI->add_cap( 'vote' );
			
			} else if ( user_can( $user, 'vote' ) && !isset( $_POST['voter'] ) ) {
			
				$userI->remove_cap( 'vote' );
			
			}
			
			if ( isset( $_POST['voter_vote_groups'] ) ) {
		
				update_user_meta( $user, 'voter_vote_groups', $_POST['voter_vote_groups'] );
		
			}
   	 		
			$saved = true;
  		}
  		
		return true;
		
	} // end save_vote_capability function.

	
	/**
	 * Add additional contact information about user.
	 *
	 * @since    1.0.0
	 */

	public function modify_user_contact_methods( $user_contact ) {

		// Add user contact methods
		$user_contact['facebook']   = __( 'Facebook URL', $this->plugin_name );

		$user_contact['phone']   = __( 'Phone', $this->plugin_name );

		$user_contact['address1'] = __( 'Address 1', $this->plugin_name );

		$user_contact['address2'] = __( 'Address 2', $this->plugin_name );

		$user_contact['city'] = __( 'City', $this->plugin_name );

		$user_contact['county'] = __( 'County', $this->plugin_name );

		$user_contact['state'] = __( 'State', $this->plugin_name );

		$user_contact['zip'] = __( 'Zipcode', $this->plugin_name );

		return $user_contact;
		
	} // end modify_user_contact_methods function.
	
	
	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {
		
		/*
		 * Add a settings page for this plugin to the Settings menu.
		 *
		 * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
		 *
		 *        Administration Menus: http://codex.wordpress.org/Administration_Menus
		 *
		 */
		
		add_menu_page( __( 'Elections', $this->plugin_name ), __( 'Elections', $this->plugin_name ), 'manage_options', $this->plugin_name, '', 'dashicons-list-view', 26 );
		
		add_submenu_page( $this->plugin_name, __( 'Votes', $this->plugin_name ), __( 'Votes', $this->plugin_name ), 'manage_options', 'prog_vote_votes', array( $this, 'display_plugin_votes' ) );
		
		add_submenu_page( $this->plugin_name, __( 'Results', $this->plugin_name ), __( 'Results', $this->plugin_name ), 'manage_options', 'prog_vote_results', array( $this, 'display_plugin_results' ) );
		
		add_submenu_page( $this->plugin_name, __( 'Settings', $this->plugin_name ), __( 'Settings', $this->plugin_name ), 'manage_options', 'prog_vote_settings', array( $this, 'display_plugin_settings_page' ) );
		
		add_submenu_page( $this->plugin_name, __( 'About Prog Vote', $this->plugin_name ), __( 'Prog Vote', $this->plugin_name ), 'manage_options', 'prog_vote_info', array( $this, 'display_plugin_info_page' ) );
		
	} // end add_plugin_admin_menu function.
	
	
	/**
	 * Render the info page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_info_page() {
	
		include_once( 'partials/prog-vote-info-display.php' );
	
	} // end display_plugin_info_page function.
	
	
	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_settings_page() {
	
		include_once( 'partials/prog-vote-admin-display.php' );
	
	} // end display_plugin_settings_page function.
	
	
	/**
	 * Render the votes page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_votes() {
		
		include_once( 'partials/prog-vote-votes.php' );
	
	} // end display_plugin_votes function.
	
	
	/**
	 * Render the results for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_results() {
		
		include_once( 'partials/prog-vote-results.php' );
		
		global $wpdb;
		
		$votearray = $wpdb->get_results('SELECT votearray, count(*) FROM '.$wpdb->prefix.'pv_votes WHERE race = 541 GROUP BY votearray', 'ARRAY_N');

		$votetotal = $wpdb->query('SELECT votearray FROM '.$wpdb->prefix.'pv_votes WHERE race = 541');
		
		$va = array();
	
		foreach ( $votearray as $v ) {
			
			$va[$v[0]] = $v[1];
			
		}
		var_dump($votearray);
		echo '<br /><br />Total: '.$votetotal;
		
	} // end display_plugin_results function.
	
	
	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {
	
		/*
		*  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
		    */
	
		$settings_link = array(
	
			'<a href="'.admin_url( 'admin.php?page='.$this->plugin_name ).'">'.__( 'Settings', $this->plugin_name ).'</a>',
	
		);
		
	   	return array_merge( $settings_link, $links );
		
	} // end add_action_link function.
	
	
	/**
	 * Register the Election post type.
	 *
	 * @since    1.0.0
	 */
	public function register_election_post_type() {
	
		$post_type = 'pv_election';
	
		$labels = array(
	
			'name'               => _x( 'Elections', 'post type general name', $this->plugin_name ),
	
			'singular_name'      => _x( 'Election', 'post type singular name', $this->plugin_name ),
	
			'menu_name'          => _x( 'Elections', 'admin menu', $this->plugin_name ),
	
			'name_admin_bar'     => _x( 'Election', 'add new on admin bar', $this->plugin_name ),
	
			'add_new'            => _x( 'Add New', 'pv-election', $this->plugin_name ),
	
			'add_new_item'       => __( 'Add Election', $this->plugin_name ),
	
			'new_item'           => __( 'New Election', $this->plugin_name ),
	
			'edit_item'          => __( 'Edit Election', $this->plugin_name ),
	
			'view_item'          => __( 'View Election', $this->plugin_name ),
	
			'view_items'         => __( 'View Elections', $this->plugin_name ),
	
			'all_items'          => __( 'Elections', $this->plugin_name ),
	
			'search_items'       => __( 'Search Elections', $this->plugin_name ),
	
			'parent_item_colon'  => __( 'Parent Elections:', $this->plugin_name ),
	
			'not_found'          => __( 'No elections found.', $this->plugin_name ),
	
			'not_found_in_trash' => __( 'No elections found in Trash.', $this->plugin_name )
	
		);
	
		$args = array(
		
			'labels'             => $labels,
		
			'description'        => __( 'Elections using the Prog Vote voting system.', $this->plugin_name ),
		
			'public'             => false,
		
			'exclude_from_search'=> true,
		
			'publicly_queryable' => false,
		
			'show_ui'            => true,
		
			'show_in_menu'       => $this->plugin_name,
		
			'query_var'          => true,
		
			'rewrite'            => array( 'slug' => 'pv_election' ),
		
			'capability_type'    => 'post',
		
			'has_archive'        => true,
		
			'hierarchical'       => false,
		
			'menu_position'      => null,
		
			'supports'           => array( 'title', 'thumbnail', 'editor', 'excerpt', 'post-formats', 'revisions' )
		
		);
		
		register_post_type( $post_type, $args );
	
	} // end register_election_post_type function.
	
	
	/**
	 * Register the Race post type.
	 *
	 * @since    1.0.0
	 */
	public function register_race_post_type() {
	
		$post_type = 'pv_race';
	
		$labels = array(
	
			'name'               => _x( 'Races', 'post type general name', $this->plugin_name ),
	
			'singular_name'      => _x( 'Race', 'post type singular name', $this->plugin_name ),
	
			'menu_name'          => _x( 'Races', 'admin menu', $this->plugin_name ),
	
			'name_admin_bar'     => _x( 'Race', 'add new on admin bar', $this->plugin_name ),
	
			'add_new'            => _x( 'Add New', 'pv-election', $this->plugin_name ),
	
			'add_new_item'       => __( 'Add Race', $this->plugin_name ),
	
			'new_item'           => __( 'New Race', $this->plugin_name ),
	
			'edit_item'          => __( 'Edit Race', $this->plugin_name ),
	
			'view_item'          => __( 'View Race', $this->plugin_name ),
	
			'all_items'          => __( 'Races', $this->plugin_name ),
	
			'search_items'       => __( 'Search Races', $this->plugin_name ),
	
			'parent_item_colon'  => __( 'Parent Races:', $this->plugin_name ),
	
			'not_found'          => __( 'No Races found.', $this->plugin_name ),
	
			'not_found_in_trash' => __( 'No Races found in Trash.', $this->plugin_name )
	
		);
	
		$args = array(
		
			'labels'             => $labels,
		
			'description'        => __( 'Races using the Prog Vote voting system.', $this->plugin_name ),
		
			'public'             => false,
		
			'exclude_from_search'=> true,
		
			'publicly_queryable' => false,
		
			'show_ui'            => true,
		
			'show_in_menu'       => $this->plugin_name,
		
			'query_var'          => true,
		
			'rewrite'            => array( 'slug' => 'pv_race', 'with_front' => FALSE ),
		
			'capability_type'    => 'post',
		
			'has_archive'        => true,
		
			'hierarchical'       => false,
		
			'menu_position'      => null,
		
			'supports'           => array( 'title', 'thumbnail', 'editor', 'excerpt', 'post-formats', 'revisions' )
		
		);
		
		register_post_type( $post_type, $args );
	
	} // end register_race_post_type function.
	
	
	/**
	 * Register the Candidate post type.
	 *
	 * @since    1.0.0
	 */
	public function register_candidate_post_type() {
	
		$post_type = 'pv_candidate';
	
		$labels = array(
	
			'name'               => _x( 'Candidates', 'post type general name', $this->plugin_name ),
	
			'singular_name'      => _x( 'Candidate', 'post type singular name', $this->plugin_name ),
	
			'menu_name'          => _x( 'Candidates', 'admin menu', $this->plugin_name ),
	
			'name_admin_bar'     => _x( 'Candidate', 'add new on admin bar', $this->plugin_name ),
	
			'add_new'            => _x( 'Add New', 'pv-candidate', $this->plugin_name ),
	
			'add_new_item'       => __( 'Add Candidate', $this->plugin_name ),
	
			'new_item'           => __( 'New Candidate', $this->plugin_name ),
	
			'edit_item'          => __( 'Edit Candidate', $this->plugin_name ),
	
			'view_item'          => __( 'View Candidate', $this->plugin_name ),
	
			'all_items'          => __( 'Candidates', $this->plugin_name ),
	
			'search_items'       => __( 'Search Candidates', $this->plugin_name ),
	
			'parent_item_colon'  => __( 'Parent Candidates:', $this->plugin_name ),
	
			'not_found'          => __( 'No candidates found.', $this->plugin_name ),
	
			'not_found_in_trash' => __( 'No candidates found in Trash.', $this->plugin_name )
	
		);
	
		$args = array(
		
			'labels'             => $labels,
		
			'description'        => __( 'Candidates using the Prog Vote voting system.', $this->plugin_name ),
		
			'public'             => false,
		
			'exclude_from_search'=> true,
		
			'publicly_queryable' => true,
		
			'show_ui'            => true,
		
			'show_in_menu'       => $this->plugin_name,
		
			'query_var'          => true,
		
			'rewrite'            => array( 'slug' => 'pv_candidate' ),
		
			'capability_type'    => 'post',
		
			'has_archive'        => true,
		
			'hierarchical'       => false,
		
			'menu_position'      => null,
		
			'supports'           => array( 'title', 'thumbnail', 'editor', 'excerpt', 'post-formats', 'revisions' )
		
		);
		
		register_post_type( $post_type, $args );
	
	} // end register_candidate_post_type function
	
	
	/**
	*  Custom Columns titles
	*
	*
	* @since    1.0.0
	*/
	function set_custom_edit_columns_election( $columns ) {
		
		$columns['open'] = __( 'Open', $this->plugin_name );
		
		$columns['close'] = __( 'Close', $this->plugin_name );
	
		return $columns;
		
	} // end set_custom_edit_columns_election function.
	
	
	/**
	*  Set Custom Columns titles for race
	*
	*
	* @since    1.0.0
	*/
	function set_custom_edit_columns_race( $columns ) {
		
		$columns['election'] = __( 'Election', $this->plugin_name );
	
		return $columns;
	
	} // end set_custom_edit_columns_race function.
	
	
	/**
	*  Set Custom Columns titles for candidate
	*
	*
	* @since    1.0.0
	*/
	function set_custom_edit_columns_candidate( $columns ) {
		
		$columns['race'] = __( 'Race', $this->plugin_name );
		
		$columns['election'] = __( 'Election', $this->plugin_name );
	
		return $columns;
	
	} // end set_custom_edit_columns_candidate function.
	
	
	/**
	*  Data from posts for Custom Column
	*
	*
	* @since    1.0.0
	*/
	function custom_column_election( $column, $post_id ) {
	
		switch ( $column ) {
				
			case 'open' :
	
				echo get_post_meta( $post_id , 'pv_election_open' , true );
	
				break;
	
			case 'close' :
	
				echo get_post_meta( $post_id , 'pv_election_close' , true ); 
	
				break;
	
		}

	} // end custom_column_election function.


	/**
	*  Data from posts for Custom Column (race)
	*
	*
	* @since    1.0.0
	*/
	function custom_column_race( $column, $post_id ) {
		
		switch ( $column ) {
				
			case 'election' :
			
				echo get_the_title( get_post_meta( $post_id , 'pv_race_election' , true ) );
			
				break;
	
		} 
	
	} // end custom_column_race function.
	
	
	/**
	*  Data from posts for Custom Column (candidate)
	*
	*
	* @since    1.0.0
	*/
	function custom_column_candidate( $column, $post_id ) {
		
		switch ( $column ) {
	
			case 'race' :
		
				echo get_the_title( get_post_meta( $post_id , 'pv_candidate_race' , true ) ); 

				break;
				
			case 'election' :

				echo get_the_title( get_post_meta( get_post_meta( $post_id , 'pv_candidate_race' , true ), 'pv_race_election', true ) ); 

				break;
	
		}

	} // end custom_column_candidate function.

	
	/**
	*  Making custom comlumns sortable
	*
	*
	*
	* @since   1.0.0
	*/
	function custom_election_cols_sortable( $cols ) {
    	
		$cols['open'] = 'open';
    	
		$cols['close'] = 'close';
	
    	return $cols;
	
	} // end custom_election_cols_sortable function
	
	
	/**
	*  Making custom comlumns sortable
	*
	*
	*
	* @since   1.0.0
	*/
	function custom_race_cols_sortable( $cols ) {
    	
		$cols['election'] = 'election';
	
    	return $cols;
	
	} // end custom_race_cols_sortable function.
	
	
	/**
	*  Making custom comlumns sortable
	*
	*
	*
	* @since   1.0.0
	*/
	function custom_candidate_cols_sortable( $cols ) {
    	
		$cols['race'] = 'race';
    	
		$cols['election'] = 'election';
	
    	return $cols;
	
	} // end custom_candidate_cols_sortable function.


	/**
	*  Special post types added feilds after title. 
	*
	*
	* @since    1.0.0
	*/
	function my_post_after_header_misc_actions( $post ) {
	
		$options = get_option( $this->plugin_name );
		
		$id = $post->ID;
		
		$postType = get_post_type( $id );
		
		if ( $postType == 'pv_election' ) {
		
			include_once( 'partials/prog-vote-elections-after-title.php' );
		
		}
	
	} // end my_post_after_header_misc_actions function.
	
	
	/**
	*  Special post types added feilds at end. 
	*
	*
	* @since    1.0.0
	*/
	function my_post_submitbox_misc_actions( $post ) {
	global $wpdb;
		$options = get_option( $this->plugin_name );
		
		$id = $post->ID;
		
		$postType = get_post_type( $id );
		
		if ( $postType == 'pv_election' ) {
			
			$info_voter_only = get_post_meta( $id, 'pv_election_info_voter_only', true );
		
			$results_voter_only = get_post_meta( $id, 'pv_election_results_voter_only', true );
		
			$data_voter_only = get_post_meta( $id, 'pv_election_data_voter_only', true );
		
			$ip_vote = get_post_meta( $id, 'pv_election_ip_vote', true );
		
			$voting_open_date = get_post_meta( $id, 'pv_election_open_date', true );
		
			$voting_close_date = get_post_meta( $id, 'pv_election_close_date', true );
		
			$voting_open_time = get_post_meta( $id, 'pv_election_open_time', true );
		
			$voting_close_time = get_post_meta( $id, 'pv_election_close_time', true );
		
			$election_system = get_post_meta( $id, 'pv_election_system', true );
		
			$max_select = get_post_meta( $id, 'pv_election_max_select', true );
		
			$default_vote_groups = get_post_meta( $id, 'pv_election_vote_groups', true );
			
			include_once( 'partials/prog-vote-elections.php' );
			
		} else if ( $postType == 'pv_race' ) {
			
			$election = get_post_meta( $id, 'pv_race_election', true );
		
			$race_voting = get_post_meta( $id, 'pv_race_voting', true );
		
			$multi_winner = get_post_meta( $id, 'pv_race_multi_winner', true );
		
			$winners_count = get_post_meta( $id, 'pv_race_winners_count', true );
		
			$vote_groups = get_post_meta( $id, 'pv_race_vote_groups', true );
		
			include_once( 'partials/prog-vote-races.php' );
		
		} else if ( $postType == 'pv_candidate' ) {
		
			$race = get_post_meta( $id, 'pv_candidate_race', true );
		
			include_once( 'partials/prog-vote-candidates.php' );
		
		}
		
	} // end my_post_submitbox_misc_actions function.
	
	
	/**
	*  Saving custom elections data
	*
	*
	* @since    1.0.0
	*/
	public function save_election_custom( $post ) {
	
		if ( isset( $_POST[ 'pv_election_info_voter_only' ] ) ) {
			 
			$info_voter_only = $_POST[ 'pv_election_info_voter_only' ]; 
		
		} else { 
			
			$info_voter_only = false; 
		
		}
		
		if ( isset( $_POST[ 'pv_election_results_voter_only' ] ) ) {
			 
			$results_voter_only = $_POST[ 'pv_election_results_voter_only' ]; 
		
		} else {
			
			$results_voter_only = false;
		
		}			
		
		if ( isset( $_POST[ 'pv_election_data_voter_only' ] ) ) {
			 
			$data_voter_only = $_POST[ 'pv_election_data_voter_only' ]; 
		
		} else { 
			
			$data_voter_only = false; 
			
		}			
		
		if ( isset( $_POST[ 'pv_election_ip_vote' ] ) ) {
			 
			$ip_vote = $_POST[ 'pv_election_ip_vote' ]; 
		
		} else { 
		
			$ip_vote = false; 
			
		}
		
		if ( isset( $_POST[ 'pv_election_open_date' ] ) ) { 
		
			$open_date = $_POST[ 'pv_election_open_date' ]; 
		
		} else { 
			
			$open_date = false; 
		
		}
		
		if ( isset( $_POST[ 'pv_election_open_time' ] ) ) { 
		
			$open_time = $_POST[ 'pv_election_open_time' ]; 
		
		} else { 
			
			$open_time = '00:00:00'; 
		
		}
		
		if ( isset( $_POST[ 'pv_election_close_date' ] ) ) { 
			
			$close_date = $_POST[ 'pv_election_close_date' ]; 
		
		} else { 
		
			$close_date = false; 
			
		}		
		
		if ( isset( $_POST[ 'pv_election_close_time' ] ) ) { 
			
			$close_time = $_POST[ 'pv_election_close_time' ]; 
		
		} else { 
		
			$close_time = '23:59:00'; 
		
		}
		
		if ( isset( $_POST[ 'pv_election_system' ] ) ) { 
		
			$election_system = $_POST[ 'pv_election_system' ]; 
		
		} else { 
		
			$election_system = 'RCV'; 
			
		}
		
		if ( isset( $_POST[ 'pv_election_max_select' ] ) ) { 
		
			$max_select = $_POST[ 'pv_election_max_select' ]; 
		
		} else { 
		
			$max_select = 1; 
			
		}
		
		if ( isset( $_POST[ 'pv_election_vote_groups' ] ) ) { 
		
			$default_vote_groups = $_POST[ 'pv_election_vote_groups' ]; 
		
		} else { 
		
			$default_vote_groups = ''; 
			
		}
		
		if ( $info_voter_only ) { 
		
			update_post_meta( $post, 'pv_election_info_voter_only', $info_voter_only ); 
		
		} else { 
			
			delete_post_meta( $post, 'pv_election_info_voter_only' ); 
			
		}
		
		if ( $results_voter_only ) { 
		
			update_post_meta( $post, 'pv_election_results_voter_only', $results_voter_only ); 
			
		} else { 
		
			delete_post_meta( $post, 'pv_election_results_voter_only' ); 
			
		}
		
		if ( $data_voter_only ) { 
		
			update_post_meta( $post, 'pv_election_data_voter_only', $data_voter_only ); 
			
		} else { 
		
			delete_post_meta( $post, 'pv_election_data_voter_only' ); 
			
		}
		
		if ( $ip_vote ) { 
		
			update_post_meta( $post, 'pv_election_ip_vote', $ip_vote ); 
			
		} else { 
		
			delete_post_meta( $post, 'pv_election_ip_vote' ); 
			
		}
		
		if ( $open_date ) { 
		
			$open = $open_date.' '.$open_time; 
		
			$open = date( "Y-m-d H:i:s", strtotime( $open ) );
		
			update_post_meta( $post, 'pv_election_open', $open );
		
			update_post_meta( $post, 'pv_election_open_date', $open_date );
		
			update_post_meta( $post, 'pv_election_open_time', $open_time ); 
		
		}
		
		if ( $close_date ) { 
			
			$close = $close_date.' '.$close_time;
			
			$close = date( "Y-m-d H:i:s", strtotime( $close ) );

			update_post_meta( $post, 'pv_election_close', $close );

			update_post_meta( $post, 'pv_election_close_date', $close_date );

			update_post_meta( $post, 'pv_election_close_time', $close_time ); 

		} 

		if ( $election_system ) { 
		
			update_post_meta( $post, 'pv_election_system', $election_system ); 
			
		}
	
		if ( $max_select ) { 
		
			update_post_meta( $post, 'pv_election_max_select', $max_select ); 
			
		}
	
		if ( $default_vote_groups ) { 
		
			update_post_meta( $post, 'pv_election_vote_groups', $default_vote_groups ); 
			
		}

	} // end save_election_custom function.
	
	
	/**
	*  Saving custom races data
	*
	*
	* @since    1.0.0
	*/
	public function save_race_custom( $post ) {
		
		if ( isset( $_POST['pv_race_election'] ) ) {
				
			update_post_meta( $post, 'pv_race_election', $_POST['pv_race_election'] ); 
			
		} else { update_post_meta( $post, 'pv_race_election', '' ); }
		
		if ( isset( $_POST['pv_race_voting'] ) ) {
				
			update_post_meta( $post, 'pv_race_voting', $_POST['pv_race_voting'] );

		} else { update_post_meta( $post, 'pv_race_voting', '' ); }
		
		if ( isset( $_POST['pv_race_multi_winner'] ) ) {
				
			update_post_meta( $post, 'pv_race_multi_winner', $_POST['pv_race_multi_winner'] );

		} else { update_post_meta( $post, 'pv_race_multi_winner', '' ); }
		
		if ( isset( $_POST['pv_race_winner_count'] ) ) {
						
			update_post_meta( $post, 'pv_race_winners_count', $_POST['pv_race_winners_count'] ); 

		} else { update_post_meta( $post, 'pv_race_winner_count', '' ); }
		
		if ( isset( $_POST['pv_race_vote_groups'] ) ) {
						
			update_post_meta( $post, 'pv_race_vote_groups', $_POST['pv_race_vote_groups'] ); 

		} else { update_post_meta( $post, 'pv_race_vote_groups', '' ); }
	} // end save_race_custom function.


	/**
	*  Saving custom candidates data
	*
	*
	* @since    1.0.0
	*/
	public function save_candidate_custom( $post ) {
		
		if ( isset( $_POST['pv_candidate_race'] ) ) {
	
			update_post_meta( $post, 'pv_candidate_race', $_POST['pv_candidate_race'] );
		
		} else {
		
			update_post_meta( $post, 'pv_candidate_race', '' );
			
		}

	} // end save_candidate_custom function.


	/**
	*  Save the plugin options
	*
	*
	* @since    1.0.0
	*/
	public function options_update() {

		register_setting( $this->plugin_name, $this->plugin_name, array( $this, 'validate_options' ) );

	} // end options_update function.
	
	
	/**
	 * Validate all options fields
	 *
	 * @since    1.0.0
	 */
	public function validate_options( $input ) {
	
		// inputs
		$valid = array();
	
		//----- Company information -----//
		$valid['org_name'] = ( isset( $input['org_name'] ) && !empty( $input['org_name'] ) ) ? sanitize_text_field( $input['org_name'] ) : '';

		$valid['org_email'] = ( isset( $input['org_email'] ) && !empty( $input['org_email'] ) && is_email( $input['org_email'] ) ) ? sanitize_text_field( $input['org_email'] ) : '';

		$valid['encryption'] = ( isset( $input['encryption'] ) && !empty( $input['encryption'] ) ) ? sanitize_text_field( $input['encryption'] ) : '';
		
		$valid['default_voting'] = ( isset( $input['default_voting'] ) && !empty( $input['default_voting'] ) ) ? sanitize_text_field( $input['default_voting'] ) : '';

		$valid['ranked_min'] = ( isset( $input['ranked_min'] ) && !empty( $input['ranked_min'] ) ) ? sanitize_text_field( $input['ranked_min'] ) : '';

		$valid['ranked_max'] = ( isset( $input['ranked_max'] ) && !empty( $input['ranked_max'] ) ) ? sanitize_text_field( $input['ranked_max'] ) : '';

		$valid['approval_min'] = ( isset( $input['approval_min'] ) && !empty( $input['approval_min'] ) ) ? sanitize_text_field( $input['approval_min'] ) : '';

		$valid['approval_max'] = ( isset( $input['approval_max'] ) && !empty( $input['approval_max'] ) ) ? sanitize_text_field( $input['approval_max'] ) : '';

		$valid['multi_winner'] = ( isset( $input['multi_winner'] ) && !empty( $input['multi_winner'] ) ) ? sanitize_text_field( $input['multi_winner'] ) : '';

		$valid['vote_groups'] = ( isset( $input['vote_groups'] ) && !empty( $input['vote_groups'] ) ) ? sanitize_text_field( $input['vote_groups'] ) : '';

		return $valid;

	 } // end validate_options function.
	 
	 /**
	* Function returns if election has not yet opened. If voting hasn't opened then it returns the time until voting opens.
	*
	* @since    1.0.0
	*/
	public static function voteTimeNotOpen($id){
		
		$now = new DateTime( null, Prog_Vote_admin::get_blog_timezone() );
		
		if( $now->format('Y-m-d H:i:s') > get_post_meta( $id, 'pv_election_open', true ) ){
		
			return false;
		
		} else { 
						
			$future_date = new DateTime( get_post_meta( $id, 'pv_election_open', true ) );
						
			$interval = $future_date->diff( $now );
			
			return $interval;
		
		} // End check if curent date and time is after vote opens
		
	} // End voteTimeNotOpen function
	 
	 /**
	* Function returns if election has not yet closed.
	*
	* @since    1.0.0
	*/
	public static function voteTimeClose( $id ) {		
	
		$now = new DateTime( null, Prog_Vote_admin::get_blog_timezone() );
		
		if( $now->format( 'Y-m-d H:i:s' ) > get_post_meta( $id, 'pv_election_close', true ) && get_post_meta( $id, 'pv_election_close', true ) != NULL ) {
	
			return true;
	
		} else {
					
			return false;
		
		} // End check if curent date and time is before vote closes
	
	} // End voteTimeClose function
	
	/**
	 *  Returns the blog timezone
	 *
	 * Gets timezone settings from the db. If a timezone identifier is used just turns
	 * it into a DateTimeZone. If an offset is used, it tries to find a suitable timezone.
	 * If all else fails it uses UTC.
	 *
	 * @return DateTimeZone The blog timezone
	 */
	public static function get_blog_timezone() {
	
		$tzstring = get_option( 'timezone_string' );
		
		$offset   = get_option( 'gmt_offset' );
	
		//Manual offset...
		//@see http://us.php.net/manual/en/timezones.others.php
		//@see https://bugs.php.net/bug.php?id=45543
		//@see https://bugs.php.net/bug.php?id=45528
		//IANA timezone database that provides PHP's timezone support uses POSIX (i.e. reversed) style signs
		if( empty( $tzstring ) && 0 != $offset && floor( $offset ) == $offset ){
		
			$offset_st = $offset > 0 ? "-$offset" : '+'.absint( $offset );
		
			$tzstring  = 'Etc/GMT'.$offset_st;
		
		}
	
		//Issue with the timezone selected, set to 'UTC'
		if( empty( $tzstring ) ){
		
			$tzstring = 'UTC';
		
		}
	
		$timezone = new DateTimeZone( $tzstring );
		
		return $timezone; 
	
	} // End function get_blog_timezone.
	
	
	/**
	*  Add custom tabulation meta box
	*
	*
	* @since    1.0.0
	*/
	public function election_register_meta_boxes( ) {
			
		add_meta_box( 'meta-box-id', __( 'Tabulate Election', $this->plugin_name ), 'Prog_Vote_Admin::election_meta_box', 'pv_election', 'side' );
		
	} // end election_register_meta_boxes function
	
	
	/**
	*  Run election button
	*
	*
	* @since    1.0.0
	*/
	public static function election_meta_box( $post ) {
		
		if ( Prog_Vote_admin::voteTimeClose( $post->ID ) ) {
			
			if ( get_post_meta( $post->ID, 'tabulated', true ) ) {
				
				echo '<center><strong>'.__( 'This election\'s results have been tabulated. They are available at the following url:', 'prog-vote' ).' <a href="'.get_site_url().'/vote-results/?electionId='.$post->ID.'" target="_blank" >'.get_site_url().'/vote-results/?electionId='.$post->ID.'</a></center></strong>';	
			
			} else { 
			
				include_once( 'partials/assets/prog-vote-tab-election.php' );
				
			}
			
		} else {
			
			echo '<center><em><strong>'.__( 'This election has not yet concluded. Once the election has concluded, the votes can be tabluated.', 'prog-vote' ).'</center></em></strong>';
		
		}
	
	} // end public static function election_meta_box.
	
	
	/**
	*  Ajax return for tabulation.
	*
	*
	* @since    1.0.0
	*/
	public function tab_election() {
	
		$electionId = intval( $_POST['electionId'] );
		
		if ( get_post_meta( $electionId, 'tabulated', true ) ) {
			
			echo '<center><strong>'.__( 'You cannot tabulate this election again. This election\'s results have been tabulated. They are available at the following url:', 'prog-vote' ).' <a href="'.get_site_url().'/vote-results/?electionId='.$electionId.'" target="_blank" >'.get_site_url().'/vote-results/?electionId='.$electionId.'</a></center></strong>';	
			
			wp_die();
			
		} else {
			
			$tabs = array();
			
			$error = array();
			
			$races = $this->get_races( $electionId );
			
			global $wpdb;
			
			foreach ( $races as $r ) {
				
				$candidates = $this->get_candiates( $r->post_id );
				
				$tabs[$r->post_id] = array();
				
				$eliminated = array();
				
				$i = 0;
				
				$tab_votes = 1; 
				
				while ( $tab_votes = $this->next_tab_round( $r->post_id, $candidates, $eliminated ) ) { 
					
					$eliminated = array_merge( $eliminated, array_keys($tab_votes[0]) );
					
					$tabs[$r->post_id][$i] = $tab_votes[1];
					
					$total = array_sum ( $tab_votes[1] ); 
					
					foreach ( $tab_votes[1] as $key => $value ) {
						
						$keysVals = array();
						
						$keysVals['election'] = $electionId;
						
						$keysVals['race'] = $r->post_id;
						
						$keysVals['candidate'] = $key;
						
						$keysVals['round'] = ( $i + 1 );
						
						$keysVals['number'] = $value;
						
						$keysVals['total'] = $total;
						
						$keysVals['percent'] = ( $value / $total ) * 100;
						
						if ( in_array( $key, $eliminated ) ) {
						
							$keysVals['eliminated'] = 1;
						
						} else {
						
							$keysVals['eliminated'] = 0;	
						
						}
											
						if ( $keysVals['percent'] > 50 ) {
						
							$keysVals['won'] = 1;
						
						} else {
							
							$keysVals['won'] = 0;
						
						}
						
						$query = 'SELECT id 
							FROM wp_pv_results 
							WHERE race = '.$keysVals['race'].'
							AND candidate = '.$keysVals['candidate'].'
							AND round = '.$keysVals['round'];

						if ( $wpdb->query( $query ) ) { } else {
						
							if ( $wpdb->insert( $wpdb->prefix.'pv_results', $keysVals ) ) { } else {
								
								$error[$keysVals['candidate'].'-'.$keysVals['round']] = $keysVals;
							
							}
						
						}
					
					}
					
					$i++;
					
				} 
				
			}
			
			if ( count( $error ) == 0 ) {
				
				if ( get_post_meta( $electionId, 'tabulated', true ) != NULL ) {
		
					update_post_meta( $electionId, 'tabulated', 1 );
				
				} else {
				
					add_post_meta( $electionId, 'tabulated', 1, true );
		
				} // end if tabulated meta exists for the election.
		
				echo '<center><strong>'.__( 'This election\'s results have been tabulated. They are available at the following url:', 'prog-vote' ).' <a href="'.get_site_url().'/vote-results/?electionId='.$electionId.'" target="_blank" >'.get_site_url().'/vote-results/?electionId='.$electionId.'</a></center></strong>';	

			} else {
				
				echo '<center><strong>'.__( 'There was an error in tabulating this election. If the problem presists, please contact the developer for assistance.', 'prog-vote' ).'</center></strong>';
			
			} // end if there are errors.
						
			wp_die();

		} // end if election has already been tabulated.
	
	}
	
	
	/**
	*  runs the rounds of tabulation.
	*
	*
	* @since    1.0.0
	*/
	public function next_tab_round( $race, $candidates, $eliminated ) {
				
		global $wpdb;
		
		$ca = array();
		
		$ta = array();
		
		if ( count( $candidates ) > 1 ) {
		
			foreach ( $candidates as $c ) {
				
				if ( in_array( $c->post_id, $eliminated ) ) {
					
					$ca[$c->post_id] = 0;
					
				} else {
				
					if ( get_post_meta( $race, 'pv_race_multi_winner', true) ) {
						
						$query = $this->get_mw_rcv_query( $race, $eliminated, $c );
					
					} else {
				
						$query = $this->get_sw_rcv_query( $race, $eliminated, $c );
					
					}
					
					$votes = $wpdb->query( $query );
	
					$ca[$c->post_id] = $votes;
					
					$ta[$c->post_id] = $votes;

				} // end if candidate has been eliminated.
								
			}		
		
			asort( $ta );
					
			$eliminate = current( array_keys ( $ta ) );
					
			$elim = array_intersect($ta, array($ta[$eliminate]));
			
			if ( count( $eliminated ) < ( count( $candidates ) - 1 ) ) {
			
				return array( $elim , $ca );
			
			} else {
			
				return false;
				
			} // end if all but one candidate has been eliminated.
		
		} else {
			
			return false;
		
		} // end if $candidates exist.
	
	} // end next_tab_round function.
	
	
	/**
	*  Gets query for multi winner RCV races.
	*
	*
	* @since    1.0.0
	*/
	public function get_mw_rcv_query( $race, $eliminated, $c ) {
		global $wpdb;
		
		$query = 'SELECT votearray, count(*) FROM '.$wpdb->prefix.'pv_votes WHERE race = '.$race.' GROUP BY votearray';
		
		return $query;
	
	}
	
	
	/**
	*  Gets query for single winner RCV races.
	*
	*
	* @since    1.0.0
	*/
	public function get_sw_rcv_query( $race, $eliminated, $c ) {
		global $wpdb;
		
		$query = 'SELECT id 
		FROM '.$wpdb->prefix.'pv_votes 
		WHERE race = '.$race.'
		AND (';
		
		$elimcount = count( $eliminated );
		
		if ( $elimcount > 5 ) { $elimcount = 5; }
				
		for ( $j = ( $elimcount + 1 ); $j > 0; $j-- ) {
		
			if ( $j > 1 ) {
				
				$query .= '(';
			
			}
			
			$query .= 'rank'.( $j ).' = '.$c->post_id;
			
			if ( $j > 1 ) {
			
				$query .= ' AND ';
			
			}	
		
			for ( $k = $j - 1; $k > 0; $k-- ) {
			
				$query .= '(';
	
				for ( $l = ( count( $eliminated ) - 1); $l >= 0; $l-- ) {
				
					$query .= 'rank'.( $k ).' = '.$eliminated[$l];
				
					if ( $l > 0 ) {
					
						$query .= ' OR ';
				
					} else {
						
						$query .= ' OR rank'.( $k ).' = \'\'';
					
					}
			
				} // end for running through each eliminated candidate.
		
				$query .= ')';
			
				if ( $k > 1 ) {
				
					$query .= ' AND ';
			
				}
		
			} // end for itterating through ranks as $k.
		
			if ( $j > 1 ) {
	
				$query .= ')';
	
			}
			
			if ( $j > 1 ) {
		
				$query .= ' OR ';
		
			}	
			
		} // for $j > 0.
			
		$query .= ')';
		
		return $query;
	
	}
	
	
	/**
	*  Gets the candidates object.
	*
	*
	* @since    1.0.0
	*/
	public function get_candiates( $r ) {
		
		global $wpdb;
		
		$candidates = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_postmeta WHERE meta_key = %s AND meta_value = %d", 'pv_candidate_race', $r ) );
		
		return $candidates;
		
	}
	
	
	/**
	*  Gets the races object.
	*
	*
	* @since    1.0.0
	*/
	public function get_races( $e ) {
		
		global $wpdb;
		
		$races = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_postmeta WHERE meta_key = %s AND meta_value = %d", 'pv_race_election', $e ) );

		return $races;
		
	}
	
} // end Prog_Vote_Admin Class