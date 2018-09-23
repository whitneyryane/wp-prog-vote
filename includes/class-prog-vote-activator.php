<?php 
/**
 * Fired during plugin activation
 *
 * @link       http://www.ryanwhitney.us
 * @since      1.0.0
 *
 * @package    Prog_Vote
 * @subpackage Prog_Vote/includes
 */


/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Prog_Vote
 * @subpackage Prog_Vote/includes
 * @author     Ryan Whitey <ryan@ryanwhitney.us>
 */
class Prog_Vote_Activator {
	

	/**
	 * Sets up needed tables and establishes user capabilities.
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		self::create_tables();

		self::create_pages();

	}
	
	public static function create_tables(){

		global $wpdb;
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		
		$charset_collate = $wpdb->get_charset_collate();
				
		// Creates table for votes
		$table_name = $wpdb->prefix . "pv_votes";

		$sql = "CREATE TABLE $table_name (
		  	id INT NOT NULL AUTO_INCREMENT,
			voter TEXT NOT NULL,
			election INT NOT NULL,
			race INT NOT NULL,
			rank1 INT NOT NULL,
			rank2 INT NOT NULL,
			rank3 INT NOT NULL,
			rank4 INT NOT NULL,
			rank5 INT NOT NULL,
			rank6 INT NOT NULL,
			votearray TEXT NOT NULL,
			vote_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  	PRIMARY KEY  (id)
		) $charset_collate;";
		
		dbDelta( $sql );
			
		// Creates table for results
		$table_name = $wpdb->prefix . "pv_results";

		$sql = "CREATE TABLE $table_name (
			  id INT NOT NULL AUTO_INCREMENT,
			  election INT NOT NULL,
			  race INT NOT NULL,
			  candidate TEXT NOT NULL,
			  round TINYINT NOT NULL,
			  number FLOAT NOT NULL,
			  total INT NOT NULL,
			  percent FLOAT NOT NULL,
			  eliminated TINYINT NOT NULL,
			  won TINYINT NOT NULL,
			  redistribute TEXT NOT NULL,
			  PRIMARY KEY  (id)
		) $charset_collate;";
		
		dbDelta( $sql );
		
	}

	
	/**
	 * Create pages that the plugin relies on, storing page id's in variables.
	 */
	public static function create_pages() {
		
		$pages = apply_filters( 'prog-vote-create-pages',
			
			array(
			
				'prog_vote' => array(
				
					'name'  => _x(
				
							'prog-vote',
				
							'Page slug',
				
							'prog-vote'
				
					),
				
					'title' => _x(
				
							'Prog Vote',
				
							'Page title',
				
							'prog-vote'
				
					),
				
					'content' => '[prog_vote]'
				
				),
				
				'account' => array(
				
					'name'  => _x(
				
							'voter-account',
				
							'Page slug',
				
							'prog-vote'
				
					),
				
					'title' => _x(
				
							'Voter Account',
				
							'Page title',
				
							'prog-vote'
				
					),
				
					'content' => '[prog_vote election="account"]'
				
				)
			
			)
		
		);

		foreach ( $pages as $key => $page ) {
			
			self::prog_vote_create_page( 
			
				esc_sql( $page['name'] ), 
			
				'prog-vote_' . $key . '_page_id', 
			
				$page['title'], 
			
				$page['content']
			
			);
		}
	}
	
	
	/**
	 * Create a page and store the ID in an option.
	 *
	 * @param mixed $slug Slug for the new page
	 * @param string $option Option name to store the page's ID
	 * @param string $page_title (default: '') Title for the new page
	 * @param string $page_content (default: '') Content for the new page
	 * @param int $post_parent (default: 0) Parent for the new page
	 * @return int page ID
	 */
	public static function prog_vote_create_page( $slug, $option = '', $page_title = '', $page_content = '', $post_parent = 0 ) {
		
		global $wpdb;
	
		$option_value = get_option( $option );
	
		if ( $option_value > 0 ) {
		
			$page_object = get_post( $option_value );
	
			if ( 'page' === $page_object->post_type && ! in_array( $page_object->post_status, array( 'pending', 'trash', 'future', 'auto-draft' ) ) ) {
		
				// Valid page is already in place
				return $page_object->ID;
		
			}
		
		}
	
		if ( strlen( $page_content ) > 0 ) {

			// Search for an existing page with the specified page content (typically a shortcode)
			$valid_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status NOT IN ( 'pending', 'trash', 'future', 'auto-draft' ) AND post_content LIKE %s LIMIT 1;", "%{$page_content}%" ) );

		} else {

			// Search for an existing page with the specified page slug
			$valid_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status NOT IN ( 'pending', 'trash', 'future', 'auto-draft' )  AND post_name = %s LIMIT 1;", $slug ) );

		}
	
		$valid_page_found = apply_filters( 'ahir_create_page_id', $valid_page_found, $slug, $page_content );
	
		if ( $valid_page_found ) {
	
			if ( $option ) {
	
				update_option( $option, $valid_page_found );
	
			}
	
			return $valid_page_found;
	
		}
	
		// Search for a matching valid trashed page
		if ( strlen( $page_content ) > 0 ) {
	
			// Search for an existing page with the specified page content (typically a shortcode)
			$trashed_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status = 'trash' AND post_content LIKE %s LIMIT 1;", "%{$page_content}%" ) );
	
		} else {
	
			// Search for an existing page with the specified page slug
			$trashed_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status = 'trash' AND post_name = %s LIMIT 1;", $slug ) );
	
		}
	
		if ( $trashed_page_found ) {
	
			$page_id   = $trashed_page_found;
	
			$page_data = array(
	
				'ID'             => $page_id,
	
				'post_status'    => 'publish',
	
			);
	
			wp_update_post( $page_data );
	
		} else {
	
			$page_data = array(
	
				'post_status'    => 'publish',
	
				'post_type'      => 'page',
	
				'post_author'    => 1,
	
				'post_name'      => $slug,
	
				'post_title'     => $page_title,
	
				'post_content'   => $page_content,
	
				'post_parent'    => $post_parent,
	
				'comment_status' => 'closed'
	
			);
	
			$page_id = wp_insert_post( $page_data );
	
		}
	
		if ( $option ) {
	
			update_option( $option, $page_id );
	
		}
	
		return $page_id;
	
	}

}