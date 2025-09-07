<?php
// 代码生成时间: 2025-09-07 11:53:04
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// 定义常量
define('BASE_PATH', dirname(__DIR__));

// 创建服务容器
$di = new FactoryDefault();

// 设置视图组件
$di->setShared('view', function () {
    $view = new View();
    $view->setViewsDir(__DIR__ . '/views/');
    $view->registerEngines([
        '.volt' => function ($view, $di) {
            $volt = new Volt($view, $di);
            $volt->setOptions([
                'compiledPath' => BASE_PATH . '/cache/volt/',
                'compiledExtension' => '.cah',
                'compiledSeparator' => '_',
            ]);
            return $volt;
        },
    ]);
    return $view;
});

// 设置数据库连接
$di->set('db', function () {
    return new DbAdapter([
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => 'password',
        'dbname' => 'test_db',
    ]);
});

// 创建并运行应用程序
$app = new Application($di);
$response = $app->handle(
    \$_SERVER['REQUEST_URI']
);
echo $response->getContent();

// 视图文件：views/home.volt
/*
{{ layout 'layouts/default' }}

{% block content %}
<div class="container">
    <h1>Responsive Layout</h1>
    <p>This is a responsive layout example using Phalcon framework.</p>

    <!-- Responsive grid using Bootstrap CSS framework -->
    <div class="row">
        <div class="col-md-4">Column 1</div>
        <div class="col-md-4">Column 2</div>
        <div class="col-md-4">Column 3</div>
    </div>

    {% include 'partials/footer' %}

{% endblock %}
*/

// 布局文件：views/layouts/default.volt
/*
<!DOCTYPE html>
<html lang="en">\
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Layout</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    {% block content %}{% endblock %}
</body>
</html>
*/

// 部分文件：views/partials/footer.volt
/*
<footer>
    <p>&copy; 2023 Responsive Layout Example</p>
</footer>
*/
