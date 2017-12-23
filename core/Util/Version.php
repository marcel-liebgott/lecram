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

class Version{
    /**
     * the major part of this version
     *
     * @access private
     * @var int
     */
    private $major = 0;

    /**
     * the minor part of this version
     *
     * @access private
     * @var int
     */
    private $minor = 0;

    /**
     * the patch part of this version
     *
     * @access private
     * @var int
     */
    private $patch = 0;

    public function __construct() {
    }

    /**
     * @return int
     */
    public function getMajor(): int {
        return $this->major;
    }

    /**
     * @param int $major
     */
    public function setMajor(int $major): void {
        $this->major = $major;
    }

    /**
     * @return int
     */
    public function getMinor(): int {
        return $this->minor;
    }

    /**
     * @param int $minor
     */
    public function setMinor(int $minor): void {
        $this->minor = $minor;
    }

    /**
     * @return int
     */
    public function getPatch(): int {
        return $this->patch;
    }

    /**
     * @param int $patch
     */
    public function setPatch(int $patch): void {
        $this->patch = $patch;
    }

    /**
     * return the current version as id
     *
     * @access public
     * @since 1.0.0
     * @return int
     */
    public function getVersionId() : int{
        return $this->major . $this->minor . $this->patch;
    }
}