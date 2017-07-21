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
namespace Lecram\Controller;

use Lecram\Http\Request;
use Lecram\Http\Response;
use Lecram\Filter\Filter;

/**
 * Controller should be implemented by classes that depends on a controller
 * 
 * @author Marcel Liebgott <marcel@mliebgott.de>
 * @package Lecram
 * @subpackage http
 * @since 1.0.0
 */
interface Controller{
	/**
	 * add a pre filter for this controller
	 * it run before the controller
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param Filter $filter
	 */
	public function addPreFilter(Filter $filter) : void;
	
	/**
	 * add a post filter for this controller
	 * it run after the controller
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param Filter $filter
	 */
	public function addPostFilter(Filter $filter) : void;
	
	/**
	 * handle requests
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param Request $request
	 * @param Response $response
	 */
	public function handleRequest(Request $request, Response $response) : void;
	
	/**
	 * load the controller model
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param string $name
	 */
	public function loadModal(string $name);
}
?>