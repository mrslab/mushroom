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

namespace mushroom\component\session;

class Session implements session\IFSession {

    protected $config;

    protected $session;

    protected $name;

    public function __construct($config) {
        $this->config = $config;
        $this->name = isset($this->config['name']) ? $this->config['name'] : '_MR_SID_';
        $this->driver = isset($this->config['driver']) ? $this->config['driver'] : 'File';
        $this->initConfig();
        $this->initSession();
        $this->start();
    }

    public function start() {
        session_name($this->name);
        session_start();
    }

    public function sid() {
        return session_id();
    }

    public function get($key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function delete($key = null) {
        if (null === $key) {
            session_destroy();
        } else {
            unset($_SESSION[$key]);
        }
    }

    private function bindSession($session) {
        session_set_save_handler(
            array($session,'open'), 
            array($session,'close'), 
            array($session,'read'), 
            array($session,'write'), 
            array($session,'destroy'), 
            array($session,'gc')
        ); 
    }

    private function initSession() {
        switch($this->driver) {
            case 'Mysql':
                $session = new session\Mysql($this->config);
                $this->bindSession($session);
                break;
            case 'Memcache':
                $session = new session\Memcache($this->config['connect']);
                $this->bindSession($session);
                break;
            case 'File':
                new session\File($this->config);
                break;
        }
    }

    private function initConfig() {
        isset($this->config['life']) && $this->setSessionLife($this->config['life']);
    }

    private function setSessionLife($life) {
        ini_set('session.gc_maxlifetime', $life);
    }
}
