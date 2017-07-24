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

/**
 * base class for all singletons
 *
 * @author Marcel Liebgott <marcel@mliebgott.de>
 * @package Lecram
 * @subpackage http
 * @version 1.00
 *
 * @codeCoverageIgnore
 */
abstract class Singleton{
	/**
	 * all instances
	 *
	 * @access private
	 * @var array
	 */
	private static $instances = array();
	
	/**
	 * is called constructor is locked
	 * 
	 * @access private
	 * @var boolean
	 */
	private static $locked = true;
	
	/**
	 * get a singleton instance
	 *
	 * @access protected
	 * @static
	 * @since 1.00
	 * @param string $class		
	 * 					the requested singleton object
	 * @return Object
	 */
	protected static function _getInstance($class){
		if(!isset(self::$instances[$class])){
			self::$locked = false;
			self::$instances[$class] = new $class();
			self::$locked = true;
		}
		
		return self::$instances[$class];
	}
	
	/**
	 * constructor
	 *
	 * @access protected
	 * @throws Exception
	 */
	protected function __construct(){
		if(self::$locked){
			throw new Exception("Called class is a singleton class");
		}
	}
	
	/**
	 * clone constructor
	 */
	private function __clone(){}
}
?>
