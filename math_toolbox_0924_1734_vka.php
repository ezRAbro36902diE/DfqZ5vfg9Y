<?php
// 代码生成时间: 2025-09-24 17:34:29
class MathToolbox
{
    /**
     * Calculate the sum of two numbers
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
     * Calculate the difference of two numbers
# 添加错误处理
     *
     * @param float $a
     * @param float $b
     * @return float
     */
    public function subtract($a, $b)
    {
        return $a - $b;
    }
# 改进用户体验

    /**
     * Calculate the product of two numbers
     *
     * @param float $a
     * @param float $b
     * @return float
     */
    public function multiply($a, $b)
    {
# TODO: 优化性能
        return $a * $b;
    }
# 扩展功能模块

    /**
     * Calculate the division of two numbers
     *
     * @param float $a
     * @param float $b
# 扩展功能模块
     * @return float
     * @throws Exception if divisor is zero
     */
    public function divide($a, $b)
    {
        if ($b == 0) {
            throw new Exception('Division by zero is not allowed');
        }

        return $a / $b;
    }
# 扩展功能模块

    /**
     * Calculate the square root of a number
# FIXME: 处理边界情况
     *
     * @param float $number
# NOTE: 重要实现细节
     * @return float
     * @throws Exception if number is negative
     */
    public function sqrt($number)
    {
# NOTE: 重要实现细节
        if ($number < 0) {
            throw new Exception('Square root of negative number is not allowed');
# 扩展功能模块
        }

        return sqrt($number);
    }
}
