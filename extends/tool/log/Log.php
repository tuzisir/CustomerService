<?php
/**
 * User: 郭玉朝
 * CreateTime: 2018/4/25 下午6:40
 * Description: 日志记录等级 分为三级 错误日志（error） 调试日志（debug） 跟踪日志（trace） 根据需要选择
 */
namespace Tool\Log;
use Tool\Log\Config;

class Log {

    protected $logType;
    protected $path = Config::LOG_PATH;  //定义log日志文件的存放路径
    protected static $myself = null;
    protected $modular = '';
    protected static $params = [''];

    /**
     * Log constructor.
     */
    public function __construct()
    {
        umask(0); // 777
        date_default_timezone_set( Config::TIME_ZONE ); // 设置时区
        $this->init();
    }

    /**
     * Description: 单例模式
     * User: 郭玉朝
     * CreateTime: 2018/4/25 下午9:39
     * @return Log
     */
    public static function instance(array $params  = [''])
    {
        if (Log::$myself == null || $params[0] != Log::$params[0]) {
            Log::$params = $params;
            Log::$myself = new Log();
            return Log::$myself;
        }
        Log::$params = $params;
        return Log::$myself;
    }

    /**
     * Description: 初始化必要参数
     * User: 郭玉朝
     * CreateTime: 2018/4/25 下午10:44
     * @param $params
     */
    public function init() {
        if (isset(Log::$params[0])) {
            $this->path = $this->path . "/".Log::$params[0];
            $this->isExistencePath();
        }
    }

    /**
     * Description: 检查目录是否存在不存在自动创建
     * User: 郭玉朝
     * CreateTime: 2018/4/25 下午10:44
     */
    function isExistencePath() {
        if (!is_dir($this->path)) mkdir($this->path); // 如果不存在则创建
    }

    function logging( $string ) {
        $file = $this->path . '/' . date("Ymd") . '.log';
        $msg = "\r\n==================================请求时间:".date("Y-m-d H:i:s")."=======================================================\r\n".
            "IP地址: ". $_SERVER['REMOTE_ADDR'] . "\r\n".
            "请求地址:". $_SERVER['REQUEST_URI']. "\r\n".
            "日志类型:". $this->logType . "\r\n".
            "日志数据:[\r\n     ". $string . "\r\n]";
        @error_log($msg, 3, $file);
    }

    /**
     * Description: 把数组或者对象转为字符
     * User: 郭玉朝
     * CreateTime: 2018/4/25 下午9:40
     * @param $input
     */
    function try_covert_to_string( &$input ) {
        if( is_object( $input ) || is_array( $input ) ) {
            $input = var_export( $input, true );
        }
    }

    /**
     * Description: 错误日志
     * User: 郭玉朝
     * CreateTime: 2018/4/25 下午9:40
     * @param $string
     */
    function error( $string ) {
        $this->logType = Config::LOG_ERROR;
        $this->try_covert_to_string( $string );
        $this->logging( $string );
    }

    /**
     * Description: 跟踪日志
     * User: 郭玉朝
     * CreateTime: 2018/4/25 下午9:41
     * @param $string
     */
    function trace( $string ) {
        $this->logType = Config::LOG_TRACE;
        $this->try_covert_to_string( $string );
        $this->logging( $string );
    }

    /**
     * Description: 调试日志
     * User: 郭玉朝
     * CreateTime: 2018/4/25 下午9:41
     * @param $string
     */
    function debug( $string ) {
        $this->logType = Config::LOG_DEBUG;
        $this->try_covert_to_string( $string );
        $this->logging( $string );
    }
}
