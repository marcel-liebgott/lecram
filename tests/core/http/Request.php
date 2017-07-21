<?php
declare(strict_types=1);

namespace Lecram\test;

use PHPUnit\Framework\TestCase;
use Lecram\Http\Request;

class RequestTest extends TestCase{	
	public function testCreate() : void{
		$request = Request::create('http://mliebgott.de/test1.php?key1=value1&key2=value2', 'GET');
		$this->assertEquals('mliebgott.de', $request->getHost());
		$this->assertEquals('key1=value1&key2=value2', $request->getQueryString());
		$this->assertEquals(80, $request->getPort());
		$this->assertEquals('http', $request->getScheme());
		$this->assertFalse($request->isSecure());
		
		$request = Request::create('http://mliebgott.de:8000/test2.php?key1=value1&key2=value2', 'GET');
		$this->assertEquals('mliebgott.de', $request->getHost());
		$this->assertEquals('test2.php?key1=value1&key2=value2', $request->getRequestUri());
		$this->assertEquals(8000, $request->getPort());
		$this->assertFalse($request->isSecure());
		
		$request = Request::create('https://mliebgott.de/test3.php?key1=value1&key2=value2', 'GET');
		$this->assertEquals('mliebgott.de', $request->getHost());
		$this->assertEquals('mliebgott.de:443', $request->getHttpHost());
		$this->assertEquals('https://mliebgott.de:443/test3.php?key1=value1&key2=value2', $request->getUri());
		$this->assertEquals('https', $request->getScheme());
		$this->assertTrue($request->isSecure());
		
		$request = Request::create('https://mliebgott.de/test4.php?key1=value1&key2=value2', 'GET');
		$this->assertEquals('mliebgott.de', $request->getHost());
		$this->assertEquals(443, $request->getPort());
		$this->assertEquals('/test4.php', $request->getBaseUrl());
		$this->assertEquals('127.0.0.1', $request->getClientIp());
		$this->assertTrue($request->isSecure());
		
		$request = Request::create('https://marcel:secure@mliebgott.de/test5.php?key1=value1&key2=value2', 'GET');
		$this->assertEquals('mliebgott.de', $request->getHost());
		$this->assertEquals(443, $request->getPort());
		$this->assertEquals('marcel', $request->getUser());
		$this->assertEquals('secure', $request->getPassword());
		$this->assertTrue($request->isSecure());
	}
}
?>