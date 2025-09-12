<?php
// 代码生成时间: 2025-09-13 02:42:11
use Phalcon\Db\Adapter\Pdo;
use Phalcon\Db\Enum;
use Phalcon\Mvc\Model\Manager;
use Phalcon\Mvc\Model\Resultset;
use Phalcon\Db\RawValue;
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;

/**
 * DatabaseService Class
 *
 * This class handles database operations and prevents SQL injection.
 */
class DatabaseService 
{
    private $db;
    private $di;

    public function __construct($di) 
    {
        $this->di = $di;
        $this->db = $di->getShared('db');
    }

    /**
     * Prevents SQL injection by using bound parameters.
     *
     * @param string $table
     * @param array $data
     * @return ResultSet|false
     */
    public function insertData($table, $data) 
    {
        try {
            $sql = 'INSERT INTO ' . $table . ' (' . implode(', ', array_keys($data)) . ') VALUES (' . str_repeat('?, ', count($data) - 1) . '?';
            $result = $this->db->execute($sql, array_values($data));
            if ($result) {
                return $result;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $this->handleException($e);
        }
    }

    /**
     * Prevents SQL injection by using bound parameters in SELECT queries.
     *
     * @param string $table
     * @param array $conditions
     * @return ResultSet|false
     */
    public function selectData($table, $conditions) 
    {
        try {
            $conditionsStr = '';
            foreach ($conditions as $key => $value) {
                $conditionsStr .= $key . ' = ? AND ';
            }
            $conditionsStr = rtrim($conditionsStr, 'AND ');
            $sql = 'SELECT * FROM ' . $table . ' WHERE ' . $conditionsStr;
            $result = $this->db->execute($sql, array_values($conditions));
            if ($result) {
                return $result;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $this->handleException($e);
        }
    }

    /**
     * Handles exceptions and logs errors.
     *
     * @param Exception $e
     */
    private function handleException($e) 
    {
        error_log($e->getMessage());
        // Handle the exception (e.g., log error, notify admin, etc.)
    }
}
