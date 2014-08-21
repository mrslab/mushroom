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

class Connect extends Core {

    private $pdo = null;

    private $dsn = '';

    private $user = '';

    private $pass = '';

    public $tablepr = '';

    private $timeout = 3;

    private $translation = null;

    private $command = null;

    public function __construct($dsn, $user, $pass, $time = 3, $tablepr = '') {
        $this->dsn = $dsn;
        $this->user = $user;
        $this->pass = $pass;
        $this->timeout = $time;
        $this->tablepr = $tablepr;
    }

    public function connect() {
        if ($this->pdo == null) {
            try {
                if (!extension_loaded('pdo_mysql')) {
                    throw new Exception('Mysql error: pdo extension not exists');
                }
                try {
                    $dsnArr = explode(';', $this->dsn);
                    $charset = '';
                    foreach($dsnArr as $d) {
                        $dArr = explode('=', $d);
                        if (!isset($dArr[1])) continue;
                        if ($dArr[0] == 'charset') {
                            $charset = $dArr[1];
                            break;
                        }
                    }
                    $this->pdo = new \PDO($this->dsn, $this->user, $this->pass);
                    $this->pdo->setAttribute(\PDO::ATTR_TIMEOUT, $this->timeout);
                    if ($charset) {
                        $this->pdo->setAttribute(\PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES '{$charset}';");
                    }
                } catch ( \PDOException $e) {
                    throw new Exception( $e->getMessage() );
                }
            } catch (Exception $e) {
                $e->getExceptionMessage();
            }
        }
    }

    public function translation() {
        $this->connect();
        try {
            if ($this->translation == null) {
                $this->translation = new Translation($this);
            } elseif ($this->translation->getTransing()) {
                throw new Exception('Mysql Translation error: translation is active and cannot open new translation operations');
            }
            $this->pdo->beginTransaction();
        } catch (Exception $e) {
            $e->getExceptionMessage();
        }
        return $this->translation;
    }

    public function getPdoInstance() {
        $this->connect();
        return $this->pdo;
    }

    public function execute($sql) {
        $this->connect();
        $result = $this->pdo->exec($sql);
        if ($this->checkError()) {
            $id = $this->lastInsertId();
            return $id ? $id : $result ;
        }
    }

    public function query($sql) {
        $this->connect();
        $result = $this->pdo->query($sql);
        if ($this->checkError()) {
            return new Command($this, $result, $sql);
        }
    }

    public function prepare($sql) {
        $this->connect();
        try {
            $result = $this->pdo->prepare($sql);
        } catch ( \PDOException $e) {
            throw new Exception( $e->getMessage() );
        }
        $rst = $this->getErrorCode();
        if ($this->checkError()) {
            return new Command($this, $result, $sql);
        }
    }

    public function tablepr() {
        return $this->tablepr;
    }

    public function quote($string) {
        $this->connect();
        return $this->pdo->quote($string);
    }

    public function lastInsertId() {
        $this->connect();
        return $this->pdo->lastInsertId();
    }

    private function checkError() {
        try {
            if ($this->getErrorCode() != '00000') {
                $info = $this->getErrorInfo();
                throw new Exception('Mysql execute error: SQLSTATE['.$info[0].'] ['.$info[1].'] '.$info[2]);
            }
        } catch (Exception $e) {
            $e->getExceptionMessage();
        }
        return true;
    }

    private function getErrorCode() {
        return $this->pdo->errorCode();
    }

    private function getErrorInfo() {
        return $this->pdo->errorInfo();
    }
}
