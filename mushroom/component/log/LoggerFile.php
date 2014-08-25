<?php
namespace mushroom\component\log;

use \mushroom\library\File;

class LoggerFile extends LoggerAbstract
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    
    }

    protected function write($type, $message, array $context = array())
    {
        $data = "{$type} :  {$message}";
        return File::write($this->config['path'], $data, true);
    }
}

