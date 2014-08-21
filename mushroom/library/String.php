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

namespace mushroom\library;

class String {

    public static function uuid() {
        $str = md5(uniqid(mt_rand(), true));   
        $uuid  = substr($str,0,8) . '-';   
        $uuid .= substr($str,8,4) . '-';   
        $uuid .= substr($str,12,4) . '-';   
        $uuid .= substr($str,16,4) . '-';   
        $uuid .= substr($str,20,12);   
        return $uuid;
    }

    public static function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true) {
        if(function_exists("mb_substr"))
            $slice = mb_substr($str, $start, $length, $charset);
        elseif(function_exists('iconv_substr')) {
            $slice = iconv_substr($str,$start,$length,$charset);
        }else{
            $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
            $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
            $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
            $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
            preg_match_all($re[$charset], $str, $match);
            $slice = join("", array_slice($match[0], $start, $length));
        }
         return $suffix ? $slice.'...' : $slice;
    }

    public static function convertCharset($string, $from = 'gbk', $to = 'utf-8') {
        $from = strtoupper($from) == 'UTF8' ? 'utf-8' : $from;
        $to = strtoupper($to) == 'UTF8' ? 'utf-8' : $to;
        if (strtoupper($from) === strtoupper($to) || empty($string) || (is_scalar($string) && !is_string($string))) {
            return $string;
        }
        if (is_string($string)) {
            if (function_exists('mb_convert_encoding')) {
                return mb_convert_encoding($string, $to, $from);
            } elseif (function_exists('iconv')) {
                return iconv($from, $to, $string);
            } else {
                return $string;
            }
        } elseif (is_array($string)) {
            foreach ($string as $key => $val) {
                $_key = self::convertCharset($key, $from, $to);
                $string[$_key] = self::convertCharset($val, $from, $to);
                if ($key != $_key) {
                    unset($string[$key]);
                }
            }
            return $string;
        }
        else {
            return $string;
        }
    }

    public static function filterString($string) {
        $strSearch = array('%20','%27','%2527','*','"' ,"'",';','<' ,'>' ,'{','}','\\');
        $strReplace = array('' ,'' ,'' ,'' ,'&quot;','' ,'' ,'&lt;','&gt;','' ,'' ,'');
        return str_replace($strSearch, $strReplace, $string);
    }

    public static function dHtmlspecialChars($string) {
        if(is_array($string)) {
            foreach($string as $key => $val) {
                $string[$key] = self::dHtmlspecialChars($val);
            }
        } else {
            $string = str_replace(array('&', '"', '\'', '<', '>'), array('&amp;', '&quot;', '&#039;', '&lt;', '&gt;'), $string);
            if(strpos($string, '&amp;#') !== false) {
                $string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1', $string);
            }
        }
        return $string;
    }

    public static function strUrlCode($string, $mode = 'encode') {
        if($mode == 'encode') {
            $bstr = base64_encode($string);
            $bstr = str_replace(array('+', '/'), array('!', '*'), $bstr);
        } else {
            $bstr = str_replace(array('!', '*'), array('+', '/'), $string);
            $bstr = base64_decode($bstr);
        }
        return $bstr;
    }

    public static function lcFirst($string) {
        $string[0] = strtolower($string[0]);
        return (string) $string;
    }
}
