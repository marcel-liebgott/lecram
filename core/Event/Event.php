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
namespace Lecram\Event;

use Lecram\Util\Listable;

/**
 * Base class for all classes containing event data
 * 
 * @author Marcel Liebgott <marcel@mliebgott.de>
 * @package Lecram
 * @subpackage event
 * @since 1.0.0
 */
class Event{
	/**
	 * name of the event#
	 * 
	 * @var string
	 */
	private $name;
	
	/**
	 * event parameter
	 * 
	 * @var Listable
	 */
	private $parameter;
	
	/**
	 * flag which tell us if the event is canceled
	 * 
	 * @var bool
	 */
	private $isCanceled = false;
	
	/**
	 * create a new event with event name and parameters
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param string $name
	 * @param Listable $parameter
	 */
	public function __construct(string $name, Listable $parameter){
		$this->name = $name;
		$this->parameter = $parameter;
	}
	
	/**
	 * get the name of this event
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return string
	 */
	public function getName() : string{
		return $this->name;
	}
	
	/**
	 * set the name of this event
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param string $name
	 */
	public function setName(string $name) : void{
		$this->name = $name;
	}
	
	/**
	 * return event parameter
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return Listable
	 */
	public function getParameters() : Listable{
		return $this->parameter;
	}
	
	/**
	 * get a event parameter by key
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param string $key
	 * @throws InvalidArgumentException
	 * @return mixed
	 */
	public function getParameter(string $key){
		if($this->parameter->exists($key)){
			return $this->parameter->get($key);
		}
		
		throw new \InvalidArgumentException('Key "' . $key . '" not found.');
	}
	
	/**
	 * add a parameter to this event
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param string $key
	 * @param mixed $value
	 */
	public function addParameter(string $key, $value) : void{
		$this->parameter->add(array($key => $value));
	}
	
	/**
	 * return if the event is canceled
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return bool
	 */
	public function isCanceled() : bool{
		return $this->isCanceled;
	}
	
	/**
	 * cancel the current event
	 * 
	 * @access public
	 * @since 1.0.0
	 */
	public function cancel() : void{
		$this->isCanceled = true;
	}
}
?>