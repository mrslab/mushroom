<?php
namespace mushroom\component\log;

abstract class LoggerAbstract
{

    const EMERGENCY = 'emergency';
    const ALERT     = 'alert';
    const NOTICE    = 'notice';
    const ERROR     = 'error';
    const WARNING   = 'warning';
    const INFO      = 'info';

    public function emergency($message, array $context = array()) 
    {
        return $this->write(self::EMERGENCY, $message, $context);
    
    }

    public function alert($message, array $context = array())
    {
        return $this->write(self::ALERT, $message, $context);
    
    }

    public function notice($message, array $context = array())
    {
        return $this->write(self::NOTICE, $message, $context);
        
    }

    public function error($message, array $context = array())
    {
        return $this->write(self::ERROR, $message, $context);
    
    }

    public function warning($message, array $context = array())
    {
        return $this->write(self::WARNING, $message, $context);
    
    }

    public function info($message, array $context = array())
    {
        return $this->write(self::INFO, $message, $context);
    
    }

    abstract public function write($type, $message, array $context = array());

}

