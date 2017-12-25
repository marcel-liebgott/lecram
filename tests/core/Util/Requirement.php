<?php
declare(strict_types=1);

namespace Lecram\test;

use Lecram\Server\Requirements\Php;
use Lecram\Server\WebserverRequirement;
use Lecram\Util\Requirement;
use PHPUnit\Framework\TestCase;

class RequirementTest extends TestCase {
    public function testRequirement() : void{
        $version = new \Lecram\Util\Version();
        $version->setMajor(1);
        $version->setMinor(2);
        $version->setPatch(3);

        $requestVersion = new \Lecram\Util\Version();
        $requestVersion->setMajor(1);
        $requestVersion->setMinor(1);
        $requestVersion->setPatch(1);
        $operation = WebserverRequirement::EQUAL;
        $php = new Php();
        $php->setAvailableVersion($version);
        $requirement = new Requirement();
        $requirement->setOperation($operation);
        $requirement->setServerRequirement($php);
        $requirement->setRequestedVersion($version);
        $this->assertGreaterThan($requestVersion->getVersionId(), $version->getVersionId());
        $this->assertEquals($php, $requirement->getServerRequirement());
    }
}