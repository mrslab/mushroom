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

use \mushroom\core\Exception as Exception;

class File {

    public static function mkdir($path) {
        try {
            $dir = $path;
            if(!is_dir($dir)) {
                if(!mkdir($dir, 0755, true)) {
                    throw new Exception('"{$dir}" directory create failed');
                }
            }
            return true;
        } catch (Exception $e) {
            $e->getExceptionMessage();
        }
    }

    public static function read($file) {
        if (is_file($file)) {
            $data = file_get_contents($file);
        } else {
            $data = false;
        }
        return $data;
    }

    public static function write($file, $data, $file_append = false) {
        try {
            if (true === self::mkdir(dirname($file))) {
                if (false === file_put_contents($file, $data, $file_append ? FILE_APPEND : 0)) {
                    throw new Exception('file "'.$file.'" write failed');
                }
            }
            return true;
        } catch (Exception $e) {
            $e->getExceptionMessage();
        }
    }

    public static function delete($file) {
        try {
            if (!is_file($file)) {
                return false;
            }
            return unlink($file);
        } catch (Exception $e) {
            $e->getExceptionMessage();
        }
    }
}
