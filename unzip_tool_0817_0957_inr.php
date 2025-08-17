<?php
// 代码生成时间: 2025-08-17 09:57:50
 * This script provides a simple interface to unzip compressed files.
 *
 * @author Your Name
 * @version 1.0
 */

use Phalcon\Mvc\Controller;
use Phalcon\Filter;
use Phalcon\FilterFactory;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\File;
use Phalcon\Validation\Validator\File\MimeType;
use Phalcon\Validation\Validator\File\Resolution;
use Phalcon\Validation\Validator\File\Size;
use Phalcon\Validation\MessageGroup;
use Phalcon\Mvc\Model\Message;
use ZipArchive;
use Phalcon\Mvc\Controller\Base;

class UnzipToolController extends Base
{
    /**
     * Index action for Unzip Tool
     *
     * @return void
     */
    public function indexAction()
    {
        $this->view->setVar('title', 'Unzip Tool');
    }

    /**
     * Unzip action
     *
     * @param string $zipFile Path to the zip file to be extracted
     * @param string $destination Destination directory for extracted files
     * @return void
     */
    public function unzipAction($zipFile, $destination)
    {
        try {
            // Check if the zip file exists
            if (!file_exists($zipFile)) {
                $this->flash->error('Zip file not found.');
                return $this->dispatcher->forward(['controller' => 'UnzipTool', 'action' => 'index']);
            }

            // Check if the destination directory exists
            if (!is_dir($destination) && !mkdir($destination, 0777, true)) {
                $this->flash->error('Failed to create destination directory.');
                return $this->dispatcher->forward(['controller' => 'UnzipTool', 'action' => 'index']);
            }

            // Create a new ZipArchive object
            $zip = new ZipArchive();

            // Open the zip file
            if ($zip->open($zipFile) === true) {
                // Extract the zip file to the destination directory
                if ($zip->extractTo($destination) === false) {
                    $this->flash->error('Failed to extract zip file.');
                } else {
                    $this->flash->success('Zip file extracted successfully.');
                }

                // Close the zip file
                $zip->close();
            } else {
                $this->flash->error('Failed to open zip file.');
            }

            return $this->dispatcher->forward(['controller' => 'UnzipTool', 'action' => 'index']);
        } catch (Exception $e) {
            $this->flash->error('Error: ' . $e->getMessage());
            return $this->dispatcher->forward(['controller' => 'UnzipTool', 'action' => 'index']);
        }
    }
}
