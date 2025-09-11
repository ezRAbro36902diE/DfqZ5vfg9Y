<?php
// 代码生成时间: 2025-09-11 17:19:43
use Phalcon\Mvc\Controller;
use Phalcon\Filter;
use Phalcon\Flash\Direct;
use Phalcon\Mvc\Model\Message;
use Phalcon\Image\Adapter\Imagick;
use Phalcon\Image\Adapter\GD;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\File as LoggerFile;

class ImageResizerController extends Controller
{
    private $sourceDirectory;
    private $targetDirectory;
    private $outputDirectory;
    private $logger;
    private $resizePercentage = 50; // Default resize percentage
    private $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    public function onConstruct()
    {
        $this->sourceDirectory = $this->config->image_resizer->source_directory;
        $this->targetDirectory = $this->config->image_resizer->target_directory;
        $this->outputDirectory = $this->config->image_resizer->output_directory;
        $this->logger = new LoggerFile($this->config->application->logsDir . 'image_resizer.log');
    }

    public function indexAction()
    {
        $this->view->setVar('sourceDirectory', $this->sourceDirectory);
        $this->view->setVar('targetDirectory', $this->targetDirectory);
        $this->view->setVar('outputDirectory', $this->outputDirectory);
    }

    public function resizeAction()
    {
        if ($this->request->isPost()) {
            $sourcePath = $this->request->getPost('source_path', 'string');
            $targetPath = $this->request->getPost('target_path', 'string');
            $outputPath = $this->request->getPost('output_path', 'string');
            $resizePercentage = $this->request->getPost('resize_percentage', 'int');

            if (!$this->validatePaths($sourcePath, $targetPath, $outputPath)) {
                $this->flash->error('Invalid paths provided.');
                return;
            }

            if (!$this->resizePercentage) {
                $this->flash->error('Invalid resize percentage.');
                return;
            }

            try {
                $this->resizeImages($sourcePath, $targetPath, $outputPath, $resizePercentage);
                $this->flash->success('Images resized successfully.');
            } catch (Exception $e) {
                $this->logger->error($e->getMessage());
                $this->flash->error('Error resizing images: ' . $e->getMessage());
            }
        }
    }

    private function validatePaths($sourcePath, $targetPath, $outputPath)
    {
        return file_exists($sourcePath) && file_exists($targetPath) && is_writable($outputPath);
    }

    private function resizeImages($sourcePath, $targetPath, $outputPath, $resizePercentage)
    {
        $files = scandir($sourcePath);
        foreach ($files as $file) {
            $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
            if (in_array($fileExtension, $this->allowedExtensions)) {
                $sourceFile = $sourcePath . '/' . $file;
                $targetFile = $targetPath . '/' . $file;
                $outputFile = $outputPath . '/' . $file;

                $this->resizeImage($sourceFile, $targetFile, $outputFile, $resizePercentage);
            }
        }
    }

    private function resizeImage($sourceFile, $targetFile, $outputFile, $resizePercentage)
    {
        $adapter = new Imagick();
        $adapter->setResource($sourceFile);
        $adapter->resize($adapter->getWidth() * ($resizePercentage / 100), $adapter->getHeight() * ($resizePercentage / 100));
        $adapter->save($outputFile);
    }
}
