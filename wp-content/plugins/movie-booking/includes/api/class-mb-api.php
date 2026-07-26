<?php 
defined( 'ABSPATH' ) || exit;

use \Firebase\JWT\JWT;

if ( class_exists( 'MB_API', false ) ) {
	return new MB_API();
}

/**
 * Admin Assets classes
 */
class MB_API{

	protected static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}


	/**
	 * Constructor
	 */

	public function __construct(){

		add_action( 'rest_api_init', array( $this, 'mb_register_routes' ) );

	}

	public function mb_register_routes(){

		register_rest_route( 'aovis/v1', '/login/', array(
			'methods' 	=> 'POST',
		    'callback' 	=> array( $this, 'mb_login' ),
		    'permission_callback' => '__return_true'
		  ) );

		register_rest_route( 'aovis/v1', '/check_login/', array(
			'methods' 	=> 'POST',
		    'callback' 	=> array( $this, 'mb_check_login' ),
		    'permission_callback' => '__return_true'
		  ) );

		

		 register_rest_route( 'aovis/v1', '/movie_accepted/', array(
		    'methods' 	=> 'POST',
		    'callback' 	=> array( $this, 'mb_movie_accepted' ),
		    'permission_callback' => '__return_true'
		  ) );

		  register_rest_route( 'aovis/v1', '/validate_ticket/', array(
		    'methods' 	=> 'POST',
		    'callback' 	=> array( $this, 'mb_validate_ticket' ),
		    'permission_callback' => '__return_true'
		  ) );
	}

	// User Login 
	public function mb_login( WP_REST_Request $request ){

		$user = sanitize_user( $request->get_param('user') );
		$pass = trim( $request->get_param('pass') );

		// Check acount
		$aut = wp_authenticate_username_password( NULL, $user, $pass );	
		if( is_wp_error( $aut ) ){
			return array(  'status' => 'FAIL' , 'msg' => esc_html__( 'Error Username or Password', 'moviebooking' ) );
		}


        $userid = $aut->ID;
        $email = $aut->user_email;
        $user_login = $aut->user_login;

        try {
        	$jwt = $this->mb_make_token( $userid, $email, $user_login ) ;
			return array(  'status' => 'SUCCESS', 'token' => $jwt, 'msg' => esc_html__( 'Login success', 'moviebooking' ) );
        } catch (Exception $e) {
        	return array(  'status' => 'FAIL' , 'msg' => esc_html__( 'Error make token', 'moviebooking' ) );
        }

        return array(  'status' => 'FAIL' , 'msg' => esc_html__( 'Error Something', 'moviebooking' ) );

	}


	public function mb_check_login( WP_REST_Request $request ){

		// Get Token
		$token = $request->get_param('token');

		// Key serect qrcode
		$key = MB()->options->checkout->get('serect_key_qrcode', 'xxxdfsferefdfd');

		try{

			$decoded = JWT::decode($token, $key, array('HS256') );

			$user = get_user_by( 'ID', $decoded->uid );

			if($user && $user->user_email == $decoded->uemail ){
				$jwt = $this->mb_make_token( $user->ID, $user->user_email, $user->user_login );
				return array(  'status' => 'SUCCESS', 'token' => $jwt );
			}

		} catch(Exception $e){
			
			return array( 'status' => 'FAIL', 'msg' => $e->getMessage() );

		}
		
		return array( 'status' => 'FAIL', 'msg' => esc_html__( 'Error', 'moviebooking' ) );

		
	}
	

	// Gel All Tickets of an Event
	public function mb_movie_accepted( WP_REST_Request $request ){


		$token = $request->get_param('token');
		// Key serect qrcode
		$key = MB()->options->checkout->get('serect_key_qrcode', 'xxxdfsferefdfd');
		
		try{

			$decoded = JWT::decode($token, $key, array('HS256') );

			$eids = $decoded->eids ;
			$eids_arr = explode( ',', $eids );

			$args = array(
				'post_type' => 'movie',
				'post_status' => 'publish',
				'numberposts' => '-1',
				'post__in'	=> $eids_arr
				
			);
			return array( 'status' => 'SUCCESS', 'movies' => get_posts ( $args ) );
			
			
		}
		catch(Exception $e){
			return array( 'status' => 'FAIL', 'msg' => $e->getMessage() );
		}

		return array( 'status' => 'FAIL', 'msg' => esc_html__( 'Error', 'moviebooking' ) );

	}
	

	
	// Validate Ticket
	public function mb_validate_ticket( WP_REST_Request $request ){

		$token 	= $request->get_param('token');
		
		$qrcode = $request->get_param('qrcode');

		$eid = $request->get_param('eid');

		// Key serect qrcode
		$key = MB()->options->checkout->get('serect_key_qrcode', 'xxxdfsferefdfd');

		
		
		// Validate Token
		try{

			$decoded = JWT::decode($token, $key, array('HS256') );

			$eids_arr = explode( ',', $decoded->eids );

			if( in_array(intval($eid), $eids_arr) ){

				$args = array(
					'post_type' 	=> 'mb_ticket',
					'post_status' 	=> 'publish',
					'numberposts' 	=> '-1',
					'fields'		=> 'ids',
					'meta_query' 	=> array(
						'relation' 	=> 'AND',
						array(
							'key' 		=> MB_PLUGIN_PREFIX_TICKET . 'qr_code',
							'value' 	=> $qrcode,
							'compare'	=> '=',
						),
						array(
							'key' 		=> MB_PLUGIN_PREFIX_TICKET . 'movie_id',
							'value' 	=> strval( $eid ),
							'compare'	=> '=',
						)
					)
					
				);

				$ticket_id = get_posts ( $args );

				if ( !$ticket_id ) {
					return array( 
						'status' 		=> 'FAIL', 
						'msg' 			=> esc_html__( 'Not Found QR Code', 'moviebooking' ) .': '. $qrcode,
						'checkin_time' 	=> '',
						'name_customer' => '',
						'seat'			=> '',
						'extra_service'	=> '',
						'e_showtime' 	=> ''
					);
				}

				$ticket_status = get_post_meta( $ticket_id[0], MB_PLUGIN_PREFIX_TICKET.'ticket_status', true );
				
				if ( $ticket_status === 'checked' ) {
					$checkin_time_tmp 	= get_post_meta( $ticket_id[0], MB_PLUGIN_PREFIX_TICKET.'checkin_time', true ) ;
					$checkin_time 		=  $checkin_time_tmp ? date_i18n( get_option( 'date_format' ).' '. get_option( 'time_format' ), $checkin_time_tmp ) : '';
					$name_customer 		= get_post_meta( $ticket_id[0], MB_PLUGIN_PREFIX_TICKET.'customer_name', true ) ;
					$seat 				= get_post_meta( $ticket_id[0], MB_PLUGIN_PREFIX_TICKET.'seat', true ) ;
					$extra_service 		= get_post_meta( $ticket_id[0], MB_PLUGIN_PREFIX_TICKET.'extra_service', true ) ;
					$person_type 		= get_post_meta( $ticket_id[0], MB_PLUGIN_PREFIX_TICKET.'person_type', true ) ;

					if ( ! empty( $person_type ) ) {
						$seat .= ' - '.$person_type;
					}

					if ( ! empty( $extra_service ) ) {
						$extra_service = mb_ticket_get_extra_service( $extra_service );
						$extra_service = implode(', ', $extra_service);
					}

					// Showtimes
					$date_format    	= MBC()->mb_get_date_time_format();
					$date 				= get_post_meta( $ticket_id[0], MB_PLUGIN_PREFIX_TICKET.'date', true ) ;
					$showtime 			= date( $date_format, $date );

					return array( 
						'status' 		=> 'FAIL', 
						'msg' 			=> esc_html__( 'Already Checked In', 'moviebooking' ), 
						'checkin_time' 	=> $checkin_time,
						'name_customer' => $name_customer,
						'seat'			=> $seat,
						'extra_service'	=> $extra_service,
						'e_showtime' 	=> $showtime
					);
				} elseif ( ! $ticket_status ) {
						$ticket = array(
							'ID' 			=> $ticket_id[0],
							'meta_input' 	=> array(
								MB_PLUGIN_PREFIX_TICKET.'ticket_status' => 'checked',
								MB_PLUGIN_PREFIX_TICKET.'checkin_time' 	=> current_time('timestamp')
							)
						);

						if ( wp_update_post( $ticket ) ) {
							$checkin_time_tmp 	= get_post_meta( $ticket_id[0], MB_PLUGIN_PREFIX_TICKET.'checkin_time', true ) ;
							$checkin_time 		=  $checkin_time_tmp ? date_i18n( get_option( 'date_format' ).' '. get_option( 'time_format' ), $checkin_time_tmp ) : '';
							$name_customer 		= get_post_meta( $ticket_id[0], MB_PLUGIN_PREFIX_TICKET.'customer_name', true ) ;
							$seat 				= get_post_meta( $ticket_id[0], MB_PLUGIN_PREFIX_TICKET.'seat', true ) ;
							$extra_service 		= get_post_meta( $ticket_id[0], MB_PLUGIN_PREFIX_TICKET.'extra_service', true ) ;
							$person_type 		= get_post_meta( $ticket_id[0], MB_PLUGIN_PREFIX_TICKET.'person_type', true ) ;

							if ( ! empty( $person_type ) ) {
								$seat .= ' - '.$person_type;
							}
							if ( ! empty( $extra_service ) ) {
								$extra_service = mb_ticket_get_extra_service( $extra_service );
								$extra_service = implode(', ', $extra_service);
							}
							// Showtimes
							$date_format 	= MBC()->mb_get_date_time_format();
							$date 			= get_post_meta( $ticket_id[0], MB_PLUGIN_PREFIX_TICKET.'date', true ) ;
							$showtime 		= date( $date_format, $date );

							return array( 
								'status' 		=> 'SUCCESS', 
								'msg' 			=> esc_html__( 'Success', 'moviebooking' ), 
								'checkin_time' 	=> $checkin_time,
								'name_customer' => $name_customer,
								'seat'			=> $seat,
								'extra_service'	=> $extra_service,
								'e_showtime' 	=> $showtime
							);
						} else {
							return array( 
								'status' 		=> 'FAIL', 
								'msg' 			=> esc_html__( 'Can\'t update ticket status', 'moviebooking' ),
								'checkin_time' 	=> '',
								'name_customer' => '',
								'seat'			=> '',
								'extra_service'	=> '',
								'e_showtime' 	=> ''
							);
						}
				} else {
					return array( 
						'status' 		=> 'FAIL', 
						'msg' 			=> esc_html__( 'Not Found QR Code', 'moviebooking' ) .': '. $qrcode,
						'checkin_time' 	=> '',
						'name_customer' => '',
						'seat'			=> '',
						'extra_service'	=> '',
						'e_showtime' 	=> ''
					);
				}
			} else { // Not found Event Id in Token
				return array( 
					'status' 		=> 'FAIL', 
					'msg' 			=> esc_html__( 'Please check surely, you have permission to scan this ticket', 'moviebooking' ),
					'checkin_time' 	=> '',
					'name_customer' => '',
					'seat'			=> '',
					'extra_service'	=> '',
					'e_showtime' 	=> ''
				);
			}
		}

		catch(Exception $e){
			return array( 
				'status' 		=> 'FAIL', 
				'msg' 			=> esc_html__( 'Exception Error', 'moviebooking' ),
				'checkin_time' 	=> '',
				'name_customer' => '',
				'seat'			=> '',
				'extra_service'	=> '',
				'e_showtime' 	=> ''
			);
		}
		
		return array( 
			'status' 		=> 'FAIL', 
			'msg' 			=> esc_html__( 'Error', 'moviebooking' ),
			'checkin_time' 	=> '',
			'name_customer' => '',
			'seat'			=> '',
			'extra_service'	=> '',
			'e_showtime' 	=> ''
		);
	}

	function mb_make_token($userid, $email, $user_login ){

		// Key Serect			
		$key = MB()->options->checkout->get('serect_key_qrcode', 'xxxdfsferefdfd');
		
        $issuedAt = time();
        $expire = apply_filters('mb_auth_expire', $issuedAt + (7*24*60*60), $issuedAt);

        $args1 = array(
			'post_type' 	=> 'movie',
			'post_status' 	=> 'publish',
			'numberposts' 	=> '-1',
			'fields'		=> 'ids',
			'meta_query' 	=> array(
				array(
					'key' 		=> MB_PLUGIN_PREFIX_MOVIE.'staff_check_tickets',
					'value' 	=> $user_login,
					'compare'	=> '=',
				)
			)
			
		);
		
		$movies_ids1 = get_posts ( $args1 );

		$args2 = array(
			'post_type' 	=> 'movie',
			'post_status' 	=> 'publish',
			'numberposts' 	=> '-1',
			'fields'		=> 'ids',
			'author_name' 	=> $user_login
		);

		$movie_ids2 = get_posts ( $args2 );
		$movies_ids = array_merge( $movies_ids1, $movie_ids2 );

        $payload = array(
            'uid' => $userid,
            'uemail' => $email,
            'eids'	=> implode( ',', $movies_ids ),
            'exp' => $expire
        );
        
        return JWT::encode($payload, $key, 'HS256');	
		
	}
}

MB_API::instance();