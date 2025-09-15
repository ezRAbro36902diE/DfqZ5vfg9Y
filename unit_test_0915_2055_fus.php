<?php
// 代码生成时间: 2025-09-15 20:55:22
// Load Phalcon autoloader
require __DIR__ . '/vendor/autoload.php';

use Phalcon\DI\FactoryDefault;
use Phalcon\Di;
use Phalcon\Config;
use Phalcon\Mvc\Application;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\_Manager;
use Phalcon\Mvc\View\Engine\Volt;

class UnitTest extends Phalcon\Cli\Task
{
    // Define the task's action methods
    public function mainAction()
    {
        // Initialize the DI container
        $di = new FactoryDefault();

        // Set up the view component
        $di->setShared('view', function () {
            $view = new View();
            $view->setDI($this->getDI());
            $view->setViewsDir(__DIR__ . '/views/');
            $view->registerEngines(array(
                '.volt' => function ($view, $di) {
                    $volt = new Volt($view, $di);
                    $volt->setOptions(array(
                        'compiledPath' => __DIR__ . '/compiled-templates/'
                    ));
                    return $volt;
                }
            ));
            return $view;
        });

        // Set up the model manager
        $di->setShared('modelsManager', function () {
            return new Model\_Manager();
        });

        // Set up the model metadata
        $di->setShared('modelsMetadata', function () {
            return new Phalcon\Mvc\Model\MetaData\Memory();
        });

        // Set up the dispatcher
        $di->setShared('dispatcher', function () {
            return new Phalcon\Mvc\Dispatcher();
        });

        // Set up the application
        $app = new Application($di);
        $app->setBaseUri('/api/');

        // Register services in the application
        $app->registerServices($di);

        // Handle the request and send response
        $response = $app->handle();
        echo $response->getContent();
    }
}

// Run the unit test
$test = new UnitTest();
$test->run();
