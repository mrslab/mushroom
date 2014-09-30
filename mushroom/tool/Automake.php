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

namespace mushroom\tool;

use \mushroom\core\Core as Core;

class Automake extends Core {

    public function init() {
        if (false === $this->checkMakeAppPath()) {
            echo "[error] Application directory has been generated, if you want to regenerate, please delete make.lock under runtime path\n\n";
            $this->end();
        }
        if (false === $this->checkAppPathWritable()) {
            echo "\n[error] Application directory can not be written\n\n";
            $this->end();
        }
        echo "begin ...\n";
        $this->makeAppPaths();
        echo "make application paths [succee]\n";
        $this->makeDefaultConfig();
        echo "make default config [success]\n";
        $this->makeAppLockFile();
        echo "make lock file [success]\n";
        echo "finish ...\n";
    }

    private function checkMakeAppPath() {
        if (is_file(MR_RUNTIME_PATH.'/make.lock')) {
            return false;
        }
        return true;
    }

    private function checkAppPathWritable() {
        if (!is_writable(MR_APP_PATH)) {
            return false;
        }
        return true;
    }

    private function makeAppPaths() {
        $paths = array(
            MR_APP_PATH,
            MR_CONF_PATH,
            MR_RUNTIME_PATH,
            MR_CONTROLLER_PATH,
            MR_COMMAND_PATH,
            MR_MODEL_PATH,
            MR_VIEW_PATH,
            MR_FILTER_PATH,
        );
        foreach($paths as $dir) {
            if (!is_dir($dir)) {
                @mkdir($dir, 0755, true);
            }
        }
    }

    private function makeDefaultConfig() {
        if (!is_file(MR_CONF_PATH.'/config.php')) {
            copy(MR_ROOT_PATH.'/boot/Config.php', MR_CONF_PATH . '/config.php');
        }
    }

    private function makeAppLockFile() {
        $lock = "if you want to rebuild the application directory, please delete this file";
        file_put_contents(MR_RUNTIME_PATH.'/make.lock', $lock);
    }
}
