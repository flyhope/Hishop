<?php
/**
 * 引导文件定义
 *
 * @author chengxuan <i@chengxuan.li>
 */
class Bootstrap extends Yaf_Bootstrap_Abstract {

    /**
     * 注册本地类名前缀, 这部分类名将会在本地类库查找 
     * @param Yaf_Dispatcher $dispatcher
     */
    public function _initLoader(Yaf_Dispatcher $dispatcher) {
       Yaf_Loader::getInstance()->registerLocalNameSpace(
            array(
                'Api',
                'Cache', 
                'Comm',
                'Data', 
                'Entity',
            )
        );
    }
    
    /**
     * 初始化视图
     * 
     * @param Yaf_Dispatcher $dispatcher
     */
    public function _initView(Yaf_Dispatcher $dispatcher) {
        //手动沉浸模板
        $dispatcher->disableView();
        $dispatcher->autoRender(false);
    }
    
    /**
     * 初始化SESSION
     * 
     * @param Yaf_Dispatcher $dispatcher
     */
    public function _initSession(Yaf_Dispatcher $dispatcher) {
        //开启SESSION
        session_name('HISHOP_SID');
        session_start();
        
        //获取用户UID
        $uid = \Comm\Arg::session('uid', FILTER_VALIDATE_INT);
        Yaf_Registry::set('current_uid', $uid);
    }

    /**
     * 初始化环境
     * 
     * @param Yaf_Dispatcher $dispatcher
     */
    public function _initEnv(Yaf_Dispatcher $dispatcher) {
        mb_internal_encoding('utf-8');
    }
}
