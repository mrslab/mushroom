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

error_reporting(7);

define('MR_ROOT_PATH', dirname(dirname(__FILE__)));
require MR_ROOT_PATH . '/boot/Constant.php';
require MR_ROOT_PATH . '/boot/InitDetect.php';
require MR_ROOT_PATH . '/boot/Autoloader.php';

\mushroom\boot\InitDetect::checkAllEnv();
\mushroom\boot\Autoloader::getInstance()->register();

register_shutdown_function(array('\mushroom\core\Error', 'kerShutdown'));
set_error_handler(array('\mushroom\core\Error', 'kerError'));
set_exception_handler(array('\mushroom\core\Exception', 'kerException'));

\mushroom\core\Init::bootstrap(require MR_CONF_FILE)->run();
