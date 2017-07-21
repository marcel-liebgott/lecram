<?php
declare(strict_types=1);

namespace Lecram\test;

use PHPUnit\Framework\TestCase;
use Lecram\Autoload;
use Lecram\Application;

class ApplicationTest extends TestCase{
	public function testAutoloader() : void{
		$autoload = Autoload::getInstance();
		$application = new Application();
		$application->setAutoloader($autoload);
		
		$this->assertInstanceOf(Autoload::class, $application->getAutoloader());
	}
}