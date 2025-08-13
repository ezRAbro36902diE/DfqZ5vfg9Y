<?php
// 代码生成时间: 2025-08-14 00:50:05
// RandomNumberGenerator.php

use Phalcon\Mvc\Controller;

class RandomNumberGenerator extends Controller
{

    private $lowerBound = 1;
    private $upperBound = 100;

    public function indexAction()
    {
        // 生成一个随机数并发送到视图
        $randomNumber = $this->generateRandomNumber();
        $this->view->setVars([
            'randomNumber' => $randomNumber
        ]);
    }

    private function generateRandomNumber()
    {
        // 检查是否设置了边界值
        if ($this->lowerBound > $this->upperBound) {
            throw new Exception("Lower bound must be less than or equal to upper bound.");
        }

        // 生成随机数
        $randomNumber = rand($this->lowerBound, $this->upperBound);

        // 返回生成的随机数
        return $randomNumber;
    }

    public function setBoundsAction($lower = null, $upper = null)
    {
        // 设置随机数生成器的边界
        if ($lower !== null && $upper !== null) {
            if ($lower > $upper) {
                $this->flashSession->error("Lower bound must be less than or equal to upper bound.");
                return $this->response->redirect('random');
            }
            $this->lowerBound = $lower;
            $this->upperBound = $upper;
        }
        return $this->response->redirect('random');
    }
}
