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

const MR_VERSION = '1.0';
const MR_RELEASE = '20140602';

const MR_E_ERROR   = 1;
const MR_E_WARNING = 2;
const MR_E_NOTICE  = 4;
const MR_E_ALL     = 8;

const MR_MODE_QUERY   = 1;
const MR_MODE_SEGMENT = 2;
const MR_MODE_CLI     = 3;
const MR_MODE_REGEXP  = 4;

if (!defined('MR_APP_PATH')) {
    define('MR_APP_PATH', dirname(MR_ROOT_PATH));
}

!defined('MR_CONF_PATH')       && define('MR_CONF_PATH',       MR_APP_PATH . '/config');
!defined('MR_RUNTIME_PATH')    && define('MR_RUNTIME_PATH',    MR_APP_PATH . '/runtime');
!defined('MR_CONTROLLER_PATH') && define('MR_CONTROLLER_PATH', MR_APP_PATH . '/controller');
!defined('MR_COMMAND_PATH')    && define('MR_COMMAND_PATH',    MR_APP_PATH . '/command');
!defined('MR_MODEL_PATH')      && define('MR_MODEL_PATH',      MR_APP_PATH . '/model');
!defined('MR_VIEW_PATH')       && define('MR_VIEW_PATH',       MR_APP_PATH . '/view');
!defined('MR_FILTER_PATH')     && define('MR_FILTER_PATH',     MR_APP_PATH . '/filter');

!defined('MR_DEV_DEBUG') && define('MR_DEV_DEBUG'         , true);

define('MR_RT_TIMESTAMP', time());
define('MR_RT_BMEMORY',   memory_get_usage());
define('MR_RT_DS',        DIRECTORY_SEPARATOR);
define('MR_RT_CLI',       PHP_SAPI == 'cli' ? true : false);

list($microtime, $second) = explode(' ', microtime());
define('MR_RT_BTIME', $second + $microtime);

if (!defined('MR_CONF_FILE')) {
    if (is_file(MR_CONF_PATH.'/config.php')) {
        define('MR_CONF_FILE', MR_CONF_PATH.'/config.php');
    } else {
        define('MR_CONF_FILE', MR_ROOT_PATH.'/boot/Config.php');
    }
}
