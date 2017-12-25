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

namespace Lecram\Server\Requirements;

use Lecram\Util\Version;

/**
* define all server requirements
*
* @author Marcel Liebgott <marcel@mliebgott.de>
* @package Lecram
* @subpackage Server\Requirements
* @since 1.0.0
*/
interface ServerRequirement{
    /**
     * return the current version which is currently available on this webserver
     *
     * @access public
     * @since 1.0.0
     * @return Version
     */
    public function getAvailableVersion() : Version;

    /**
     * set the current available version on this server
     *
     * @access public
     * @since 1.0.0
     * @param Version $version
     *              the current available version
     */
    public function setAvailableVersion(Version $version) : void;
}
?>