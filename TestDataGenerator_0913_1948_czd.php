<?php
// 代码生成时间: 2025-09-13 19:48:44
class TestDataGenerator
{

    private $db;

    /**
     * Constructor
     *
     * @param Phalcon\Db\Adapter\Pdo\Mysql $db
     */
    public function __construct(Phalcon\Db\Adapter\Pdo\Mysql $db)
    {
        $this->db = $db;
    }

    /**
     * Generates random test data
     *
     * @return array
     */
    public function generateTestData()
    {
        try {
            // Seed the random number generator
            srand((float) microtime() * 100000);

            // Generate random data
            $data = [];
            $data['name'] = $this->generateRandomString(10);
            $data['email'] = $this->generateRandomString(10) . "@example.com";
            $data['age'] = rand(18, 60);
            $data['created_at'] = date("Y-m-d H:i:s");

            // Insert data into the database
            $this->db->insert(
                "users",
                null,
                [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'age' => $data['age'],
                    'created_at' => $data['created_at']
                ],
                null,
                null
            );

            return $data;
        } catch (Exception $e) {
            // Handle any errors that occur
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Generates a random string of specified length
     *
     * @param int $length
     * @return string
     */
    private function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

}
