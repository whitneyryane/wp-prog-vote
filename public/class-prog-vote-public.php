<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.ryanwhitney.us
 * @since      1.0.0
 *
 * @package    Prog_Vote
 * @subpackage Prog_Vote/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Prog_Vote
 * @subpackage Prog_Vote/public
 * @author     Ryan Whitey <ryan@ryanwhitney.us>
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	
	exit; // exit if accessed directly

}

class Prog_Vote_Public {

	
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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		
		$this->version = $version;
	
	} // end __construct function.


	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/prog-vote-public.css', array(), $this->version, 'all' );

	} // end enqueue_styles function.


	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/prog-vote-public.js', array( 'jquery' ), $this->version, false );

	} // end enqueue_scripts function.


	/**
	 * Insert voter vote data into the pv_vote table.
	 *
	 * @since    1.0.0
	 */
	public function prog_vote_insert_vote( $post ) {
		
		$election = $post['election'];
		
		if ( $this->canVote( $election ) || get_post_meta( $election,'pv_election_ip_vote',true ) ) { 
			
			if ( $userId = $this->not_voted( $election ) ) {
			
				include_once( 'partials/assets/insert_vote.php' );
			
			} else { 
			
				echo '<h3>'.__( 'You have already voted in this election.', $this->plugin_name ).'</h3>';
				
			} // end if has already voted.			
		
		} else { 
			
			echo '<h3>'.__( 'You are not elegible to vote in this election.', $this->plugin_name ).'</h3>';
		
		} // end if user is elegible to vote.
	
	} // end prog_vote_insert_vote function.
	
	
	/**
	 * Get election results if voter is elegible and results are avaialble.
	 *
	 * @since    1.0.0
	 */
	public function get_election_results( $id ) {
	
		global $wpdb;
		
		$query = 'SELECT * FROM '.$wpdb->prefix.'pv_results WHERE election = '.$id.' ORDER BY percent DESC, round';
		
		$results = $wpdb->get_results( $query );
		
		return $results;
	
	} // end get_election_results function. [needs work]
	
	
	/**
	 * Register prog_vote shortcode.
	 *
	 * @since    1.0.0
	 */
	public function prog_vote_short( $atts ) {
		
		$atts = shortcode_atts(
			array(
		
				'election' => false,
		
				'id' => false
			
			), 
			
			$atts,
			
			'prog_vote'
		
		); // Shortcode Atts
		
		if ( isset( $_GET['electionId'] ) & !$atts['id'] ) {
			
			$atts['id'] = $_GET['electionId'];
		
		} // End check if election id is included in header. 
		
		if ( isset( $_GET['display'] ) & !$atts['election'] ) {
			
			$atts['election'] = $_GET['display'];
		
		} // End check if election id is included in header. 
		
		ob_start(); 
		
		if ( $atts['election'] == 'account' ) { 
			
			include_once( 'partials/prog-vote-shortcode-voter-account.php' );
				
		} else if ( $atts['election'] == 'example' ) {
			
			include_once( 'partials/prog-vote-shortcode-election-example.php' );
			
		} else {
		
			if ( get_post_type( $atts['id'] ) ==  'pv_election' ) {
		
				switch ( $atts['election'] ) {
				
					case 'info' :
							
						include_once( 'partials/prog-vote-shortcode-election-info.php' );
									
						break; // End info case
	
					case 'vote' :
						
						include_once( 'partials/prog-vote-shortcode-election-vote.php' );
								
						break; // End vote case
			
					case 'results' :
			
						include_once( 'partials/prog-vote-shortcode-election-results.php' );
					
						break; // End results case
				
					case 'data' :
			
						include_once( 'partials/prog-vote-shortcode-election-data.php' );
								
						break; // End data case
						
				} // End switch statement for $atts['election'].
				
			} else {	
			
				_e( 'No election was specified.', $this->plugin_name );			
		
			} // End check if post is pv_election.
		
		} // End check if election = account.
	
		$html = ob_get_contents();
	
		ob_end_clean();
		
		return $html;
	} // End prog_vote shortcode function
	
	
	/**
	 * Function returns if voter is eligible to vote in the election.
	 *
	 * @since    1.0.0
	 */
	public function canVote( $e = false ) {
		
		if( get_user_meta( get_current_user_id(), 'voter', true ) == 1 ) {
							
			if( $e ) {
				
				if ( get_post_meta( $e, 'pv_election_vote_groups', true ) ) {
				
					$a = get_user_meta( get_current_user_id(), 'voter_vote_groups', true );
					
					$a1 = explode( ",", $a );
					
					$a2 = array_map( 'trim', $a1 );
					
					$b = get_post_meta( $e, 'pv_election_vote_groups', true );
					
					$b1 = explode( ",", $b );
					
					$b2 = array_map( 'trim', $b1 );
					
					if( count( array_intersect( $b2, $a2 ) ) > 0 ) {
					
						return true;
					
					} else {
					
						return false;
					
					} // End check if user is in vote group for election
				
				} else {
					
					return true;	
				
				} // End check if election id is present
				
			} else {
				
				return true;
			
			} // End check if election has specified vote groups
		
		} else{
			
			return false;
		
		} // End check if current user can vote
	
	} // End canVote function

	
	/**
	* Function returns if election has not yet opened. If voting hasn't opened then it returns the time until voting opens.
	*
	* @since    1.0.0
	*/
	public function voteTimeNotOpen( $id ) {
		
		$now = new DateTime( null, $this->get_blog_timezone() );
		
		if( $now->format( 'Y-m-d H:i:s' ) > get_post_meta( $id, 'pv_election_open', true ) ) {
		
			return false;
		
		} else { 
						
			$future_date = new DateTime( get_post_meta( $id, 'pv_election_open', true ), $this->get_blog_timezone() );
						
			$interval = $future_date->diff( $now );
			
			return $interval;
		
		} // End check if curent date and time is after vote opens
		
	} // End voteTimeNotOpen function

	
	/**
	* Function returns if election has not yet closed.
	*
	* @since    1.0.0
	*/
	public function voteTimeClose( $id ) {		
	
		$now = new DateTime( null, $this->get_blog_timezone() );
		
		if ( $now->format( 'Y-m-d H:i:s' ) > get_post_meta( $id, 'pv_election_close', true ) ) {
	
			return true;
	
		} else {
					
			return false;
		
		} // End check if curent date and time is before vote closes
	
	} // End voteTimeClose function


	/**
	* Function returns the IP Address of the user.
	*
	* @since    1.0.0
	*/
	public function get_ip() { 
		
		foreach (
		
			array(
		
				'HTTP_CLIENT_IP',
				
				'HTTP_X_FORWARDED_FOR',
				
				'HTTP_X_FORWARDED',
				
				'HTTP_X_CLUSTER_CLIENT_IP',
				
				'HTTP_FORWARDED_FOR',
				
				'HTTP_FORWARDED',
				
				'REMOTE_ADDR'
			
			) as $key
			
		) {
				
			if( array_key_exists( $key, $_SERVER ) === true ) {
				
				foreach ( array_map( 'trim', explode( ',', $_SERVER[ $key ] ) ) as $ip ) {
		
					if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) !== false ) {
						
						return $ip;
					
					}
				
				}
			
			}
		
		}

	} // End get_ip function
	
	
	/**
	* Function returns if voter has not yet voted. If voting has voted, then the function returns the user's id.
	*
	* @since    1.0.0
	*/
	public function not_voted( $election ){
		
		if( get_post_meta( $election, 'pv_election_ip_vote', true ) ) { 
			
			$voterId = $this->get_ip(); 
		
		} else { 
			
			$voterId = get_current_user_id(); 
		
		} // End check if election is being administered via IP.
			
		global $wpdb;

		$table_name = $wpdb->prefix . "pv_votes";

		$votes = $wpdb->get_results( "SELECT * FROM  $table_name WHERE voter='$voterId' AND election='$election'" );
		
		if(count($votes)>0){
			
			return false;
			
		} else {
			
			return $voterId;
		
		} // End check if a vote has been cast

	} // End not_voted function
	
	
	/**
	* Function returns if election has not yet opened. If voting hasn't opened then it returns the time until voting opens.
	*
	* @since    1.0.0
	*/
	public function get_pv_candidate_template( $single_template ) {
		
		global $post;
		
		if ( $post->post_type == 'pv_candidate' ) {
		
			$single_template = plugin_dir_path(__FILE__) . '/partials/pv_candidate-template.php';
		
		} // End if pv_candidate
		
		return $single_template;
	
	} //End get_pv_candidate_template function


	/**
	 *  Returns the blog timezone
	 *
	 * Gets timezone settings from the db. If a timezone identifier is used just turns
	 * it into a DateTimeZone. If an offset is used, it tries to find a suitable timezone.
	 * If all else fails it uses UTC.
	 *
	 * @return DateTimeZone The blog timezone
	 */
	public function get_blog_timezone() {
	
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
		if( empty( $tzstring ) ) {
		
			$tzstring = 'UTC';
		
		}
	
		$timezone = new DateTimeZone( $tzstring );
		
		return $timezone; 
	
	} // End function get_blog_timezone.
	
	
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
	
	
	/**
	* Function returns vote record.
	*
	* @since    1.0.0
	*/
	public function voteRecord( $current_user = NULL, $election = NULL ) {
		
		include_once( 'partials/assets/vote_record.php' );
                
	} // end voteRecord function.

}