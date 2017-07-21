<?php
namespace Lecram\test;

use PHPUnit\Framework\TestCase;
use Lecram\Event\Event;
use Lecram\Util\Listable;

class EventTest extends TestCase{
	private $event;
	private $parameter;
	
	public function setUp() : void{
		$this->parameter= new Listable(array('key1' => 'value1', 'key2' => 'value2'));
		$this->event = new Event('event_name', $this->parameter);
	}
	
	public function testEqualEvents() : void{
		$this->assertEquals($this->event, new Event('event_name', $this->parameter));
		$this->assertFalse($this->event->isCanceled());
	}
	
	public function testGetName() : void{
		$this->event->setName('custom_event_name');
		$this->assertEquals('custom_event_name', $this->event->getName());
		$this->event->cancel();
		$this->assertTrue($this->event->isCanceled());
	}
	
	public function testGetParameters() : void{
		$this->assertEquals($this->parameter, $this->event->getParameters());
	}
	
	public function testGetGetParameter() : void{
		$this->assertEquals('value2', $this->event->getParameter('key2'));
	}
	
	public function testAddParameter() : void{
		$modified = $this->parameter->add(array('key3' => 'value3'));
		$this->event->addParameter('key3', 'value3');
		$this->assertEquals($modified, $this->event->getParameters());
	}
	
	public function testInvalidArgumentException() : void{
		try{
			$this->event->getParameter('key5');
			$this->fail();
		}catch(\InvalidArgumentException $e){
			$this->assertEquals('Key "key5" not found.', $e->getMessage());
		}
	}
}
?>