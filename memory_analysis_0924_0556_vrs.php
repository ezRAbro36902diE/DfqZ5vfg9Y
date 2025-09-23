<?php
// 代码生成时间: 2025-09-24 05:56:59
class MemoryAnalysis {

    /**
     * Retrieves the current memory usage.
     *
     * @return float The current memory usage in bytes.
     */
    public function getCurrentMemoryUsage(): float {
        $currentMemory = memory_get_usage();
        if ($currentMemory === false) {
            throw new Exception('Failed to get current memory usage.');
        }
        return $currentMemory;
    }

    /**
     * Retrieves the peak memory usage.
     *
     * @return float The peak memory usage in bytes.
     */
    public function getPeakMemoryUsage(): float {
        $peakMemory = memory_get_peak_usage();
        if ($peakMemory === false) {
            throw new Exception('Failed to get peak memory usage.');
        }
        return $peakMemory;
    }

    /**
     * Returns a formatted string of the memory usage.
     *
     * @param float $memory The memory usage in bytes.
     * @return string A human-readable string of the memory usage.
     */
    private function formatMemory(float $memory): string {
        return "bytes: " . number_format($memory, 0, '.', ','). "
";
    }

    /**
     * Displays the current memory usage.
     *
     * @return void
     */
    public function displayCurrentMemoryUsage(): void {
        $currentMemory = $this->getCurrentMemoryUsage();
        echo "Current memory usage: " . $this->formatMemory($currentMemory);
    }

    /**
     * Displays the peak memory usage.
     *
     * @return void
     */
    public function displayPeakMemoryUsage(): void {
        $peakMemory = $this->getPeakMemoryUsage();
        echo "Peak memory usage: " . $this->formatMemory($peakMemory);
    }
}

// Example usage
try {
    $memoryAnalysis = new MemoryAnalysis();
    $memoryAnalysis->displayCurrentMemoryUsage();
    $memoryAnalysis->displayPeakMemoryUsage();
} catch (Exception $e) {
    error_log($e->getMessage());
}
