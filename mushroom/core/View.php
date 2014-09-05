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

class View extends Core {

    private $vars = array();

    public function assign($key, $value) {
        $this->vars[$key] = $value;
    }

    public function display($tpl, $return = false) {
        Hook::listen('mr_view', $tpl);
        $content = $this->buildContent($tpl);
        if ($return === true) {
            return $content;
        }
        echo $content;
    }

    public function render($tpl, $var = array()) {
        extract($var, \EXTR_OVERWRITE);
        $file = $this->getTplFile($tpl);
        return Template::initTpl($file)->template();
    }

    public function buildContent($tpl) {
        extract($this->vars, \EXTR_OVERWRITE);
        $file = $this->getTplFile($tpl);
        include Template::initTpl($file)->template();
        return Output::echoOut();
    }

    public function getTplFile($tpl) {
        try {
            $file = MR_VIEW_PATH.'/' .$tpl.'.php';
            if (!is_file($file)) {
                throw new Exception('template file "'.$file.'" not exists');
            }
            return $file;
        } catch (Exception $e) {
            $e->getExceptionMessage();
        }
    }
}
