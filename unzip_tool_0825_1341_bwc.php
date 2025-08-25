<?php
// 代码生成时间: 2025-08-25 13:41:26
use Phalcon\Mvc\Controller;
use Phalcon\Filter;
use Phalcon\Paginator\Adapter\Model as Paginator;
use ZipArchive;

/**
 * UnzipTool Controller
 *
 * @property Filter $filter
 */
class UnzipToolController extends Controller
{
    public function indexAction()
    {
        // Display the form to select a file
    }

    public function uploadAction()
    {
        if ($this->request->isPost()) {
            $file = $this->request->getUploadedFiles()[0];
            if ($file->getError() == UPLOAD_ERR_OK) {
                $targetPath = "uploads/" . $file->getName();
                $file->moveTo($targetPath);
                
                try {
                    $this->unzipFile($targetPath);
                    $this->alert("File has been successfully unzipped.");
                } catch (Exception $e) {
                    $this->alert($e->getMessage());
                }
            } else {
                $this->alert("Error uploading file.");
            }
        }
    }

    private function unzipFile($filePath)
    {
        $zip = new ZipArchive;
        $res = $zip->open($filePath);
        if ($res === TRUE) {
            $outputDir = pathinfo($filePath, PATHINFO_DIRNAME) . "/" . pathinfo($filePath, PATHINFO_FILENAME);
            $zip->extractTo($outputDir);
            $zip->close();
            
            // Delete the zip file after extraction
            unlink($filePath);
        } else {
            throw new Exception("Failed to open the zip file.");
        }
    }

    private function alert($message)
    {
        $this->flashSession->error($message);
        return $this->response->redirect("unzip-tool");
    }
}
