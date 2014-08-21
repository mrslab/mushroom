<?php

/**
 * Mushroom
 * 
 * An open source php application framework for PHP 5.3.0 or newer
 *
 * @author    mengfk <Mushroom Dev Team>
 * @copyright Copyright (C) 2014 http://mushroom.dreamans.com All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0.txt
 * @link      http://mushroom.dreamans.com
 */

namespace mushroom\component\mysql;

use \mushroom\core\Core as Core,
    \mushroom\core\Exception as Exception;

class Command extends Core {

    protected $connect = null;

    protected $statement = null;

    protected $sql = '';

    public function __construct(Connect $connect, \PDOStatement $statement, $sql = '') {
        $this->connect = $connect;
        $this->statement = $statement;
        $this->sql = $sql;
    }

    public function execute($param = array()) {
        $this->statement->closeCursor();
        try {
            try {
                if (!empty($param)) {
                    $this->statement->execute($param);
                } else {
                    $this->statement->execute();
                }
                if ( '00000' != $this->getErrorCode()) {
                    $info = $this->getErrorInfo();
                    throw new Exception('Mysql execute error: SQLSTATE['.$info[0].'] ['.$info[1].'] '.$info[2].', Execute SQL: \''.$this->sql.'\'');
                }
            } catch ( \PDOException $e) {
                throw new Exception( $e->getMessage() );
            }
        } catch (\Exception $e) {
            $e->getExceptionMessage();
        }
        return $this;
    }

    public function fetch($style = \PDO::FETCH_ASSOC, $cursor = \PDO::FETCH_ORI_NEXT, $offset = 0) {
        $data = $this->statement->fetch($style, $cursor, $offset);
        $this->closeCursor();
        return $data;
    }

    public function fetchAll($style = \PDO::FETCH_ASSOC) {
        $data = $this->statement->fetchAll($style);
        $this->closeCursor();
        return $data;
    }

    public function fetchColumn($cnum = 0) {
        $data = $this->statement->fetchColumn($cnum);
        $this->closeCursor();
        return $data;
    }

    public function rowCount() {
        $data = $this->statement->rowCount();
        $this->closeCursor();
        return $data;
    }

    public function closeCursor() {
        return $this->statement->closeCursor();
    }

    public function bindValues($datas = array()) {
        if (is_array($datas)) {
            foreach($datas as $field => $value) {
                $this->bindValue($field, $value);
            }
        }
        return $this;
    }

    public function bindValue($field, $value, $type = null) {
        if ($type === null) {
            $type = $this->getPdoType($value);
        }
        $this->statement->bindValue($field, $value, $type);
        return $this;
    }

    public function bindParams($datas) {
        if (is_array($datas)) {
            foreach($datas as $val) {
                $field = isset($val[0]) ? $val[0]: '';
                $value = isset($val[1]) ? $val[1]: '';
                $type = isset($val[2]) ? $val[2]: null;
                $length = isset($val[3]) ? $val[3]: null;
                $driverOpts = isset($val[4]) ? $val[4]: null;
                if (empty($field)) {
                    continue;
                }
                $this->bindParam($field, $value, $type, $length, $driverOpts);
            }
        }
        return $this;
    }

    public function bindParam($field, $value, $type = null, $length = null, $driverOpts = null) {
        if ($type === null) {
            $this->statement->bindParam($field, $value, $this->getPdoType($value));
        } elseif ($length === null) {
            $this->statement->bindParam($field, $value, $type);
        } elseif ($driverOpts === null) {
            $this->statement->bindParam($field, $value, $type, $length);
        } else {
            $this->statement->bindParam($field, $value, $type, $length, $driverOpts);
        }
        return $this;
    }

    public function count() {
        return $this->statement->columnCount();
    }

    public function getErrorCode() {
        return $this->statement->errorCode();
    }

    public function getErrorInfo() {
        return $this->statement->errorInfo();
    }

    private function getPdoType($value) {
        if (is_bool($value)) {
            return \PDO::PARAM_BOOL;
        }
        if (is_numeric($value)) {
            return \PDO::PARAM_INT;
        }
        if (is_null($value)) {
            return \PDO::PARAM_NULL;
        }
        return \PDO::PARAM_STR;
    }
}
