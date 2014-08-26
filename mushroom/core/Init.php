<?php
/**
 * Mushroom
 * 
 * An open source php application framework for PHP 5.3.0 or newer
 *
 * @author    mengfk <Mushroom Dev Team>
 * @copyright Copyright (C) 2014 <MrsLab Team> All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0.txt
 * @link      https://github.com/mrslab/mushroom
 */

namespace mushroom\core;

class Init extends Core {

    public static function bootstrap($config) {
        Core::app();
        Common::load('RegisterConfig')->init($config);
        return new self;
    }

    public function run() {
        self::registerInit();
        self::initGlobal();
        Common::load('Dispense')->run();
    }

    public static function registerInit() {
        Common::load('Output');
        Common::load('GetGpcs');
        Common::load('Request');
        Common::load('Hook');
    }

    public static function initGlobal() {
        if( function_exists('date_default_timezone_set')) {
            $timezone = Core::app()->config->timezone * -1;
            @date_default_timezone_set("Etc/GMT".$timezone);
        }
    }

    public function __destruct() {
        new Debug();
    }
}
