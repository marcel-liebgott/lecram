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
 * handle all application response operations
 * 
 * @author Marcel Liebgott <marcel@mliebgott.de>
 * @package Lecram
 * @subpackage http
 * @since 1.0.0
 */
class Response{
	/**
	 * http version
	 * 1.0, 1.1 or 2
	 * 
	 * @var int
	 */
	private $version;
	/**
	 * header information collection
	 * 
	 * @var Listable
	 */
	private $header;
	
	/**
	 * header content
	 * 
	 * @var string
	 */
	private $content;
	
	/**
	 * header status code
	 * 
	 * @var int
	 */
	private $statusCode = 200;
	
	/**
	 * how long does store this element in cache, in seconds
	 * 
	 * @var int
	 */
	private $age;
	
	/**
	 * special version of a file
	 * 
	 * @var string
	 */
	private $etag;
	
	/**
	 * define the authentification method
	 * 
	 * @var string
	 */
	private $wwwAuthenticate;
	
	/**
	 * constructor
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param string $content
	 * @param int $status
	 * @param Listable $parameters
	 */
	public function __construct(string $content, int $status = 200, Listable $parameters){
		$this->content = $content;
		$this->statusCode = $status;
		$this->header = $parameters;
	}
	
	/**
	 * add header information
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param string $key
	 * @param string $content
	 */
	public function addHeaderInformation(string $key, string $content) : void{
		$this->header->add(array($key => $content));
	}
	
	/**
	 * return header information
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param string $key
	 * @return mixed
	 */
	public function getHeaderInformation(string $key){
		return $this->header->get($key);
	}
	
	/**
	 * set the header status code
	 * 
	 * @access public
	 * @since 1.0.1
	 * @param int $code
	 */
	public function setStatusCode($code) : void{
		$this->statusCode = $code;
	}
	
	/**
	 * return the header status code
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return int
	 */
	public function getStatusCode() : int{
		return $this->statusCode;
	}
	
	/**
	 * set header content
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param string $content
	 */
	public function setContent(string $content) : void{
		$this->content = $content;
	}
	
	/**
	 * concatenate (append) the header with a substring
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param string $content
	 */
	public function addContent(string $content) : void{
		$this->content .= $content;
	}
	
	/**
	 * return header content
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return string
	 */
	public function getContent() : string{
		return $this->content;
	}
	
	/**
	 * return the header content
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return Listable
	 */
	public function getHeader() : Listable{
		return $this->header;
	}
	
	/**
	 * set http response age
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param int $age
	 */
	public function setAge(int $age) : void{
		$this->age = $age;
	}
	
	/**
	 * get http response age
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return int
	 */
	public function getAge() : int{
		return $this->age;
	}
	
	/**
	 * set http response etag
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param string $etag
	 */
	public function setEtag(string $etag) : void{
		$this->etag = $etag;
	}
	
	/**
	 * get http response etag
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param bool $useWeakValidator		use a weak validator
	 * @return string
	 */
	public function getEtag(bool $useWeakValidator) : string{
		$response = $this->etag;
		
		if($useWeakValidator){
			$response = 'W/' . $this->etag;
		}
		
		return $response;
	}
	
	/**
	 * set the http response WWW-Authentification mode
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param string $auth
	 * @throws InvalidArgumentException
	 */
	public function setWwwAuthentification(string $auth) : void{
		if(!in_array(strtolower($auth), array('basic', 'bearer', 'digest', 'hoba', 'mutual', 'aws4-hmac-sha256'))){
			throw new \InvalidArgumentException('Authentification mode "' . $auth . "' isn\'t provided.");
		}
		
		$this->wwwAuthenticate = $auth;
	}
	
	/**
	 * get the http response WWW-Authentification
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return string
	 */
	public function getWwwAuthentification() : string{
		return $this->wwwAuthenticate;
	}
	
	/**
	 * create a response instance by given configuration
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param string $content
	 * @param int $status
	 * @param Listable $parameters
	 * @return Response
	 */
	public static function create(string $content, int $status = 200, Listable $parameters) : Response{
		return new static($content, $status, $parameters);
	}
}
?>