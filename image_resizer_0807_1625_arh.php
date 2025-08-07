<?php
// 代码生成时间: 2025-08-07 16:25:32
// Image Resizer using PHP and Phalcon Framework

use Phalcon\Mvc\Controller;
use Phalcon\Di\FactoryDefault;
use Phalcon\Di;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Assets\Manager as AssetsManager;
use Phalcon\Escaper;
use Phalcon\Filter;
use Phalcon\Paginator\Adapter\QueryBuilder;
use Phalcon\Events\Manager as EventsManager;

class ImageResizerController extends Controller
{
    private $sourcePath;
    private $targetPath;
    private $targetWidth;
    private $targetHeight;
    private $quality;
    private $extension;
    private $imageType;
    private $sourceImage;
    private $targetImage;
    private $errorMsg;

    public function onConstruct()
    {
        $this->sourcePath = 'path/to/source/images';
        $this->targetPath = 'path/to/target/images';
        $this->targetWidth = 800;
        $this->targetHeight = 600;
        $this->quality = 90;
        $this->extension = 'jpg';
        $this->imageType = IMAGETYPE_JPEG;
    }

    public function indexAction()
    {
        // Load images from source path
        $images = glob($this->sourcePath . '/*.' . $this->extension);

        foreach ($images as $image) {
            try {
                $this->sourceImage = imagecreatefromstring(file_get_contents($image));
                $this->targetImage = imagecreatetruecolor($this->targetWidth, $this->targetHeight);

                // Resize the image
                imagecopyresampled(
                    $this->targetImage,
                    $this->sourceImage,
                    0, 0,
                    0, 0,
                    $this->targetWidth,
                    $this->targetHeight,
                    imagesx($this->sourceImage),
                    imagesy($this->sourceImage)
                );

                // Save the resized image to the target path
                imagejpeg($this->targetImage, $this->targetPath . '/' . basename($image), $this->quality);
            } catch (Exception $e) {
                $this->errorMsg = 'Error resizing image: ' . $e->getMessage();
            }
        }
    }

    public function errorAction($message)
    {
        $this->view->setVar('message', $message);
    }
}
