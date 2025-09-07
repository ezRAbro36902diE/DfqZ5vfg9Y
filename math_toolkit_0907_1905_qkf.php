<?php
// 代码生成时间: 2025-09-07 19:05:44
 * easily understandable, maintainable, and extendable.
 *
 * @package MathToolkit
 * @author Your Name
 * @version 1.0
 */

use Phalcon\Mvc\Model;

class MathToolkit extends Model
{

    /**
     * Add two numbers
     *
     * @param float $num1
     * @param float $num2
     * @return float
     */
    public function add($num1, $num2)
    {
        return $num1 + $num2;
    }

    /**
     * Subtract one number from another
     *
     * @param float $num1
     * @param float $num2
     * @return float
     */
    public function subtract($num1, $num2)
    {
        return $num1 - $num2;
    }

    /**
     * Multiply two numbers
     *
     * @param float $num1
     * @param float $num2
     * @return float
     */
    public function multiply($num1, $num2)
    {
        return $num1 * $num2;
    }

    /**
     * Divide one number by another
     *
     * @param float $num1
     * @param float $num2
     * @return float
     */
    public function divide($num1, $num2)
    {
        if ($num2 == 0) {
            throw new \u0027InvalidArgumentException\u0027(\u0027Division by zero is not allowed.\u0027);
        }
        return $num1 / $num2;
    }

    /**
     * Calculate the square root of a number
     *
     * @param float $num
     * @return float
     */
    public function squareRoot($num)
    {
        if ($num < 0) {
            throw new \u0027InvalidArgumentException\u0027(\u0027Square root of negative number is not allowed.\u0027);
        }
        return sqrt($num);
    }

    /**
     * Calculate the factorial of a number
     *
     * @param int $num
     * @return int
     */
    public function factorial($num)
    {
        $result = 1;
        for ($i = 1; $i <= $num; $i++) {
            $result *= $i;
        }
        return $result;
    }

    /**
     * Calculate the power of a number
     *
     * @param float $base
     * @param float $exponent
     * @return float
     */
    public function power($base, $exponent)
    {
        return pow($base, $exponent);
    }

}
