<?php
// 代码生成时间: 2025-08-10 18:47:49
use Phalcon\Di;
use Phalcon\Loader;
use Phalcon\Mvc\Application;

// Autoload the dependencies
$loader = new Loader();
$loader->registerDirs(
    array(
        '../app/controllers/',
        '../app/models/',
        '../app/library/'
    )
)->register();

// Set up the dependency injection container
$di = new Di();
$di->setShared('db', function () {
    $config = new Phalcon\Config\Adapter\Ini(__DIR__ . '/../app/config/config.ini');
    $dbConfig = $config->get('database');
    return new Phalcon\Db\Adapter\Pdo\Mysql(array(
        'host'     => $dbConfig->host,
        'username' => $dbConfig->username,
        'password' => $dbConfig->password,
        'dbname'   => $dbConfig->name
    ));
});

// Create an application instance
$application = new Application($di);

// Handle the request and send the response
echo $application->handle()->getContent();

/**
 * Class CompressDecompressTool
 *
 * @package CompressDecompressTool
 */
class CompressDecompressTool
{
    /**
     * Compress a file
     *
     * @param string $filePath
     * @param string $archiveName
     * @return bool
     */
    public function compressFile($filePath, $archiveName)
    {
        try {
            $zip = new ZipArchive();
            if ($zip->open($archiveName, ZipArchive::CREATE) === TRUE) {
                $zip->addFile($filePath, basename($filePath));
                $zip->close();
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            // Handle the error
            return false;
        }
    }

    /**
     * Decompress a file
     *
     * @param string $archiveName
     * @param string $destination
     * @return bool
     */
    public function decompressFile($archiveName, $destination)
    {
        try {
            $zip = new ZipArchive();
            if ($zip->open($archiveName) === TRUE) {
                $zip->extractTo($destination);
                $zip->close();
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            // Handle the error
            return false;
        }
    }
}

// Example usage
$tool = new CompressDecompressTool();
$compressResult = $tool->compressFile('/path/to/file.txt', '/path/to/archive.zip');
$decompressResult = $tool->decompressFile('/path/to/archive.zip', '/path/to/destination/');
