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

class Init extends Core {

    public static function bootstrap($config) {
        self::createCore();
        self::registerConfig($config);
        return new self;
    }

    public function run() {
        self::registerInit();
        self::initGlobal();
        self::dispense()->run();
    }

    public static function registerInit() {
        self::registerOutput();
        self::registerComp();
        self::registerGlobal();
        self::registerRequest();
        self::registerHook();
    }

    public static function createCore() {
        return Core::app();
    }

    public static function registerConfig($config)
    {
        new RegisterConfig($config);
    }

    public static function registerComp() {
        new Component;
    }

    public static function registerOutput() {
        new Output;
    }

    public static function registerGlobal() {
        new GetGpcs;
    }

    public static function registerRequest() {
        new Request;
    }

    public static function registerHook() {
        new Hook;   
    }

    public static function dispense() {
        return new Dispense;
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
