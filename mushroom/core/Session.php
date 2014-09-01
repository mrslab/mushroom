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

class Session extends Core {

    private $config = array();

    public function __construct() {
        $this->config = Core::app()->config->session;
        $this->regSession();
    }

    private function regSession() {
        Core::app()->session = new Core;
        if ($this->checkSession()) {
            Core::app()->session = Component::register('session', $this->config);
        }
    }

    private function checkSession() {
        return !empty($this->config) && !MR_RT_CLI;
    }
}
