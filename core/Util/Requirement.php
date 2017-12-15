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

namespace Lecram\Server;

/**
 * Requirement definition
 *
 * @author Marcel Liebgott <marcel@mliebgott.de>
 * @package Lecram
 * @subpackage Util
 * @since 1.0.0
 */
class Requirement{
    /**
     * internal name of this requirement
     *
     * @access private
     * @var String
     */
	private $name;

    /**
     * the version which we needed
     *
     * @access private
     * @var integer
     */
	private $version;

    /**
     * which version relation does we need
     *
     * @access private
     * @var WebserverRequirement
     */
	private $operation;

    /**
     * set the name of this requirement
     *
     * @access public
     * @since 1.0.0
     * @return String
     */
    public function getName() : string{
        return $this->name;
    }

    /**
     * get the internal name of this requirement
     *
     * @access public
     * @since 1.0.0
     * @param String $name
     *              the internal name of the requirement
     */
    public function setName($name){
        $this->name = $name;
    }

    /**
     * the version
     *
     * @access public
     * @since 1.0.0
     * @return int
     */
    public function getVersion(): int{
        return $this->version;
    }

    /**
     * set the version which we need
     *
     * @access public
     * @since 1.0.0
     * @param int $version
     *              the version which we needed
     */
    public function setVersion(int $version): void{
        $this->version = $version;
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
     * @param WebserverRequirement $operation
     *              which relation does have this requirement
     */
    public function setOperation(WebserverRequirement $operation): void{
        $this->operation = $operation;
    }
}
?>