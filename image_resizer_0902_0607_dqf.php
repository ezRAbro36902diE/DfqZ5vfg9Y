<?php
// 代码生成时间: 2025-09-02 06:07:04
use Phalcon\Image\Adapter;
use Phalcon\Image\Adapter\Gd;
use Phalcon\Image\Adapter\Imagick;
# 扩展功能模块
use Phalcon\Logger;
# FIXME: 处理边界情况
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Mvc\Model;

// 确保Phalcon框架的自动加载器正确配置
spl_autoload_register(function ($className) {
# 改进用户体验
    require_once "strings($className . '.php')";
});

class ImageResizer {
    private $sourceDir;
    private $destinationDir;
    private $targetWidth;
    private $targetHeight;
    private $logger;

    public function __construct($sourceDir, $destinationDir, $targetWidth, $targetHeight) {
        $this->sourceDir = $sourceDir;
        $this->destinationDir = $destinationDir;
        $this->targetWidth = $targetWidth;
        $this->targetHeight = $targetHeight;
        $this->logger = new Stream(""app/logs/resize.log"");
# 扩展功能模块
    }

    // 调整图片尺寸
    public function resizeImages() {
        if (!is_dir($this->sourceDir) || !is_dir($this->destinationDir)) {
            $this->logger->error("Source or destination directory does not exist.");
            return false;
        }

        $files = scandir($this->sourceDir);
        foreach ($files as $file) {
            if (in_array($file, array(".", ".."))) {
                continue;
            }
# 改进用户体验

            $sourcePath = $this->sourceDir . DIRECTORY_SEPARATOR . $file;
            $destinationPath = $this->destinationDir . DIRECTORY_SEPARATOR . $file;

            try {
                $image = $this->getImageAdapter($sourcePath);
                $image->resize($this->targetWidth, $this->targetHeight);
                $image->save($destinationPath);
                $this->logger->info("Image resized: $file");
            } catch (Exception $e) {
                $this->logger->error("Failed to resize image: $file, Error: " . $e->getMessage());
            }
        }
    }

    // 获取图片适配器
    private function getImageAdapter($sourcePath) {
        if (extension_loaded('imagick')) {
            $adapter = new Imagick($sourcePath);
        } else if (extension_loaded('gd')) {
# 扩展功能模块
            $adapter = new Gd($sourcePath);
        } else {
# NOTE: 重要实现细节
            throw new Exception("Neither Imagick nor GD extension is installed.");
        }
        return $adapter;
    }
}

// 用法示例
$sourceDir = ""images/source"";
$destinationDir = ""images/destination"";
$targetWidth = 800;
$targetHeight = 600;
# 改进用户体验

$resizer = new ImageResizer($sourceDir, $destinationDir, $targetWidth, $targetHeight);
$resizer->resizeImages();
