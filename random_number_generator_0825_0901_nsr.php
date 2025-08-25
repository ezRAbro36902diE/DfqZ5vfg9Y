<?php
// 代码生成时间: 2025-08-25 09:01:58
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\Collection;
use Phalcon\Mvc\Micro\MiddlewareInterface;
use Phalcon\Mvc\Micro\Exception;
use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset;
use Phalcon\Mvc\Model\Resultset\Simple;

class RandomNumberGenerator
{
    /**
     * Generate a random number between two numbers
     *
     * @param int $min Lower bound of the random number range
     * @param int $max Upper bound of the random number range
     * @return int
     */
    public function generateRandomNumber(int $min, int $max): int
    {
        if ($min > $max) {
            throw new Exception("Minimum value cannot be greater than maximum value");
        }

        return rand($min, $max);
    }
}

$app = new Micro(Di\FactoryDefault::getDefault());

// Define the route for generating a random number
$app->map(
    "/random",
    function () {
        try {
            $min = 1; // Lower bound of the random number range
            $max = 100; // Upper bound of the random number range
            $generator = new RandomNumberGenerator();
            $randomNumber = $generator->generateRandomNumber($min, $max);
            echo json_encode(['random_number' => $randomNumber]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    },
    ['GET']
);

// Handle the request
$app->handle();
