<?php
// 代码生成时间: 2025-09-12 09:56:45
// ProcessManager.php
// 进程管理器类，用于管理进程的创建和终止。

class ProcessManager {

    private $processes = [];

    public function __construct() {
        // 构造函数，初始化进程列表
    }

    // 启动一个新的进程
    public function startProcess($command) {
        try {
            $process = new Process($command);
            $process->start();
            // 将进程ID添加到列表中
            $this->processes[$process->getPid()] = $process;
            return $process->getPid();
        } catch (\Exception $e) {
            // 错误处理
            throw new Exception("Failed to start process: " . $e->getMessage());
        }
    }

    // 终止一个进程
    public function terminateProcess($pid) {
        if (!isset($this->processes[$pid])) {
            throw new Exception("Process with PID {$pid} not found");
        }
        $this->processes[$pid]->stop();
        unset($this->processes[$pid]);
    }

    // 获取所有进程的列表
    public function getProcesses() {
        return array_keys($this->processes);
    }

    // 获取特定进程的状态
    public function getProcessStatus($pid) {
        if (!isset($this->processes[$pid])) {
            throw new Exception("Process with PID {$pid} not found");
        }
        return $this->processes[$pid]->isRunning() ? 'Running' : 'Stopped';
    }

}
