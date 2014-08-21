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

namespace mushroom\core;

class Request extends Core {

    public function __construct() {
        $this->initRequest();
    }

    public function initRequest() {
        $request = new Core;
        $request->isPost = $this->isPost();
        $request->isGet = $this->isGet();
        $request->isAjax = $this->isAjax();
        $request->clientIp = $this->clientIp();
        $request->referer = $this->referer();
        $request->thisUrl = $this->thisUrl();
        $request->userAgent = $this->userAgent();
        Core::app()->request = $request;
    }

    public function userAgent() {
        return Core::app()->server->http_user_agent;
    }

    public function isPost() {
        if (strtolower(Core::app()->server->request_method) == 'post') {
            return true;
        }
        return false;
    }

    public function isGet() {
        if (strtolower(Core::app()->server->request_method) == 'get') {
            return true;
        }
        return false;
    }

    public function isAjax() {
        if (strtolower(Core::app()->server->http_x_requested_with) == 'xmlhttprequest') {
            return true;
        }
        return false;
    }

    public function clientIp() {
        return Core::app()->server->remote_addr;
    }

    public function referer() {
        return Core::app()->server->http_referer;
    }

    public function thisUrl() {
        $sysProtocal = Core::app()->server->server_port == '443' ? 'https://' : 'http://';
        $phpSelf = Core::app()->server->php_self ? Core::app()->server->php_self : Core::app()->server->script_name;
        $pathInfo = Core::app()->server->path_info;
        $relateUrl = !empty(Core::app()->server->request_uri) ? Core::app()->server->request_uri : $phpSelf . (!empty(Core::app()->server->query_string) ? '?' . Core::app()->server->query_string : $pathInfo);
        return $sysProtocal. Core::app()->server->http_host .( Core::app()->server->server_port == 80 ? '' : ':' . Core::app()->server->server_port ).$relateUrl;
    }
}
