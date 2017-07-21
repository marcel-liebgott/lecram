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

use Lecram\Singleton;
use Lecram\Util\Listable;

/**
 * organise all application events
 * 
 * @author Marcel Liebgott <marcel@mliebgott.de>
 * @package Lecram
 * @subpackage event
 * @since 1.0.0
 */
class EventDispatcher extends Singleton{
	/**
	 * list of all events
	 * 
	 * @var Listable
	 */
	private $events;
	
	/**
	 * return a singleton EventDispatcher instance
	 * 
	 * @since 1.0.0
	 * @return EventDispatcher
	 */
	public static function getInstance() : EventDispatcher{
		return parent::_getInstance(get_class());
	}
	
	/**
	 * constructor
	 * 
	 * @access public
	 * @since 1.0.0
	 */
	protected function __construct() {
		$this->events = new Listable();
	}
	
	/**
	 * add a new event
	 * 
	 * @since 1.0.0
	 * @param string $name
	 * 				the name of the event
	 * @param Event $event
	 * 				the event
	 */
	public function addListener(string $name, Event $event) : void{
		$eventList = new Listable();
		
		if($this->events->exists($name)){
			$events = $this->events->get($name);
			$eventList->add($events);
		}
		
		$eventList->add($event);
		
		$this->events->add(array($name => $eventList));
	}
	
	/**
	 * return a list with event listeners
	 * 
	 * @param string $name
	 * @throws InvalidArgumentException
	 * @return Listable
	 */
	public function getListeners(string $name) : Listable{
		if($this->events->exists($name)){
			return $this->events->get($name);
		}
			
		throw new \InvalidArgumentException('Event "' . $name . " no found.");
	}
	
	/**
	 * dispatch all handlers for this event
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param string $eventName
	 * 				the name of the event
	 * @param Event $event
	 * 				the event
	 * @return Event
	 */
	public function dispatch(string $eventName, Event $event) : Event{
		if($event === null){
			$event = new Event();
		}
		if($this->events->exists($eventName)){
			foreach($this->events->get($eventName) as $handlers){
				call_user_func($handlers, $event, $eventName, $this);
			}
		}
		
		return $event;
	}
	
	/**
	 * return the number of handlers for this event
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param string $name
	 * @return int
	 */
	public function size(string $name) : int{
		$events = $this->getListeners($name);
		return $events->count();
	}
}
?>