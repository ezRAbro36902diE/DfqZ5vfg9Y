<?php
// 代码生成时间: 2025-09-18 06:11:33
 * It is designed to be easily understandable, maintainable, and extensible.
 *
 * @package MathToolkit
 * @author Your Name
 * @version 1.0
 */
class MathToolkit
{
    /**
     * Add two numbers
     *
     * @param float $number1 First number
     * @param float $number2 Second number
     * @return float The sum of the two numbers
     */
    public function add($number1, $number2)
    {
        return $number1 + $number2;
    }

    /**
     * Subtract the second number from the first number
     *
     * @param float $number1 First number
     * @param float $number2 Second number
     * @return float The difference between the two numbers
     */
    public function subtract($number1, $number2)
    {
        return $number1 - $number2;
    }

    /**
     * Multiply two numbers
     *
     * @param float $number1 First number
     * @param float $number2 Second number
     * @return float The product of the two numbers
     */
    public function multiply($number1, $number2)
    {
        return $number1 * $number2;
    }

    /**
     * Divide the first number by the second number
     *
     * @param float $number1 First number
     * @param float $number2 Second number
     * @return float The quotient of the two numbers
     * @throws Exception If the divisor is zero
     */
    public function divide($number1, $number2)
    {
        if ($number2 == 0) {
            throw new Exception('Division by zero is not allowed.');
        }

        return $number1 / $number2;
    }

    /**
     * Calculate the square root of a number
     *
     * @param float $number The number to calculate the square root of
     * @return float The square root of the number
     * @throws Exception If the number is negative
     */
    public function squareRoot($number)
    {
        if ($number < 0) {
            throw new Exception('Square root of a negative number is not defined in real numbers.');
        }

        return sqrt($number);
    }
}

// Example usage:
try {
    $mathToolkit = new MathToolkit();
    echo $mathToolkit->add(10, 5) . "
";
    echo $mathToolkit->subtract(10, 5) . "
";
    echo $mathToolkit->multiply(10, 5) . "
";
    echo $mathToolkit->divide(10, 5) . "
";
    echo $mathToolkit->squareRoot(25) . "
";
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
