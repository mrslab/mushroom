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

namespace mushroom\component\mysql;

use \mushroom\core\Exception as Exception;

class Translation {

    private $connect = null;

    private $transing = false;

    public function __construct(Connect $connect) {
        $this->connect = $connect;
        $this->transing = true;
    }

    public function getTransing() {
        return $this->transing;
    }

    public function commit() {
        try {
            if ($this->transing == true) {
                $this->connect->getPdoInstance()->commit();
                $this->transing = false;
            } else {
                throw new Exception('MysqlTranslation error: translation is inactive and cannot perform commit or roll back operations');
            }
        } catch (Exception $e) {
            $e->getExceptionMessage();
        }
    }

    public function rollback() {
        try {
            if ($this->transing == true) {
                $this->connect->getPdoInstance()->rollBack();
                $this->transing = false;
            } else {
                throw new Exception('MysqlTranslation error: translation is inactive and cannot perform commit or roll back operations');
            }
        } catch (Exception $e) {
            $e->getExceptionMessage();
        }
    }
}
