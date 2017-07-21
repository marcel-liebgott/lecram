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

namespace Lecram;

use Lecram\Autoload;
use Lecram\Application;

require_once 'core/Autoload.php';
require_once 'core/Application.php';

try{
	$autoload = Autoload::getInstance();
	
	$application = new Application();
	$application->setAutoloader($autoload);
	$application->run();
}catch(Exception $e){
	echo 'Message: <span style="color: red; font-weight: bold;">' . $e->getMessage() . '</span><br>';
	echo 'File: ' . $e->getFile() . '<br>';
	echo 'Line: ' . $e->getLine() . '<br>';
	echo 'Code: ' . $e->getCode() . '<br>';
	echo 'Caused by: ';
	var_dump($e->getTrace());
}
?>