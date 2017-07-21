<?php
declare(strict_types=1);

namespace Lecram\test;

use PHPUnit\Framework\TestCase;
use Lecram\Util\Listable;

class ListableTest extends TestCase{
	private $data = array("one" => "data1", "two" => "data2", "three" => "data3");
	private $listable;
	
	public function setUp(){
		$this->listable = new Listable($this->data);
	}
	
	public function testGetKey() : void{
		$this->assertEquals("data2", $this->listable->get("two"));
	}
	
	public function testAddKey() : void{
		$requested = new Listable(array_merge($this->data, array("four" => "data4")));
		$modified = $this->listable->add(array("four" => "data4"));
		
		$this->assertEquals($requested, $modified);
	}
	
	public function testCount() : void{
		$this->assertEquals(3, $this->listable->count());
	}
	
	public function testIterator() : void{
		$iter = $this->listable->getIterator();
		$this->assertInstanceOf(\ArrayIterator::class, $iter);
	}
	
	public function testRemove() : void{
		$this->listable->remove("two");
		$this->assertEquals(2, $this->listable->count());
	}
}
?>