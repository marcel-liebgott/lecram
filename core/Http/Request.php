<?php
/**
 * Copyright (c) 2017 Marcel Liebgott
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 */

namespace Lecram\Http;

use Lecram\Util\Listable;

/**
 * handle all application request operations
 * 
 * @author Marcel Liebgott <marcel@mliebgott.de>
 * @package Lecram
 * @subpackage http
 * @since 1.0.0
 */
class Request{
	/**
	 * $_POST listable
	 * 
	 * @access private
	 * @var Listable
	 */
	private $post;
	
	/**
	 * $_GET listable
	 * 
	 * @access private
	 * @var Listable
	 */
	private $get;
	
	/**
	 * $_SERVER listable
	 * 
	 * @access public
	 * @var Listable
	 */
	private $server;
	
	/**
	 * $_COOKIE listable
	 * 
	 * @access private
	 * @var Listable
	 */
	private $cookie;
	
	/**
	 * constructor
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param array $get
	 * 				$_GET array
	 * @param array $post
	 * 				$_POST array
	 * @param array $cookie
	 * 				$_COOKIE array
	 * @param array $server
	 * 				$_SERVER array
	 */
	public function __construct(array $get = array(), array $post = array(), array $cookie = array(), array $server = array()){
		$this->post = new Listable($post);
		$this->get = new Listable($get);
		$this->cookie = new Listable($cookie);
		$this->server = new Listable($server);
	}
	
	/**
	 * create a Request instance with initialized global variables
	 * 
	 * @since 1.0.0
	 * @return Request
	 * @codeCoverageIgnore
	 */
	public static function createFromGlobals() : Request{
		return new static($_GET, $_POST, $_COOKIE, $_SERVER);
	}
	
	/**
	 * return a header value
	 * 
	 * @since 1.0.0
	 * @param string $type
	 * 				the key for the header value
	 * @return string
	 */
	public function getHeaderValue($type) : string{
		if($this->server->get($type)){
			return $this->server->get($type);
		}
	}
	
	/**
	 * if this request is secure (https)
	 * 
	 * @since 1.0.0
	 * @return bool
	 */
	public function isSecure() : bool{
		$https = $this->server->get('HTTPS');
		
		return !empty($https) && 'off' !== $https;
	}
	
	/**
	 * return the request host
	 * 
	 * @since 1.0.0
	 * @return string
	 */
	public function getHost() : string{
		return $this->server->get('HTTP_HOST');
	}
	
	/**
	 * return the request port
	 * 
	 * @since 1.0.0
	 * @return int
	 */
	public function getPort() : int{
		return $this->server->get('SERVER_PORT');
	}
	
	
	/**
	 * return the http host
	 * 
	 * @since 1.0.0
	 * @return string
	 */
	public function getHttpHost() : string{
		return $this->getHost() . ':' . $this->getPort();
	}
	
	/**
	 * return the request scheme
	 * 
	 * @since 1.0.0
	 * @return string
	 */
	public function getScheme() : string{
		return $this->isSecure() ? 'https' : 'http';
	}
	
	/**
	 * return the user for http authentification
	 * 
	 * @since 1.0.0
	 * @return string
	 */
	public function getUser() : string{
		return $this->server->get('PHP_AUTH_USER');
	}
	
	/**
	 * return the user passwort for http authentification
	 * 
	 * @since 1.0.0
	 * @return string
	 */
	public function getPassword() : string{
		return $this->server->get('PHP_AUTH_PW');
	}
	
	/**
	 * return the client ip
	 * 
	 * @since 1.0.0
	 * @return string
	 */
	public function getClientIp() : string {
		return $this->server->get('REMOTE_ADDR');
	}
	
	/**
	 * return the request base url
	 * 
	 * @since 1.0.0
	 * @return string
	 */
	public function getBaseUrl() : string{		
		if(!empty($this->server->get('PHP_SELF'))){
			return $this->server->get('PHP_SELF');
		}elseif(!empty($this->server->get('SCRIPT_NAME'))){
			return $this->server->get('SCRIPT_NAME');
		}
		
		return '';
	}
	
	/**
	 * return the request query string
	 * 
	 * @since 1.0.0
	 * @return string
	 */
	public function getQueryString(){
		$queryString = $this->server->get('QUERY_STRING');
		return $queryString !== '' ? $queryString : '';
	}
	
	/**
	 * return the request uri
	 * 
	 * @since 1.0.0
	 * @return string
	 */
	public function getRequestUri() : string{
		return trim($this->server->get('REQUEST_URI'), '/');
	}
	
	/**
	 * return the request uri
	 * 
	 * @since 1.0.0
	 * @return string
	 */
	public function getUri() : string{
		$schemeAndHttpHost = $this->getScheme() . '://' . $this->getHttpHost();
		
		return $schemeAndHttpHost . $this->getBaseUrl() . (!empty($this->getQueryString()) ? '?' . $this->getQueryString() : '');
	}
    
	/**
	 * create a request instance by given configuration
	 * 
	 * @param string $uri
	 * 					the URI
	 * @param string $method
	 * 					the http request methode
	 * @param array $server
	 * 					server properties
	 * @return Request
	 */
    public static function create($uri, $method, $server = array()) : Request{
    	$serverData = array_replace(array(
    		'SERVER_NAME' =>		'localhost',
    		'SERVER_PORT' =>		80,
    		'HTTP_HOST' =>			'localhost',
    		'REMOTE_ADDR' =>		'127.0.0.1',
    		'SCRIPT_FILENAME' => 	''
    	), $server);
    	
    	$server = new Listable($serverData);
    	$parameter = new Listable(parse_url($uri));
    	
    	$server->add(array('REQUEST_METHOD', strtoupper($method)));
    	
    	if($parameter->exists('scheme')){
    		if($parameter->get('scheme') === 'https'){
    			$server->add(array('HTTPS' => 'on'));
    			$server->add(array('SERVER_PORT' => 443));
    		}else{
    			$server->remove('HTTPS');
    			$server->add(array('SERVER_PORT' => 80));
    		}
    	}
    	
    	if($parameter->exists('host')){
    		$serverHostData = array(
    			'SERVER_NAME' => 	$parameter->get('host'),
    			'HTTP_HOST' => 		$parameter->get('host')
    		);
    		$server->add($serverHostData);
    	}
    	
    	if($parameter->exists('port')){
    		$server->add(array('SERVER_PORT' => $parameter->get('port')));
    	}
    	
    	if($parameter->exists('user')){
    		$server->add(array('PHP_AUTH_USER' => $parameter->get('user')));
    	}
    	
    	if($parameter->exists('pass')){
    		$server->add(array('PHP_AUTH_PW' => $parameter->get('pass')));
    	}
    	
    	if($parameter->exists('path')){
    		$parameter->add(array('path' => $parameter->get('path')));
    		$server->add(array('QUERY_STRING' => $parameter->get('path')));
    	}
    	
    	$query = '';
    	
    	if($parameter->exists('query')){
    		$query = $parameter->get('query');
    	}
    	
    	$server->add(array('REQUEST_URI' => $parameter->get('path') . ($query !== '' ? '?' . $query : '')));
    	$server->add(array('QUERY_STRING' => $query));
    	$server->add(array('SCRIPT_NAME' => $parameter->get('path')));
    	
    	return new static(array(), array(), array(), $server->toArray());
    }
}
?>