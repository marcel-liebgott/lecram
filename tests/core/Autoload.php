<?php
declare(strict_types=1);

namespace Lecram\test;

use PHPUnit\Framework\TestCase;
use Lecram\Autoload;

class AutoloadTest extends TestCase{
	private $autoload;
	
	public function setUp() : void{
		$this->autoload = Autoload::getInstance();
	}
	
	public function testPrefix() : void{
		$this->autoload->setPrefix('lecram');
		$this->assertEquals('lecram', $this->autoload::getPrefix());
	}
}
?>