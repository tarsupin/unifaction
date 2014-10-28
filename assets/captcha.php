<?php

/**
 * Project:     Securimage: A PHP class for creating and managing form CAPTCHA images<br />
 * File:        securimage_show.php<br />
 *
 * Copyright (c) 2013, Drew Phillips
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 *  - Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer.
 *  - Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * Any modifications to the library should be indicated clearly in the source code
 * to inform users that the changes are not a part of the original software.<br /><br />
 *
 * If you found this script useful, please take a quick moment to rate it.<br />
 * http://www.hotscripts.com/rate/49400.html  Thanks.
 *
 * @link http://www.phpcaptcha.org Securimage PHP CAPTCHA
 * @link http://www.phpcaptcha.org/latest.zip Download Latest Version
 * @link http://www.phpcaptcha.org/Securimage_Docs/ Online Documentation
 * @copyright 2013 Drew Phillips
 * @author Drew Phillips <drew@drew-phillips.com>
  * @version 3.5.1 (June 21, 2013)
 * @package Securimage
 */


// Remove the "//" from the following line for debugging problems
// error_reporting(E_ALL); ini_set('display_errors', 1);

$baseDir = dirname(dirname(dirname(__FILE__))) . '/system/libraries/securimage';

require($baseDir . '/securimage.php');

$img = new Securimage();

/***************************
****** Customizations ******
***************************/
// See securimage.php for additional configurations

// Choose a Font Randomly
$fontList = array(
	array('font' => 'diogenes.ttf', 'charset' => 'abcdefghkmnprstuvwyz2346789'),
	array('font' => 'bombard.ttf', 'charset' => 'abcdefhkmnprtuvwyz234789'),
	array('font' => 'bebas.ttf', 'charset' => 'abcdefghklmnprtuvwyz2346789')
);

$font = $fontList[mt_rand(0, count($fontList) - 1)];

$img->ttf_file        = $baseDir . '/' . $font['font'];
//$img->captcha_type    = Securimage::SI_CAPTCHA_MATHEMATIC; // show a simple math problem instead of text
//$img->case_sensitive  = true;                              // true to use case sensitve codes - not recommended
$img->image_height    = 85;                                // height in pixels of the image
$img->image_width     = ceil($img->image_height * 2.85);   // a good formula for image size based on the height
$img->perturbation    = (mt_rand(86, 96) / 100);           // 1.0 = high distortion, higher numbers = more distortion
$img->image_bg_color  = new Securimage_Color("#3399CC");   // image background color
$img->text_color      = new Securimage_Color("#EAEAEA");   // captcha text color
$img->num_lines       = mt_rand(5, 7);                     // how many lines to draw over the image
$img->line_color      = new Securimage_Color("#3399CC");   // color of lines over the image
$img->code_length	  = mt_rand(6, 7);
$img->charset = $font['charset'];
//$img->image_type      = SI_IMAGE_JPEG;                     // render as a jpeg image
//$img->signature_color = new Securimage_Color(rand(0, 64), rand(64, 128), rand(128, 255));  // random signature color


// Outputs the image and content headers to the browser
// $img->show('/path/to/background_image.jpg');		// Provides a background
$img->show();
