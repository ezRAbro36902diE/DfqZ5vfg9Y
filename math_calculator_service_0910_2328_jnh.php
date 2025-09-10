<?php
// 代码生成时间: 2025-09-10 23:28:22
// MathCalculatorService.php
// 这是一个数学计算工具集的类，使用PHALCON框架

use Phalcon\Mvc\Model;

class MathCalculatorService extends Model
{
    // 用于执行加法运算
    public function add($a, $b)
    {
        if (!is_numeric($a) || !is_numeric($b)) {
            throw new \Phalcon\Mvc\Model\Exception('输入必须是数字。');
        }
        return $a + $b;
    }

    // 用于执行减法运算
    public function subtract($a, $b)
    {
        if (!is_numeric($a) || !is_numeric($b)) {
            throw new \Phalcon\Mvc\Model\Exception('输入必须是数字。');
        }
        return $a - $b;
    }

    // 用于执行乘法运算
    public function multiply($a, $b)
    {
        if (!is_numeric($a) || !is_numeric($b)) {
            throw new \Phalcon\Mvc\Model\Exception('输入必须是数字。');
        }
        return $a * $b;
    }

    // 用于执行除法运算
    public function divide($a, $b)
    {
        if (!is_numeric($a) || !is_numeric($b)) {
            throw new \Phalcon\Mvc\Model\Exception('输入必须是数字。');
        }
        if ($b == 0) {
            throw new \Phalcon\Mvc\Model\Exception('除数不能为零。');
        }
        return $a / $b;
    }

    // 用于执行幂运算
    public function power($base, $exponent)
    {
        if (!is_numeric($base) || !is_numeric($exponent)) {
            throw new \Phalcon\Mvc\Model\Exception('输入必须是数字。');
        }
        return pow($base, $exponent);
    }
}
