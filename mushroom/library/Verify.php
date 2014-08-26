<?php

/**
 * Mushroom
 * 
 * An open source php application framework for PHP 5.3.0 or newer
 *
 * @author    mengfk <Mushroom Dev Team>
 * @copyright Copyright (C) 2014 http://mushroom.dreamans.com All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0.txt
 * @link      http://mushroom.dreamans.com
 */

namespace mushroom\library;

class Verify {

    public static function isMobile($mobile) {
        return preg_match("/^1[3458][0-9]{9}$/", $mobile) ? true: false;
    }

    public static function isEmail($email) {
        return preg_match("/^[0-9a-zA-Z]+(?:[\_\-][a-z0-9\-]+)*@[0-9a-zA-Z]+(?:[-.][a-zA-Z0-9]+)*\.[a-zA-Z]+$/i", $email) ? true: false;
    }

    public static function isNumber($number) {
        return preg_match("/^[0-9]+$/i", $number) ? true: false;
    }

    public static function isInteger($number) {
        return preg_match("/^(?:[-]?[1-9][0-9]*|0)$/i", $number) ? true: false;
    
    }

    public static function isHex($number) {
        return preg_match("/^0x[0-9a-fA-F]+$/i", $number) ? true : false; 
    
    }

    public static function isAlpha($letter) {
        return preg_match("/^[a-zA-Z]+$/", $letter) ? true: false;
    }

    public static function isAplhaNumber($string) {
        return preg_match("/^[a-zA-Z0-9]+$/", $string) ? true: false;
    }
}
