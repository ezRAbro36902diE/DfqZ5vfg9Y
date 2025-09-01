<?php
// 代码生成时间: 2025-09-01 09:16:39
// 数据库迁移工具类
class DatabaseMigrationTool {

    protected $di;
    protected $db;
    protected $config;

    // 构造函数
    public function __construct($di) {
        $this->di = $di;
        $this->db = $this->di->getShared('db');
        $this->config = $this->di->get('config')->get('database');
    }

    // 执行数据库迁移
    public function migrate($migrationsDir) {
        try {
            // 检查迁移目录是否存在
            if (!file_exists($migrationsDir)) {
                throw new \Exception('Migrations directory does not exist');
            }

            // 读取迁移文件
            $migrations = $this->getMigrationFiles($migrationsDir);

            // 执行迁移
            foreach ($migrations as $migration) {
                $this->runMigration($migration);
            }

            echo "Migration completed successfully.\
";

        } catch (\Exception $e) {
            // 错误处理
            echo "Error: " . $e->getMessage();
        }
    }

    // 获取迁移文件
    protected function getMigrationFiles($migrationsDir) {
        $migrations = [];
        $files = new DirectoryIterator($migrationsDir);

        foreach ($files as $fileinfo) {
            if ($fileinfo->isFile() && $fileinfo->getExtension() === 'php') {
                $migrations[] = $fileinfo->getPathname();
            }
        }

        return $migrations;
    }

    // 执行单个迁移
    protected function runMigration($migrationFile) {
        include $migrationFile;
        $className = pathinfo($migrationFile, PATHINFO_FILENAME);
        $migration = new $className($this->db);

        if (method_exists($migration, 'up')) {
            $migration->up();
        } else {
            throw new \Exception("Migration {$className} does not have an 'up' method");
        }
    }

}

// 使用示例
$di = new \Phalcon\Di();
$di->set('db', function () {
    $adapter = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbname' => 'test_db'
    ));
    return $adapter;
});

$config = new \Phalcon\Config(array(
    'database' => array(
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbname' => 'test_db'
    )
));

$di->set('config', $config);

$migrationTool = new DatabaseMigrationTool($di);
$migrationTool->migrate('/path/to/migrations');
