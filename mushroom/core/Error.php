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

class Error {

    public static function kerError($errno, $errStr, $errfile, $errline) {
        switch($errno) {
            case \E_ERROR:
            case \E_PARSE:
            case \E_CORE_ERROR:
            case \E_COMPILE_ERROR:
            case \E_USER_ERROR:
                $errTit = "ERROR({$errno})";
                $error = MR_E_ERROR;
                break;
            case \E_WARNING:
            case \E_CORE_WARNING:
            case \E_COMPILE_WARNING:
            case \E_USER_WARNING:
                $errTit = "WARNING({$errno})";
                $error = MR_E_WARNING;
                break;
            case \E_NOTICE:
            case \E_STRICT:
            case \E_USER_NOTICE:
            default:
                $errTit = "NOTICE({$errno})";
                $error = MR_E_NOTICE;
                break;
        }
        if (MR_DEV_DEBUG == true) {
            if (!headers_sent()) {
                header('HTTP/1.1 500 Internal Server Error');
            }
            if(isset(Core::app()->global->gzipOpened) && Core::app()->global->gzipOpened) {
                ob_end_clean();
            }
            $trace = self::getTraces();
            if (MR_RT_CLI) {
                self::showCliMessage($errTit, $errStr, $errfile, $errline, $trace);
            } else {
                self::showHtmlMessage($errTit, $errStr, $errfile, $errline, $trace);
            }

        } elseif ($error == MR_E_ERROR) {
            if (!headers_sent()) {
                header('HTTP/1.1 404 Not Found');
            }
        }
        exit(1);
    }

    private static function showHtmlMessage($errTit, $errStr, $errfile, $errline, $trace) {
        $traceStr = $dot = '';
        $numline = 0;
        foreach($trace as $k => $v) {
            $vdot = $dot.'#'.($numline++).str_repeat("&nbsp;", 3 - count($numline));
            $vfile = isset($v['file']) ? $v['file']: '';
            $vline = isset($v['line']) ? '('.$v['line'].')': '';
            $vclass = isset($v['class']) ? $v['class'] : '';
            $vtype = isset($v['type']) ? $v['type'] : '';
            $vfunc = isset($v['function']) ? $v['function'] : '';
            $vargs = !empty($v['args']) ? '('.json_encode($v['args']).' )' : '()';

            $traceStr .= $vdot.$vfile.$vline.': '.$vclass.$vtype.$vfunc.$vargs;
            $dot = '<br/>';
        }
        $outLine = "{$errfile}&#12288;(Line {$errline})";
        echo self::errorTpl($errTit, $errStr, $outLine, $traceStr);
    }

    private static function showCliMessage($errTit, $errStr, $errfile, $errline, $trace) {
        $traceStr = $dot = '';
        $numline = 0;
        foreach($trace as $k => $v) {
            $vdot = $dot.'# '.($numline++);
            $vfile = isset($v['file']) ? $v['file']: '';
            $vline = isset($v['line']) ? '('.$v['line'].')': '';
            $vclass = isset($v['class']) ? $v['class'] : '';
            $vtype = isset($v['type']) ? $v['type'] : '';
            $vfunc = isset($v['function']) ? $v['function'] : '';
            $vargs = !empty($v['args']) ? '('.json_encode($v['args']).' )' : '()';

            $traceStr .= $vdot.$vfile.$vline.': '.$vclass.$vtype.$vfunc.$vargs;
            $dot = "\n";
        }
        $output = array(
            "[{$errTit}] [".date(\DATE_ATOM, MR_RT_TIMESTAMP)."] \"{$errStr}\" IN {$errfile} ($errline)",
            "Code Backtrace:",
            $traceStr,
        );
        $output = implode("\n", $output)."\n";
        echo $output;
    }

    public static function kerShutdown() {
    	$fatal = error_get_last();
        if($fatal) {
            self::kerError($fatal['type'], $fatal['message'], $fatal['file'], $fatal['line']);
        }
    }

    private static function getTraces() {
        $trace = debug_backtrace();
        array_shift($trace);
        array_shift($trace);
        return $trace;
    }

    private static function errorTpl($tit, $msg, $file, $trace) {
        $tpl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta content="text/html; charset=utf-8" http-equiv="Content-Type"><title>system error occurred</title><style>body{font: normal 9pt "Verdana";color: #000;background: #fff;}html,body,div,span,h1,p,pre{border:2;outline:0;font-size:100%;vertical-align:baseline;background:transparent;margin:0;padding:0;}.container{margin: 1em 4em;}h1 {font: normal 18pt "Verdana";color: #f00;margin-bottom: .5em;}.message {color: #000;padding: 1em;font-size: 11pt;background: #f3f3f3;-webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius:10px;margin-bottom: 1em;line-height: 160%;}.file {margin-bottom: 1em;font-weight: bold;}.traces{margin: 2em 0;} .traces p{border: 1px dashed #c00; padding:10px;line-height:1.5em;font-size:0.8em;}.copyright{color: gray;font-size: 8pt;border-top: 1px solid #aaa;padding-top: 1em;margin-bottom: 1em;}</style></head><body><div class="container"><h1>'.$tit.'</h1><p class="message">'.$msg.'</p><div class="file">'.$file.'</div><div class="traces"><p>'.$trace.'</p></div><p class="copyright">'.date(\DATE_ATOM, MR_RT_TIMESTAMP).' <a title="官方网站" href="http://mushroom.dreamans.com" target="_blank">Mushroom</a><sup>'.MR_VERSION.'</sup></p></div></body></html>';
        return $tpl;
    }
}
