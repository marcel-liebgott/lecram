<?php
declare(strict_types=1);

namespace Lecram\test;

use PHPUnit\Framework\TestCase;

class Version extends TestCase{
    public function testVersion() : void{
        $major = 1;
        $minor = 2;
        $patch = 3;
        $versionId = $major . $minor . $patch;

        $version = new \Lecram\Util\Version();
        $version->setMajor($major);
        $version->setMinor($minor);
        $version->setPatch($patch);

        $this->assertEquals($major, $version->getMajor());
        $this->assertEquals($minor, $version->getMinor());
        $this->assertEquals($patch, $version->getPatch());
        $this->assertEquals($versionId, $version->getVersionId());
    }
}
