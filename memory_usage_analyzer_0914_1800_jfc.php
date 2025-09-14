<?php
// 代码生成时间: 2025-09-14 18:00:49
class MemoryUsageAnalyzer {

    /**
     * Get the current memory usage in bytes.
     *
     * @return float
     */
    public function getCurrentMemoryUsage() {
        return memory_get_usage();
    }

    /**
     * Get the peak memory usage in bytes.
     *
     * @return float
     */
    public function getPeakMemoryUsage() {
        return memory_get_peak_usage();
    }

    /**
     * Get human-readable memory usage.
     *
     * @param float $bytes Memory size in bytes.
     * @return string
     */
    private function getHumanReadableSize($bytes) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        $bytes /= pow(1024, $factor);
        return sprintf('%.2f %s', $bytes, $units[$factor]);
    }

    /**
     * Display the current memory usage in a human-readable format.
     *
     * @return string
     */
    public function displayCurrentMemoryUsage() {
        $currentUsage = $this->getCurrentMemoryUsage();
        return $this->getHumanReadableSize($currentUsage);
    }

    /**
     * Display the peak memory usage in a human-readable format.
     *
     * @return string
     */
    public function displayPeakMemoryUsage() {
        $peakUsage = $this->getPeakMemoryUsage();
        return $this->getHumanReadableSize($peakUsage);
    }
}

// Example usage
try {
    $memoryAnalyzer = new MemoryUsageAnalyzer();
    echo "Current memory usage: " . $memoryAnalyzer->displayCurrentMemoryUsage() . "
";
    echo "Peak memory usage: " . $memoryAnalyzer->displayPeakMemoryUsage() . "
";
} catch (Exception $e) {
    // Error handling
    echo "Error: " . $e->getMessage();
}
