<?php
namespace InpsydeLovelyUsers;
use InpsydeLovelyUsers\Params;
use \WP_REST_Server;
class Remote {
	
	
	public static $args;

	public function __construct(Params $params) {	
		static::$args = $params;
	}

	/**
	 * Connect to remote end to get data
	 * @param $endpoint
	 * @return WP_Error|WP_REST_Response
	 */

	public static function contactRemote($request) {
		error_log("Contact REmote ++++++++++++++++++++++++++");
		try {			
			$http_args = static::$args['http_args'];
			$lovely_users_url = Params::getUserURL($request);
			// $lovely_users_url = "https://{$host}/{$endpoint}";		
			error_log( $http_args);
			$response = wp_remote_get( $lovely_users_url, $http_args );

			if ( is_wp_error( $response ) ) {
				/*TODO: take failure action to handle error*/
				return $response;
			}		
			$response = wp_remote_retrieve_body( $response );
		} catch (\Throwable $th) {
			 throw $th;
			// return false;		
		}		
		return $response;		
	}
	
}
