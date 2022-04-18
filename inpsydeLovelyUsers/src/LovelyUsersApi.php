<?php
namespace InpsydeLovelyUsers;
use \WP_REST_Server;
use InpsydeLovelyUsers\Register;
class LovelyUsersApi {
	/**
	 * 
	 */
	public function __construct() {
		/*Call register module contruct*/
	}
	public function init() {		
		Register::registerRoutes();
	}
	
}
