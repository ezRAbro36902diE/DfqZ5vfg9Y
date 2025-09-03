<?php
// 代码生成时间: 2025-09-04 02:09:09
use Phalcon\Mvc\Model;

class RandomNumberGenerator extends Model
{
    /**
     * Generate a random number within a specified range
     *
     * @param int $min Minimum value of the range
     * @param int $max Maximum value of the range
     * @return int Random number within the specified range
     * @throws Exception If invalid range is provided
     */
    public function generateRandomNumber($min, $max)
    {
        // Check if the provided range is valid
        if ($min > $max) {
            throw new Exception("Invalid range: Minimum value cannot be greater than maximum value.");
        }

        // Generate a random number within the specified range
        $randomNumber = rand($min, $max);

        // Return the generated random number
        return $randomNumber;
    }
}
