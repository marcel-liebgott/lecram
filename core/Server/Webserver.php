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
use Lecram\Util\Requirement;
use Lecram\Util\Version;

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
	 * @return Version
	 */
	public function getPhpVersion() : Version{
	    $major = explode(".", phpversion())[0];
	    $minor = explode(".", phpversion())[1];
	    $patch = explode(".", phpversion())[2];

	    $phpVersion = new Version();
	    $phpVersion->setMajor($major);
	    $phpVersion->setMinor($minor);
	    $phpVersion->setPatch($patch);
		return $phpVersion;
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
	 * @param Requirement $requirment
	 * 					the requirement
	 */
	public function addRequirement(Requirement $requirment){
	    $this->requirements->add($requirment);
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
				$requirement = $iter->current();
				$requestedVersion = $requirement->getRequestedVersion();
				$availableVersion = $requirement->getServerRequirement()->getAvailableVersion();

				$requestedVersionId = $requestedVersion->getVersionId();
				$availableVersionId = $availableVersion->getVersionId();

				if($availableVersionId < $requestedVersionId){
				    return false;
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