<?php
// 代码生成时间: 2025-08-04 07:10:30
 * @return void
 */
class UnzipTool {

    private $filePath;
    private $destinationDirectory;

    public function __construct($filePath, $destinationDirectory) {
        $this->filePath = $filePath;
        $this->destinationDirectory = $destinationDirectory;
    }

    /**
     * Unzips the file to the specified directory
     *
     * @return bool
     */
    public function unzip() {
        try {
            if (!file_exists($this->filePath)) {
                throw new Exception('File does not exist.');
            }

            if (!is_dir($this->destinationDirectory)) {
                mkdir($this->destinationDirectory, 0777, true);
            }

            $zip = new ZipArchive();
            if ($zip->open($this->filePath) === TRUE) {
                $zip->extractTo($this->destinationDirectory);
                $zip->close();
                return true;
            } else {
                throw new Exception('Failed to open the zip file.');
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}

// Usage example
// $unzipTool = new UnzipTool('/path/to/archive.zip', '/path/to/destination');
// $result = $unzipTool->unzip();
// if ($result) {
//     echo 'Unzipping successful.';
// } else {
//     echo 'Failed to unzip.';
// }