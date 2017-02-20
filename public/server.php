<?php
/**
 * Swoole 入口
 *
 * @author  Leelmes <i@chengxuan.li>
 * @since 2017年2月20日
 */
class Server {
    
    /**
     * 请求信息
     * 
     * @var swoole_http_response
     */
    public static $request;
    
    /**
     * 响应信息
     * 
     * @var swoole_http_response
     */
    public static $response;
    
    /**
     * 启动服务器
     */
    public static function start() {
        $http = new swoole_http_server('127.0.0.1', 9501);
        $http->set(array(
            'worker_num'    => 16,
            'daemonize'     => true,
            'max_request'   => 10000,
            'dispatch_mode' => 1
        ));
        $http->on('WorkerStart', [__CLASS__, 'onWorkerStart']);
        $http->on('request', [__CLASS__, 'onRequest']);
        $http->start();
    }
    
    /**
     * Work启动时处理
     */
    public static function onWorkerStart() {
        define('APP_PATH', dirname(__DIR__));
        $this->application = new Yaf_Application(APP_PATH . '/conf/application.ini');
        ob_start();
        $this->application->bootstrap()->run();
        ob_end_clean();
    }
    
    /**
     * 有请求时处理
     * 
     * @param swoole_http_request  $request  请求信息
     * @param swoole_http_response $response 响应信息
     */
    public static function onRequest(swoole_http_request $request, swoole_http_response $response) {
        self::$request = $request;
        self::$response = $response;
        
        try {
            $yaf_request = new Yaf_Request_Http(self::$server['request_uri']);
            $this->application->getDispatcher()->dispatch($yaf_request);
        } catch (Yaf_Exception $e) {
            // TODO Process Exception
        }
        
        $response->end($result);
    }
}
Server::start();
