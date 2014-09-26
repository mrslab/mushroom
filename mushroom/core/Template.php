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

class Template extends Core {

    private $config = array();

    public function __construct() {
        $this->config = Core::app()->config->template;
        $this->regTemplate();
    }

    private function regTemplate() {
        Core::app()->template = new Core;
        if ($this->checkTemplate()) {
            Core::app()->template = Component::register($this->config['driver'], isset($this->config['config']) ? $this->config['config']: array());
        }
    }

    private function checkTemplate() {
        return isset($this->config['driver']);
    }
}
