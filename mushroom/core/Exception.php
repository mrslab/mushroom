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

class Exception extends \Exception{

    public static function kerException($e) {
    	self::showMessage($e->getMessage(), $e->getFile(), $e->getLine(), $e->getTraceAsString());
    }

    public function getExceptionMessage() {
        self::showMessage($this->getMessage(), $this->getFile(), $this->getLine(), $this->getTraceAsString());
    }

    private static function showMessage($msg, $file, $line, $trace) {
        if (MR_DEV_DEBUG == true) {
            if(isset(Core::app()->global->gzipOpened) && Core::app()->global->gzipOpened) {
                ob_end_clean();
            }
            if (!headers_sent()) {
                header('HTTP/1.1 500 Internal Server Error');
            }
            $outLine = "{$file}&#12288;(Line {$line})";
            $trace = str_replace("\r", "", $trace);
            $trace = explode("\n", $trace);
            array_filter($trace);
            $traceStr = $dot = '';
            foreach($trace as $tval) {
                $ftrace = explode(' ', $tval);
                $fftrace = array_shift($ftrace);
                $traceStr .= $dot . $fftrace. str_repeat("&nbsp;", 4 - strlen($fftrace)) . implode("", $ftrace);
                $dot = '<br/>';
            }
            echo self::errorTpl($msg, $outLine, $traceStr);
            exit(1);
        } else {
            if (!headers_sent()) {
                header('HTTP/1.1 404 Not Found');
            }
            exit(1);
        }
    }

    private static function errorTpl($msg, $file, $trace) {
        $tpl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta content="text/html; charset=utf-8" http-equiv="Content-Type"><title>system exception occurred</title><style>body{font: normal 9pt "Verdana";color: #000;background: #fff;}html,body,div,span,h1,p,pre{border:2;outline:0;font-size:100%;vertical-align:baseline;background:transparent;margin:0;padding:0;}.container{margin: 1em 4em;}h1 {font: normal 18pt "Verdana";color: #f00;margin-bottom: .5em;}.message {color: #000;padding: 1em;font-size: 11pt;background: #f3f3f3;-webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius:10px;margin-bottom: 1em;line-height: 160%;}.file {margin-bottom: 1em;font-weight: bold;}.traces{margin: 2em 0;} .traces p{border: 1px dashed #c00; padding:10px;line-height:1.5em;font-size:0.8em;}.copyright{color: gray;font-size: 8pt;border-top: 1px solid #aaa;padding-top: 1em;margin-bottom: 1em;}</style></head><body><div class="container"><h1>Exception</h1><p class="message">'.$msg.'</p><div class="file">'.$file.'</div><div class="traces"><p>'.$trace.'</p></div><p class="copyright">'.date(\DATE_ATOM, MR_RT_TIMESTAMP).' <a title="官方网站" href="http://mushroom.dreamans.com" target="_blank">Mushroom</a><sup>'.MR_VERSION.'</sup></p></div></body></html>';
        return $tpl;
    }
}
