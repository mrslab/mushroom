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

return array(

    'base'  => array(
        'charset'    => 'utf-8',
        'timezone'   => 8,
        'controller' => 'index',
        'method'     => 'index',
        'theme'      => 'default',
        'mode'       => MR_MODE_QUERY, //MR_MODE_REGEXP || MR_MODE_SEGMENT
    ),

    'cookie' => array(
        'path'     => '/',
        'domain'   => null,
        'secure'   => null,
        'httponly' => false,
    ),

    'session' => array(
        'driver'       => 'File',
    ),

    'comp' => array(
        /*
         this is component config
         */
    ),

    'hook' => array(
        /*
         this is hook config
         */
    ),

    'param' => array(
        /*
         this is user defined config
         */
    ),
    'route' => array(
        /*
         if $this['base']['mode'] == MR_MODE_SEGMENT this config control route dispense
         */
    ),
    'template' => array(
        'driver' => 'smarty',
        'config' => array(
            /*
             this is smarty config, like this:
             */
            /*
            'cache_dir' => '/tmp/',
            'compile_dir' => '/tmp/tpl_c',
            'template_dir' => '/tmp/tpl',
             */
        ),
    ),
);
