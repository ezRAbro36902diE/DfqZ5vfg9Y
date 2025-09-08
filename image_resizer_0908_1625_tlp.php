<?php
// 代码生成时间: 2025-09-08 16:25:20
// Image Resizer using PHP and Phalcon Framework
// This script is designed to resize images in a batch manner

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset;
use Phalcon\Mvc\Model\Resultset\Simple;
use Phalcon\Mvc\View;
use Phalcon\Image\Adapter\Gd as ImageGd;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\File as FileLogger;

class ImageResizer extends Model
{
    public function batchResizeImages($sourcePath, $targetPath, $newWidth, $newHeight)
    {
        // Initialize logger
        $logger = new FileLogger('/path/to/resize_logs.txt');

        // Check if source and target paths are valid
        if (!is_dir($sourcePath) || !is_dir($targetPath)) {
            $logger->error('Invalid source or target path');
            return false;
        }

        // Get all images from the source directory
        $images = $this->getImagesFromDirectory($sourcePath);

        $resizeCount = 0;

        foreach ($images as $image) {
            try {
                // Attempt to resize the image
                if ($this->resizeImage($image, $targetPath, $newWidth, $newHeight)) {
                    $resizeCount++;
                }
            } catch (Exception $e) {
                // Log any exceptions that occur during resizing
                $logger->error('Error resizing image ' . $image . ': ' . $e->getMessage());
            }
        }

        // Log the number of successfully resized images
        $logger->info('Successfully resized ' . $resizeCount . ' images');

        return true;
    }

    private function getImagesFromDirectory($directory)
    {
        $images = [];
        $iterator = new DirectoryIterator($directory);
        foreach ($iterator as $fileinfo) {
            if ($fileinfo->isFile() && in_array($fileinfo->getExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
                $images[] = $fileinfo->getPathname();
            }
        }
        return $images;
    }

    private function resizeImage($imagePath, $targetPath, $newWidth, $newHeight)
    {
        // Create a new image adapter instance
        $image = new ImageGd($imagePath);

        // Resize the image
        $image->resize($newWidth, $newHeight);

        // Save the resized image to the target path
        $targetFile = $targetPath . '/' . basename($imagePath);
        $image->save($targetFile);

        return true;
    }
}

// Example usage:
// $resizer = new ImageResizer();
// $resizer->batchResizeImages('/path/to/source', '/path/to/target', 800, 600);
