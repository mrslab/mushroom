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

namespace mushroom\boot;

class Autoloader {

    private static $stdObj = NULL;

    private $importFiles = array();

    public static function getInstance() {
        if(!self::$stdObj) {
            self::$stdObj = new self;
        }
        return self::$stdObj;
    }

    public function transNameSpaceToFilePath($ns) {
        $file = $this->aliasName($ns);
        return $this->aliasPath($file);
    }

    public function loadClass($file) {
        $truePath = $this->transNameSpaceToFilePath($file);
        $this->importFile($truePath);
    }

    public function register() {
        spl_autoload_register(array($this, 'loadClass'));
    }

    public function autoLoadedFile() {
        return $this->importFiles;
    }

    private function importFile($file) {
        if(!in_array($file, $this->importFiles)) {
            if(is_file($file)) {
                require $file;
                $this->importFiles[] = $file;
            }
        }
    }

    private function aliasPath($file) {
        $fileArrs = explode('\\', $file);
        $head = !empty($fileArrs) ? array_shift($fileArrs): '';
        static $alias = array(
            'mushroom'    => MR_ROOT_PATH,
            'controller'  => MR_CONTROLLER_PATH,
            'model'       => MR_MODEL_PATH,
            'command'     => MR_COMMAND_PATH,
            'filter'      => MR_FILTER_PATH
        );
        $path = isset($alias[$head]) ? $alias[$head] : MR_APP_PATH . MR_RT_DS . $head;
        array_unshift($fileArrs, $path);
        $realPath = implode(MR_RT_DS, $fileArrs) . '.php';
        return $realPath;
    }

    private function aliasName($file) {
        $fileArrs = explode('\\', $file);
        $head = !empty($fileArrs) ? array_shift($fileArrs): '';
        static $alias = array(
            'mr' => 'mushroom\\core\\Alias',
        );
        return isset($alias[$head]) ? $alias[$head]: $file;
    }

    private function __construct() {}

    private function __clone() {}
}
