<?php
declare(strict_types=1);

namespace Lecram\test;

use PHPUnit\Framework\TestCase;
use Lecram\Http\Response;
use Lecram\Util\Listable;

class ResponseTest extends TestCase{
	public function testCreate() : void{
		$headerData = array('key1' => 'value1');
		$header = new Listable($headerData);
		$response = Response::create('content', 201, $header);
		
		$this->assertEquals('content', $response->getContent());
		$this->assertEquals(201, $response->getStatusCode());
		$this->assertEquals('value1', $response->getHeaderInformation('key1'));
		
		$response->addHeaderInformation('key2', 'value2');
		$this->assertEquals('value2', $response->getHeaderInformation('key2'));
		
		$response->setStatusCode(300);
		$response->setContent('this is a new content');
		$this->assertEquals(300, $response->getStatusCode());
		$this->assertEquals('this is a new content', $response->getContent());
		
		$response->addContent(' string');
		$this->assertEquals('this is a new content string', $response->getContent());
		
		$headerData = array('key2' => 'value2');
		$responseArray = $response->getHeader()->toArray();
		$this->assertEquals(sort($headerData), sort($responseArray));
		
		$response->setAge(10);
		$this->assertEquals(10, $response->getAge());
		
		$response->setEtag('abcdef');
		$this->assertEquals('abcdef', $response->getEtag(false));
		$this->assertEquals('W/abcdef', $response->getEtag(true));
		
		$response->setWwwAuthentification('basic');
		$this->assertEquals('basic', $response->getWwwAuthentification());
		
		try{
			
		}catch(\InvalidArgumentException $e){
			$this->success();
		}
	}
	
	public function testAuthentification() : void{
		$headerData = array('key1' => 'value1');
		$header = new Listable($headerData);
		$response = Response::create('content', 201, $header);
		
		try{
			$response->setWwwAuthentification('lecram');
			$this->fail();
		}catch(\InvalidArgumentException $e){

		}
	}
}
?>