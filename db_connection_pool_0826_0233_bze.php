<?php
// 代码生成时间: 2025-08-26 02:33:50
use Phalcon\Db\Adapter\PdoFactory;
use Phalcon\Di\FactoryDefault;
use Phalcon\Di\Injectable;

class DbConnectionPool extends Injectable {
    protected $adapters;
    protected $config;

    /**
     * Inject the dependency injection container and configuration.
     *
     * @param FactoryDefault $di
     * @param array $config
     */
    public function __construct(FactoryDefault $di, array $config) {
        $this->di = $di;
        $this->config = $config;
        $this->adapters = [];
    }

    /**
     * Initialize the database connection pool.
     *
     * @return void
     */
    public function initialize() {
        foreach ($this->config['db'] as $name => $dbConfig) {
            try {
                $adapter = PdoFactory::load($dbConfig);
                $this->adapters[$name] = $adapter;
                $this->di->setShared($name, $adapter);
            } catch (Exception $e) {
                // Handle connection error
                throw new Exception("Failed to initialize database connection: " . $e->getMessage());
            }
        }
    }

    /**
     * Get a database connection from the pool.
     *
     * @param string $name
     * @return mixed
     */
    public function getConnection($name) {
        if (isset($this->adapters[$name])) {
            return $this->adapters[$name];
        } else {
            // Handle missing connection error
            throw new Exception("Database connection not found: " . $name);
        }
    }

    /**
     * Close all database connections in the pool.
     *
     * @return void
     */
    public function closeAll() {
        foreach ($this->adapters as $adapter) {
            $adapter->close();
        }
    }
}

// Example usage
try {
    $di = new FactoryDefault();
    $config = [
        'db' => [
            'master' => [
                'host' => 'localhost',
                'username' => 'root',
                'password' => 'password',
                'dbname' => 'test_db',
                'charset' => 'utf8'
            ],
            'slave' => [
                'host' => 'localhost',
                'username' => 'root',
                'password' => 'password',
                'dbname' => 'test_db',
                'charset' => 'utf8'
            ]
        ]
    ];

    $dbPool = new DbConnectionPool($di, $config);
    $dbPool->initialize();

    // Get a database connection
    $connection = $dbPool->getConnection('master');
    echo $connection->host; // Output: localhost

    // Close all connections
    $dbPool->closeAll();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}