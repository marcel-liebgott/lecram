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

namespace Lecram\Util;

use IteratorAggregate;
use Countable;

/**
 * A listable is a collection of key - value pairs
 * 
 * @author Marcel Liebgott <marcel@mliebgott.de>
 * @package Lecram
 * @subpackage util
 * @since 1.0.0
 */
class Listable implements IteratorAggregate, Countable{
	/**
	 * listable parameter
	 * 
	 * @var array
	 */
	private $parameters;
	
	/**
	 * constructor
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param array $parameters
	 * 				listable key value couples
	 */
	public function __construct(array $parameters = array()){
		$this->parameters = $parameters;
	}
	
	/**
	 * check if an key exists in the parameter list
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param string $key
	 * 				the requested key which we want to check their existens
	 * @return bool
	 */
	public function exists(string $key) : bool{
		return array_key_exists($key, $this->parameters);
	}
	
	/**
	 * return the value of the requested key if their exists
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param string $key
	 * 				the requested key whcih we want to get the value
	 * @return mixed
	 */
	public function get(string $key){
		return $this->exists($key) ? $this->parameters[$key] : null;
	}
	
	/**
	 * add or modify a key value pair to this collection
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param mixed $parameters		the array which we want to merge with the stored one
	 * @return Listable
	 */
	public function add($parameters) : Listable{
		if(gettype($parameters) === "array"){
			$this->parameters = array_replace($this->parameters, $parameters);
		}elseif($parameters instanceof Listable){
			$iter = $parameters->getIterator();
			
			foreach($iter as $elem){
				$this->add($elem);
			}
		}elseif(gettype($parameters) === "object"){
			$this->parameters = array($parameters);
		}
		
		return $this;
	}
	
	/**
	 * remove a entry from this collection
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param string $key		the key which we want to delete
	 */
	public function remove(string $key) : void{
		unset($this->parameters[$key]);
	}
	
	/**
	 * convert the current listable object into an core array
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return array
	 */
	public function toArray() : array{
		return iterator_to_array($this->getIterator(), true);
	}
	
	/**
	 * {@inheritDoc}
	 * @see IteratorAggregate::getIterator()
	 */
	public function getIterator() : \ArrayIterator{
		return new \ArrayIterator($this->parameters);
	}
	
	/**
	 * {@inheritDoc}
	 * @see Countable::count()
	 */
	public function count() : int{
		return count($this->parameters);
	}
}
?>