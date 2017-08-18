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

use Lecram\Bootstrap;
use Lecram\Http\Request;
use Lecram\Server\Webserver;
use Lecram\Server\WebserverRequirement;

/**
 * Main application class
 * 
 * @author Marcel Liebgott <marcel@mliebgott.de>
 * @package Lecram
 * @version 1.0.0
 */
class Application{
	/**
	 * the autoloader instance
	 * 
	 * @var Autoload
	 */
	private $autoloader;
	
	/**
	 * current webserver instance
	 * 
	 * @access private
	 * @var Webserver
	 */
	private $webserver;
	
	/**
	 * constructor
	 * 
	 * @access public
	 * @since 1.0.0
	 */
	public function __construct(){
	}
	
	/**
	 * set the autoloader for this application and register them
	 * 
	 * @since 1.0.0
	 * @param Autoload $autoload
	 */
	public function setAutoloader(Autoload $autoload) : void{
		$this->autoloader = $autoload;
		
		if($this->autoloader !== null){
			$this->autoloader->register();
		}
	}
	
	/**
	 * get the current application autoloader
	 * 
	 * @since 1.0.0
	 * @return Autoload
	 */
	public function getAutoloader() : Autoload{
		return $this->autoloader;
	}
	
	/**
	 * run the application
	 * 
	 * @access public
	 * @since 1.0.0
	 * @codeCoverageIgnore
	 */
	public function run(){
		$this->webserver = Webserver::getInstance();
		$this->addWebserverRequirements();
		
		if($this->webserver->hasValidRequirements()){
			$bootstrap = Bootstrap::getInstance();
			$request = Request::createFromGlobals();
			
			$bootstrap->setReuqest($request);
			$bootstrap->run();
		}else{
			echo "your webserver hasn't the minimum software requirements!";
		}
	}
	
	/**
	 * add default webserver requirements
	 * 
	 * @access private
	 * @since 1.0.0
	 */
	private function addWebserverRequirements(){
		$this->webserver->addRequirement('php', $this->webserver->getPhpVersion(), '7.2', WebserverRequirement::MIN);
	}
}
?>