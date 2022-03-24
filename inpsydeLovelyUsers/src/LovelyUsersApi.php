<?php
namespace InpsydeLovelyUsers;
use \WP_REST_Server;
class LovelyUsersApi {
	const API_HOST = 'jsonplaceholder.typicode.com';
	const USERS_ENDPOINT = 'users';
	/**
	 * Register the REST API routes.
	 */
	public static function init() {	
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
			) );

			register_rest_route( 'InpsydeLovelyUsers/v1', '/lovely-user', array(
			  'methods' => WP_REST_Server::READABLE,
			//   'permission_callback' => function () {
			// 	return current_user_can( 'activate_plugin' );
			// },
			  'callback' =>  __CLASS__ . '::get_lovely_users',
			) );

		  } );
	}

	/**
	 * Connect to remote end to get data
	 * @param $endpoint
	 * @return WP_Error|WP_REST_Response
	 */
	public static function contact_remote($request ,$endpoint ) {
		try {
			$host = self::API_HOST;		
			$http_args = array(
				'headers' => array(
					'Content-Type' => 'application/json',
					'Host' => $host,
					// 'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Safari/537.36',
					'scheme' => 'https',
					'method' => WP_REST_Server::READABLE,
					// 'path' => '/users',
					// 'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9'
				),
				'HTTP' => '1.1',			
			);
			
			$lovely_users_url = "https://{$host}/{$endpoint}";		
			error_log( 'information goes here' );
			$response = wp_remote_get( $lovely_users_url, $http_args );

			if ( is_wp_error( $response ) ) {
				/*TODO: take failure action to handle error*/
				return $response;
			}		
			$response = wp_remote_retrieve_body( $response );
		} catch (\Throwable $th) {
			// throw $th;
			return false;		
		}		
		return $response;		
	}

	/**
	 * Get the Lovely user data from jsonplaceholder.typicode.com/users
	 * @param WP_REST_Request $request
	 * @return WP_Error|WP_REST_Response
	 */
	public static function get_lovely_users( $request ) {
		global $wp_query;
		$endpoint  = self::USERS_ENDPOINT;
		$users_data  = self::contact_remote($request,$endpoint);
		/*Add data in cache on first time retrival*/
		wp_cache_set('lovely-users-data', $users_data,'azka-asif');
		if ($cache_users_data = wp_cache_get('lovely-users-data', 'azka-asif')) {
			error_log("get data from cache");
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
		global $wp_query;
		$id = $request['id'];
		$endpoint  = self::USERS_ENDPOINT.'/'.$id;
		$users_data  = self::contact_remote($request,$endpoint);		      
		return $users_data;
	}

	public static function privileged_permission_callback() {
		return current_user_can( 'activate_plugins' );
	}

	public static function sanitize_key( $key, $request, $param ) {
		return trim( $key );
	}
}
