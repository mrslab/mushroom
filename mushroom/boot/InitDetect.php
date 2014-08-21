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

namespace mushroom\boot;

class InitDetect {

    public static function checkAllEnv() {
        self::checkErrLogDir();
        self::checkPHPversioin();
        self::checkAppConfigFile();
        self::setEnvDefValue();
    }

    private static function setEnvDefValue() {
        if(version_compare(PHP_VERSION,'5.4.0','<')) {
            ini_set('magic_quotes_runtime', 0);
        }   
    }
    
    private static function checkAppConfigFile() {
        if (!is_file(MR_CONF_FILE)) {
            self::outputErrorString('failed to open config file"'.MR_CONF_PATH.'/config.php"');
        }
    }

    private static function checkErrLogDir() {
        $path = MR_RUNTIME_PATH;
        if (!is_dir($path)) {
            if (!mkdir($path, 0755, true)) {
                self::outputErrorString('failed to create directory "'.$path.'"');
            }
        } elseif (!is_writable($path)) {
            self::outputErrorString('directory "'.$path.'" is not writable');
        }
    }

    private static function checkPHPversioin() {
        if (version_compare(PHP_VERSION,'5.3.0','<')) {
            self::outputErrorString('need PHP 5.3.0 or newer');
        }
    }

    private static function outputErrorString($str) {
        header('HTTP/1.1 500 Internal Server Error');
        echo $str;
        exit(1);
    }
}
