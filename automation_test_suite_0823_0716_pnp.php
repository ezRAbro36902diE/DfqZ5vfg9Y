<?php
// 代码生成时间: 2025-08-23 07:16:06
use Phalcon\Di;
use Phalcon\Loader;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\View;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Dispatcher\Exception;
use Phalcon\Mvc\Url;
use Phalcon\Db\Adapter\PdoFactory;
use Phalcon\Mvc\Model\Transaction\Manager;
use Phalcon\Session\Adapter\Files;
use Phalcon\Logger;

// 错误处理
set_exception_handler(function($e) {
    echo "Exception: ",  $e->getMessage(), "\
";
});

// 依赖注入容器
$di = new FactoryDefault();

// 设置视图组件
$di->setShared('view', function() {
    $view = new View();
    $view->setViewsDir('../app/views/');
    return $view;
});

// 设置URL组件
$di->setShared('url', function() {
    $url = new Url();
    $url->setBaseUri('/automation_test_suite/');
    return $url;
});

// 设置数据库连接
$di->set('db', function() {
    return PdoFactory::load(
        "mysql:host=localhost;dbname=test_db",
        'username',
        'password'
    );
});

// 设置模型事务管理器
$di->setShared('transactionManager', function() {
    return new Manager();
});

// 设置日志组件
$di->set('logger', function() {
    $logger = new Logger\Adapter\File('app/logs/test.log');
    return $logger;
});

// 设置会话组件
$di->setShared('session', function() {
    $session = new Files();
    $session->start();
    return $session;
});

// 自动加载类
$loader = new Loader();
$loader->registerDirs(array(
    '../app/controllers/',
    '../app/models/'
))->register();

try {
    // 实例化和启动Phalcon MVC应用程序
    $application = new Application($di);
    $response = $application->handle(
        \$_SERVER['REQUEST_URI']
    );
    $response->send();
} catch (Exception $e) {
    echo "Dispatcher exception: ", $e->getMessage();
}
