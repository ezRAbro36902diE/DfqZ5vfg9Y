<?php
// 代码生成时间: 2025-09-01 22:45:07
class MathTools {

    /**
     * 计算两个数的和
     *
     * @param float $a 第一个数
     * @param float $b 第二个数
     * @return float 两个数的和
     */
    public function add(float $a, float $b): float {
        return $a + $b;
    }

    /**
     * 计算两个数的差
     *
     * @param float $a 第一个数
     * @param float $b 第二个数
     * @return float 两个数的差
     */
    public function subtract(float $a, float $b): float {
        return $a - $b;
    }

    /**
     * 计算两个数的乘积
     *
     * @param float $a 第一个数
     * @param float $b 第二个数
     * @return float 两个数的乘积
     */
    public function multiply(float $a, float $b): float {
        return $a * $b;
    }

    /**
     * 计算两个数的商
     *
     * @param float $a 第一个数
     * @param float $b 第二个数
     * @return float 两个数的商
     * @throws Exception 如果除数为0，则抛出异常
     */
    public function divide(float $a, float $b): float {
        if ($b == 0) {
            throw new Exception('除数不能为0');
        }

        return $a / $b;
    }
}
