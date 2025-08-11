<?php
// 代码生成时间: 2025-08-11 16:18:32
class MathToolkit
{

   /**
    * Adds two numbers.
    *
    * @param float $a
    * @param float $b
    * @return float
    */
    public function add($a, $b)
    {
        return $a + $b;
    }

    /**
    * Subtracts two numbers.
    *
    * @param float $a
    * @param float $b
    * @return float
    */
    public function subtract($a, $b)
    {
        return $a - $b;
    }

    /**
    * Multiplies two numbers.
    *
    * @param float $a
    * @param float $b
    * @return float
    */
    public function multiply($a, $b)
    {
        return $a * $b;
    }

    /**
    * Divides two numbers.
    *
    * @param float $a
    * @param float $b
    * @return float
    *
    * @throws Exception if the divisor is zero.
    */
    public function divide($a, $b)
    {
        if ($b == 0) {
            throw new Exception('Cannot divide by zero.');
        }

        return $a / $b;
    }

    /**
    * Calculates the power of a number.
    *
    * @param float $base
    * @param float $exponent
    * @return float
    */
    public function power($base, $exponent)
    {
        return pow($base, $exponent);
    }

    /**
    * Calculates the square root of a number.
    *
    * @param float $number
    * @return float
    *
    * @throws Exception if the number is negative.
    */
    public function sqrt($number)
    {
        if ($number < 0) {
            throw new Exception('Cannot calculate square root of a negative number.');
        }

        return sqrt($number);
    }
}
