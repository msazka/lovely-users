<?php
namespace InpsydeLovelyUsers;
use \WP_REST_Server;
use InpsydeLovelyUsers\Remote;
class Register {
	
	/**
	 * Register the REST API routes.
	 */
	public static function registerRoutes() {	
		if ( ! function_exists( 'register_rest_route' ) ) {
			// The REST API wasn't integrated into core until 4.4, and we support 4.0+ (for now).
			return false;
		}
		
		add_action( 'rest_api_init', function () {
			register_rest_route( 'InpsydeLovelyUsers/v1', '/lovely-user/(?P<id>\d+)', array(
			  'methods' => WP_REST_Server::READABLE,
			  'callback' =>  __CLASS__ . '::get_lovely_users_detail',
			  'args' => array(
				'id' => array(
				  'required' => true,
					'type' => 'string',
		 			'sanitize_callback' => 'sanitize_key'
				),
			  ),
			//   'permission_callback' => function () {
			// 	return current_user_can( 'activate_plugin' );
			//   }
			));

			register_rest_route( 'InpsydeLovelyUsers/v1', '/lovely-user', array(
			  'methods' => WP_REST_Server::READABLE,
			// 'permission_callback' => function () {
			// 	return current_user_can( 'activate_plugin' );
			// },
			  'callback' =>  __CLASS__ . '::get_lovely_users',
			));
		  });
	}

	/**
	 * Get the Lovely user data from jsonplaceholder.typicode.com/users
	 * @param WP_REST_Request $request
	 * @return WP_Error|WP_REST_Response
	 */
	public static function get_lovely_users( $request ) {
		$users_data  = Remote::contactRemote($request);
		/*Add data in cache on first time retrival*/
		wp_cache_set('lovely-users-data', $users_data,'azka-asif');
		/*Get data from cache if tis cached*/
		if ($cache_users_data = wp_cache_get('lovely-users-data', 'azka-asif')) {			
			return $cache_users_data;
		}
		return $users_data;
	}

	/**
	 * Get the Lovely user data from jsonplaceholder.typicode.com/users
	 * @param WP_REST_Request $request
	 * @return WP_Error|WP_REST_Response
	 */
	public static function get_lovely_users_detail( $request ) {
		$users_data  =  Remote::contactRemote($request);		      
		return $users_data;
	}

	public static function privileged_permission_callback() {
		return current_user_can( 'activate_plugins' );
	}

	public static function sanitize_key( $key, $request, $param ) {
		return trim( $key );
	}
}
