<?php
// 代码生成时间: 2025-10-02 16:18:59
use Phalcon\Mvc\Application;
use Phalcon\Loader;
use Phalcon\Di\FactoryDefault;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Config\Config;
use Phalcon\Autoload\Events as AutoloadEvents;

// Setting up the autoloader
$loader = new Loader();
$loader->registerNamespaces([
    'App\Controllers' => __DIR__ . '/app/controllers/',
    'App\Models' => __DIR__ . '/app/models/',
    'App\Library' => __DIR__ . '/app/library/',
    'App\Plugins' => __DIR__ . '/app/plugins/',
])->register();

// Setting up the DI container
$di = new FactoryDefault();

// Registering a shared service
$di->set('flash', function () {
    return new Flash(['error' => 'Error', 'success' => 'Success']);
});

// Registering configuration
$di->set('config', function () {
    $config = new Config(include __DIR__ . '/config/config.php');
    return $config;
});

// Registering events manager
$di->set('dispatcher', function () {
    $dispatcher = new Phalcon\Mvc\Dispatcher();
    $dispatcher->setDefaultNamespace('App\Controllers');
    return $dispatcher;
});

// Registering autoloader
$di->set('autoloader', $loader, true);

// Registering the application service
$di->set('application', function () use ($di) {
    $application = new Application($di);
    // Handle exceptions
    $application->registerModules(['frontend' => 'App\Controllers']);
    return $application;
});

// Registering a service for caching
$di->set('cache', function () {
    // Simple file-based cache
    return new Phalcon\Cache\Backend\File(
        new Phalcon\Cache\Frontend\Data(['lifetime' => 86400]),
        [['cacheDir' => __DIR__ . '/cache/']]
    );
});

// Error handling
$di->set('errorHandler', function () {
    return function ($exception) {
        // Handling error
        $di->get('flash')->error($exception->getMessage());
        // Redirect to error page
        $dispatcher = $di->get('dispatcher');
        $dispatcher->forward(['controller' => 'error', 'action' => 'show404']);
    };
});

// Handling the application
$application = $di->getShared('application');

try {
    $response = $application->handle(
        \$_SERVER['REQUEST_URI']
    )->getContent();
    echo $response;
} catch (Exception \$e) {
    $di->get('errorHandler')(\$e);
}
