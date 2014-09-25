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

class Model extends Core {

    private static $models = array();

    public static function model($model, $new = false) {
        $modelClass = self::modelClassName($model);
        if ($new == true) {
            return new $modelClass;
        }
        if (!isset(self::$models[$model])) {
            self::$models[$model] = new $modelClass;
            self::$models[$model]->initAttribute();
        }
        return self::$models[$model];
    }

    private static function modelClassName($model) {
        $modelName = '\\model\\'.str_replace('.', '\\', $model);
        return $modelName;
    }
}
