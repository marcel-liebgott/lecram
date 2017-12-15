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

namespace Lecram\Server;

use Lecram\Util\Listable;
use Lecram\Singleton;

/**
 * Webserver class
 * 
 * @author Marcel Liebgott <marcel@mliebgott.de>
 * @package lecram
 * @since 1.0.0
 */
class Webserver extends Singleton{
	/**
	 * a list of all framework requirements
	 * 
	 * @access private
	 * @var Listable
	 */
	private $requirements;
	/**
	 * return a singleton instance
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return Webserver
	 */
	public static function getInstance() : Webserver{
		return parent::_getInstance(get_class());
	}
	
	/**
	 * constructor
	 * 
	 * @access protected
	 * @since 1.0.0
	 */
	protected function __construct(){
		$this->requirements = new Listable();
	}
	
	/**
	 * return the current installed php version
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return string
	 */
	public function getPhpVersion() : string{
		return phpversion();
	}
	
	/**
	 * return the current gd library
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return string
	 * @throws \Exception
	 */
	public function getGdVersion() : string{
		if(extension_loaded('gd') && function_exists('gd_info')){
			$gd = gd_info();
			return $gd['GD Version'];
		}
		
		throw new \Exception('GD library isn\'t installed on your webserver.');
	}
	
	/**
	 * add a requirement
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param string $key
	 * 					the requirement key
	 * @param string $available
	 * 					which version is currently available on the webserver
	 * @param string $requested
	 * 					which version does we need
	 * @param string $operation
	 * 					which version operation does we need
	 */
	public function addRequirement(string $key, string $available, string $requested, string $operation){
		$this->requirements->add(array($key => array($available => $requested)));
	}
	
	/**
	 * check if the webserver has all requirements
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return bool
	 */
	public function hasValidRequirements() : bool{
		if($this->requirements->count() > 0){
			$iter = $this->requirements->getIterator();
			
			while($iter->valid()){
				$ident = $iter->key();
				$data = $iter->current();
				
				$available = array_keys($data);
				$requested = array_values($data);
				
				$requestedArray = explode('.', $requested[0]);
				$availableArray = explode('.', $available[0]);
				
				for($i = 0; $i < count($requestedArray); $i++){
					if(intval($requestedArray[$i]) > intval($availableArray[$i])){
						return false;
					}
				}
				
				$iter->next();
			}
			
			return true;
		}else{
			// TODO add logger - maybe
			// no requirements are defined
		}
	}
}
?>