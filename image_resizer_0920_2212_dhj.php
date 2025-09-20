<?php
// 代码生成时间: 2025-09-20 22:12:38
use Phalcon\Mvc\Controller;
use Phalcon\Tag;
use Phalcon\Filter;
use Phalcon\Config;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Version;
use Phalcon\Version\Version;
use Intervention\Image\ImageManager;
use Intervention\Image\Exception\ImageException;

class ImageResizerController extends Controller
{
    /**
     * Resize multiple images
     *
     * @param array $sourceFiles Path of source images
     * @param array $targetSizes Target dimensions for each image
     * @param array $targetFiles Path of target images
     * @return bool
     */
    public function resizeAction(array $sourceFiles, array $targetSizes, array $targetFiles)
    {
        // Initialize the image manager
        $imageManager = new ImageManager();
        
        // Check if all arrays have the same length
        if (count($sourceFiles) !== count($targetSizes) || count($sourceFiles) !== count($targetFiles)) {
            $this->logError('Mismatched arrays length');
            return false;
        }
        
        foreach ($sourceFiles as $index => $sourceFile) {
            try {
                // Open an image file
                $image = $imageManager->make($sourceFile);
                
                // Get target dimensions
                $width = $targetSizes[$index]['width'] ?? null;
                $height = $targetSizes[$index]['height'] ?? null;
                
                // Resize the image
                $image->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                
                // Save the resized image
                $image->save($targetFiles[$index]);
                
                $this->logInfo("Image resized and saved: {$targetFiles[$index]}");
            } catch (ImageException $e) {
                $this->logError("Failed to resize image: {$sourceFile}. Error: {$e->getMessage()}");
                return false;
            } catch (\Exception $e) {
                $this->logError("Unexpected error: {$e->getMessage()}");
                return false;
            }
        }
        return true;
    }

    /**
     * Log information or error messages
     *
     * @param string $message Message to log
     * @param bool $error Log as error if true
     */
    private function logInfo($message)
    {
        $this->log($message, false);
    }

    private function logError($message)
    {
        $this->log($message, true);
    }

    /**
     * Generic log function
     *
     * @param string $message Message to log
     * @param bool $error Log as error if true
     */
    private function log($message, $error)
    {
        $logger = new FileLogger('app/logs/resize_log.txt');
        if ($error) {
            $logger->error($message);
        } else {
            $logger->info($message);
        }
    }
}
