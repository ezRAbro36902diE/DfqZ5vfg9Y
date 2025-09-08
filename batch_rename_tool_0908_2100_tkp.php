<?php
// 代码生成时间: 2025-09-08 21:00:58
// 设置错误报告级别
error_reporting(E_ALL);

use Phalcon\Loader;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Autoload\Exception as AutoloadException;

try {
    // 自动载入类文件
    $loader = new Loader();
    $loader->registerDirs(
        array(
            '../app/controllers/',
            '../app/models/'
        )
    )->register();

    // 依赖注入容器
    $di = new FactoryDefault();

    // 设置应用程序服务
    $di->setShared('db', function () {
        $config = new \Phalcon\Config\Adapter\Ini('../app/config/config.ini');
        $dbConfig = $config->database;
        $class = 'Phalcon\Db\Adapter\Pdo\' . $dbConfig->adapter;
        $connection = new $class(
            array(
                'host'     => $dbConfig->host,
                'username' => $dbConfig->username,
                'password' => $dbConfig->password,
                'dbname'   => $dbConfig->dbname,
            )
        );
        return $connection;
    });

    // 初始化Phalcon应用程序
    $application = new Application($di);

    // 路由定义
    $application->get('/files/rename', function () use ($application) {
        // 获取请求参数
        $path = $_GET['path'] ?? '';
        $prefix = $_GET['prefix'] ?? '';
        $suffix = $_GET['suffix'] ?? '';
        $extension = $_GET['extension'] ?? 'txt';

        // 检查路径是否有效
        if (!is_dir($path)) {
            return $application->response->setJsonContent(array(
                'status'  => 'error',
                'message' => 'Invalid path provided.'
            ));
        exit;
        }

        // 获取目录内所有文件
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path),
            RecursiveIteratorIterator::SELF_FIRST
        );

        $renameCount = 0;
        foreach ($files as $name => $file) {
            if ($file->isFile()) {
                $newName = $prefix . \basename($file->getPathname(), '.' . $file->getExtension()) . $suffix . '.' . $extension;
                $newPath = $file->getPath() . DIRECTORY_SEPARATOR . $newName;

                // 重命名文件
                if (rename($file->getPathname(), $newPath)) {
                    $renameCount++;
                } else {
                    // 处理错误
                    return $application->response->setJsonContent(array(
                        'status'  => 'error',
                        'message' => 'Failed to rename file: ' . $file->getPathname()
                    ));
                exit;
                }
            }
        }

        // 返回重命名结果
        return $application->response->setJsonContent(array(
            'status'  => 'success',
            'message' => 'Files renamed successfully.',
            'count'   => $renameCount
        ));
    });

    // 运行应用程序
    $application->handle();
} catch (AutoloadException $e) {
    echo "Autoload exception: ", $e->getMessage();
} catch (Exception $e) {
    echo "Exception: ", $e->getMessage();
}