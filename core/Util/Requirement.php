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

namespace Lecram\Util;

use Lecram\Server\Requirements\ServerRequirement;
use Lecram\Server\WebserverRequirement;

/**
 * Requirement definition
 *
 * @author Marcel Liebgott <marcel@mliebgott.de>
 * @package Lecram
 * @subpackage Util
 * @since 1.0.0
 */
class Requirement {
    /**
     * the version which we needed
     *
     * @access private
     * @var Version
     */
	private $requestedVersion;

    /**
     * the version as int identifier
     *
     * @access private
     * @var int
     */
	private $versionId;

    /**
     * which version relation does we need
     *
     * @access private
     * @var WebserverRequirement
     */
	private $operation;

    /**
     * the server requirement
     *
     * @access private
     * @var ServerRequirement
     */
	private $serverRequirement;

    /**
     * Requirement constructor.
     */
    public function __construct() {
    }

    /**
     * the version
     *
     * @access public
     * @since 1.0.0
     * @return Version
     */
    public function getRequestedVersion(): Version{
        return $this->requestedVersion;
    }

    /**
     * set the version which we need
     *
     * @access public
     * @since 1.0.0
     * @param Version $version
     *              the version which we needed
     */
    public function setRequestedVersion(Version $version): void{
        $this->requestedVersion = $version;
        $this->versionId = $version->getMajor() . $version->getMinor() . $version->getPatch();
    }

    /**
     * return the version as int
     *
     * @access public
     * @since 1.0.0
     * @return int
     */
    public function getVersionId() : int{
        return $this->versionId;
    }

    /**
     * get the version relation
     *
     * @access public
     * @since 1.0.0
     * @return WebserverRequirement
     */
    public function getOperation(): WebserverRequirement{
        return $this->operation;
    }

    /**
     * set the version relation
     *
     * @access public
     * @since 1.0.0
     * @param string $operation
     *              which relation does have this requirement
     */
    public function setOperation(string $operation): void{
        $this->operation = $operation;
    }

    /**
     *
     * return the current responsible server requirement
     *
     * @access public
     * @since 1.0.0
     * @return ServerRequirement
     */
    public function getServerRequirement(): ServerRequirement {
        return $this->serverRequirement;
    }

    /**
     * set the current responsible server requirement
     *
     * @access public
     * @since 1.0.0
     * @param ServerRequirement $serverRequirement
     *              the server requirement object
     */
    public function setServerRequirement(ServerRequirement $serverRequirement): void {
        $this->serverRequirement = $serverRequirement;
    }
}
?>