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

namespace Lecram;

use Lecram\Singleton;
use Lecram\Http\Request;

/**
 * analyse the request and run their defined execution  
 * 
 * @author Marcel Liebgott <marcel@mliebgott.de>
 * @package Lecram
 * @since 1.0.0
 */
class Bootstrap extends Singleton{
	const CONTROLLER_DIR = '.' . DIRECTORY_SEPARATOR . 'controller';
	
	/**
	 * request instance
	 * 
	 * @access private
	 * @var Request
	 */
	private $request;
	
	/**
	 * create a singleton instance
	 * @return Bootstrap
	 */
	public static function getInstance() : Bootstrap {
		return parent::_getInstance(get_class());
	}
	
	/**
	 * construcotor
	 * 
	 * @access protected
	 * @since 1.0.0
	 */
	protected function __construct(){
	}
	
	/**
	 * set a request instance
	 * 
	 * @since 1.0.0
	 * @param Request $request
	 * 				set the request instance
	 */
	public function setReuqest(Request $request) : void{
		$this->request = $request;
	}
	
	/**
	 * run bootstrap
	 * 
	 * @access public
	 * @since 1.0.0
	 */
	public function run() : void{
		$this->analyseUrl();
	}
	
	/**
	 * analyse the current url
	 * 
	 * @access private
	 * @since 1.00
	 */
	private function analyseUrl(): void{
		$uri = $this->request->getUri();
		
		echo "url: " . $uri;
		$controller = $uri[0];
		
		// all files are lower case
		$controller = strtolower($controller);
		$this->loadController($controller);
	}
	
	/**
	 * load the requested controller
	 * 
	 * @access private
	 * @since 1.00
	 * @param string $controller
	 * 				the requested controller name as string 
	 */
	private function loadController(string $controller){
		if($this->existsController($controller)){
			$path = self::CONTROLLER_DIR . DIRECTORY_SEPARATOR . $controller . '.php';
			
			require_once $path;
		}
	}
	
	/**
	 * check if an controller file exists
	 * 
	 * @access private
	 * @since 1.00
	 * @param string $controller
	 * 				the requested controller name as string which we want to check their existance
	 * @return bool
	 */
	private function existsController(string $controller) : bool {
		$controllerDirPath = self::CONTROLLER_DIR . DIRECTORY_SEPARATOR . $controller;
		
		if(is_dir($controllerDirPath) && file_exists($controllerDirPath . DIRECTORY_SEPARATOR . 'module.php')){
			return true;
		}
		
		return false;
	}
}
?>