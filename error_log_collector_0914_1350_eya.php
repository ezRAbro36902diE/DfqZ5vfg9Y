<?php
// 代码生成时间: 2025-09-14 13:50:21
// ErrorLogCollector.php
// 错误日志收集器

use Phalcon\Logger;
use Phalcon\Logger\Adapter\File;
use Phalcon\Logger\Formatter\Line;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Mvc\User\Component;

class ErrorLogCollector extends Component
{
    // 错误日志文件路径
    private $logFile;
    
    // 日志实例
    private $logger;
    
    // 初始化方法
    public function initialize()
    {
        // 设置日志文件路径
        $this->logFile = 'app/logs/error.log';
        
        // 创建日志格式器
        $formatter = new Line();
        $formatter->setFormat("[%date%] %message%\
");
        
        // 创建日志文件适配器
        $adapter = new File($this->logFile);
        $adapter->setFormatter($formatter);
        
        // 创建日志实例
        $this->logger = new Logger('errorLogger', [$adapter]);
    }
    
    // 记录错误方法
    public function logError($message, $level = Logger::ERROR)
    {
        try {
            // 记录错误日志
            $this->logger->log($message, $level);
        } catch (Exception $e) {
            // 错误处理
            echo 'Error logging: ' . $e->getMessage();
        }
    }
    
    // 清除日志文件方法
    public function clearLog()
    {
        try {
            if (file_exists($this->logFile)) {
                // 清空日志文件
                file_put_contents($this->logFile, "");
            }
        } catch (Exception $e) {
            // 错误处理
            echo 'Error clearing log: ' . $e->getMessage();
        }
    }
}
