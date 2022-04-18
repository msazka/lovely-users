<?php
namespace InpsydeLovelyUsers;
use \WP_REST_Server;
class Params {

    const API_HOST = 'jsonplaceholder.typicode.com';
    const USERS_ENDPOINT = 'users';
    const CONTENT_TYPE = 'application/json';
    const SCHEME = 'https';
    const HTTP_VER = '1.1';
    const USER_DETAIL_ENDPOINT = 'users';

    /**
	 * The object returning static remote values
	 *
	 * @var params
	 */
	private $params;	

    public function __construct($params) {
        error_log("contruct of param");
        $this->params = $this->get_data();
    }	
    
    private function get_data() {
        $http_args = array(
            'headers' => array(
                'Content-Type' => self::CONTENT_TYPE,
                'Host' => self::API_HOST,               
                'scheme' => self::SCHEME,
                'method' => WP_REST_Server::READABLE,
            ),
            'HTTP' => self::HTTP_VER,			
        );
        $args = array ('host' => self::API_HOST, 'http_args'=> $http_args); 
		return $args;
    }

    public static function getUserURL($request) {
        $url =  self::SCHEME."://".self::API_HOST."/".self::USER_DETAIL_ENDPOINT;
        if (!empty($request['id'])) {
            error_log("get Url ?");
            $url =  self::SCHEME."://".self::API_HOST."/".self::USER_DETAIL_ENDPOINT."/".$request['id'];
        }       
        return $url;
    }
	
	
}
