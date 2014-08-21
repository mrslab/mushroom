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

namespace mushroom\core;

class Common extends Core {

    public static function import($file) {
        static $fileList = array();
        $file = str_replace("/", MR_RT_DS, $file);
        if(!in_array($file, $fileList)) {
            if(is_file($file)) {
                require $file;
                $fileList[] = $file;
                return true;
            }
            return false;
        }
        return true;
    }
}
