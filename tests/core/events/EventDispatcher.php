<?php
declare(strict_types=1);

namespace Lecram\test;

use PHPUnit\Framework\TestCase;
use Lecram\Event\EventDispatcher;
use Lecram\Event\Event;
use Lecram\Util\Listable;

class EventDispatcherTest extends TestCase{
	private $dispatcher;
	
	public function setUp() : void{
		$this->dispatcher = EventDispatcher::getInstance();
	}
	
	public function testAddEvent() : void{
		$parameter = new Listable(array('key1' => 'value2'));
		$event1 = new Event('event_name_1', $parameter);
		$event2 = new Event('event_name_2', $parameter);
		$this->dispatcher->addListener('event_name', $event1);
		$this->dispatcher->addListener('event_name', $event2);
		
		$this->assertEquals(2, $this->dispatcher->size('event_name'));
	}
	
	public function testGetListener() : void{
		try{
			$this->dispatcher->getListeners('other_event');
			$this->fail();
		}catch(\InvalidArgumentException $e){
			
		}
	}
}
?>