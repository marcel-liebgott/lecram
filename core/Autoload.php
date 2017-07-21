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
use Lecram\Exception\FileNotFoundException;
use Lecram\Exception\InvalidClassNameException;

require_once 'Singleton.php';

/**
 * a customozed application autoloader
 * 
 * @author Marcel Liebgott <marcel@mliebgott.de>
 * @package Lecram
 * @since 1.0.0
 */
class Autoload extends Singleton{
	/**
	 * prefix for class names
	 * 
	 * @var string
	 */
	private static $prefix;
	
	/**
	 * return a singleton Autloader instance
	 * 
	 * @access public
	 * @static
	 * @since 1.0.0
	 * @return Autoload
	 */
	public static function getInstance() : Autoload{
		return parent::_getInstance(get_class());
	}
	
	/**
	 * set a prefix for class names
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param string $prefix
	 */
	public function setPrefix(string $prefix) : void{
		self::$prefix = $prefix;
	}
	
	/**
	 * return the current class prefix
	 * 
	 * @access public
	 * @static
	 * @since 1.0.0
	 * @return string
	 */
	public static function getPrefix() : string{
		return self::$prefix;
	}
	
	/**
	 * register the current Autoloader
	 * 
	 * @access public
	 * @since 1.0.0
	 * @codeCoverageIgnore
	 */
	public function register() : void{
		spl_autoload_register([$this, 'autoload']);
	}
	
	/**
	 * unregister the current Autoloader
	 * 
	 * @access public
	 * @since 1.0.0
	 * @codeCoverageIgnore
	 */
	public function unregister() : void{
		spl_autoload_unregister(array($this, $this->autoload()));
	}
	
	/**
	 * handle class request
	 * 
	 * @access private
	 * @param string $class
	 * @codeCoverageIgnore
	 */
	public function autoload(string $class){		
		// get clear class name
		$lastBackSlash = strrpos($class, '\\');
		$className = $class;
		$namespace = '';
		
		if($lastBackSlash > 0){
			$className = substr($class, $lastBackSlash + 1);
			$namespace = substr($class, 0, $lastBackSlash);
		}
		
		if(!empty(self::$prefix) && substr($className, 0, strlen($this->prefix)) !== $className){
			throw new InvalidClassNameException("The requested class isn't valid");
		}
		
		// check if file exists
		$folderLocation = explode('\\', $namespace);
		$path = 'core' . DIRECTORY_SEPARATOR;
		
		foreach($folderLocation as $folder){			
			// ignore 'Lecram'
			if($folder === 'Lecram'){
				continue;
			}
			
			$path .= $folder . DIRECTORY_SEPARATOR;
		}
		
		$path .= $className . '.php';
		
		if(!file_exists($path)){
			throw new FileNotFoundException('Class "' . $className . "' not found");
		}
		
		require_once $path;
	}
}
?>