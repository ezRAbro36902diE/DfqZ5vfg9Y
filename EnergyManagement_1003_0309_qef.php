<?php
// 代码生成时间: 2025-10-03 03:09:24
class EnergyManagement
{

    /**
     * @var \Phalcon\Db\Adapter\Pdo\Mysql $db
     * Database connection
     */
    private $db;

    /**
     * Constructor
     *
     * @param \Phalcon\Config $config
     */
    public function __construct(\Phalcon\Config $config)
    {
        $this->db = new \Phalcon\Db\Adapter\Pdo\Mysql(
            (array) $config->database
        );
    }

    /**
     * Add energy consumption data
     *
     * @param array $data
     * @return bool
     */
    public function addConsumptionData(array $data)
    {
        try {
            // Insert data into the database
            $this->db->insert(
                'energy_consumption', // Table name
                $data, // Data to insert
                null, // Column names (null means insert all columns)
                null // Values to bind (null means no binding)
            );
            return true;
        } catch (\Phalcon\Db\Exception $e) {
            // Handle error
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Retrieve energy consumption data
     *
     * @param int $id
     * @return array|bool
     */
    public function getConsumptionData($id)
    {
        try {
            // Select data from the database
            $result = $this->db->fetchOne(
                'SELECT * FROM energy_consumption WHERE id = :id:',
                null,
                null,
                ['id' => $id]
            );
            return $result ?: false;
        } catch (\Phalcon\Db\Exception $e) {
            // Handle error
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Calculate total energy consumption
     *
     * @param int $days
     * @return float|bool
     */
    public function calculateTotalConsumption($days)
    {
        try {
            // Calculate total energy consumption for the given number of days
            $result = $this->db->fetchOne(
                'SELECT SUM(consumption) as total FROM energy_consumption WHERE DATEDIFF(CURDATE(), date) <= :days',
                null,
                null,
                ['days' => $days]
            );
            return $result['total'] ?: false;
        } catch (\Phalcon\Db\Exception $e) {
            // Handle error
            error_log($e->getMessage());
            return false;
        }
    }

}
