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

define('MR_VERSION', '1.0');
define('MR_RELEASE', '20140602');

if (!defined('MR_APP_PATH')) {
    define('MR_APP_PATH', dirname(MR_ROOT_PATH));
}

define('MR_E_ERROR'  , 1);
define('MR_E_WARNING', 2);
define('MR_E_NOTICE' , 4);
define('MR_E_ALL'    , 8);

!defined('MR_CONF_PATH')       && define('MR_CONF_PATH',       MR_APP_PATH . '/config');
!defined('MR_RUNTIME_PATH')    && define('MR_RUNTIME_PATH',    MR_APP_PATH . '/runtime');
!defined('MR_CONTROLLER_PATH') && define('MR_CONTROLLER_PATH', MR_APP_PATH . '/controller');
!defined('MR_MODEL_PATH')      && define('MR_MODEL_PATH',      MR_APP_PATH . '/model');
!defined('MR_VIEW_PATH')       && define('MR_VIEW_PATH',       MR_APP_PATH . '/view');

!defined('MR_DEV_DEBUG') && define('MR_DEV_DEBUG'         , true);

define('MR_RT_TIMESTAMP', time());
define('MR_RT_BMEMORY',   memory_get_usage());
define('MR_RT_DS',        DIRECTORY_SEPARATOR);

list($microtime, $second) = explode(' ', microtime());
define('MR_RT_BTIME', $second + $microtime);

if (!defined('MR_CONF_FILE')) {
    define('MR_CONF_FILE', MR_CONF_PATH.'/config.php');
}
