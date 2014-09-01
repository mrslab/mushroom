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

class Cookie extends Core {

    private $config = array();

    public function __construct() {
        $this->config = Core::app()->config->cookie;
        $this->regCookie();
    }

    private function regCookie() {
        Core::app()->cookie = new Core;
        if ($this->checkCookie()) {
            Core::app()->cookie = Component::register('cookie', $this->config);
        }
    }

    private function checkCookie() {
        return !MR_RT_CLI;
    }
}
