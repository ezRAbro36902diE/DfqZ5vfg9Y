<?php
// 代码生成时间: 2025-08-26 12:05:50
 * This class is responsible for organizing the folder structure by moving files into corresponding subfolders.
 *
 * @package FolderOrganizer
 * @author Your Name
 * @version 1.0
 */
class FolderStructureOrganizer {

    /**
     * The source directory to organize files from.
     *
     * @var string
     */
    private $sourceDirectory;

    /**
     * The destination directory where files will be organized.
     *
     * @var string
     */
    private $destinationDirectory;

    /**
     * Constructor for the FolderStructureOrganizer class.
     *
     * @param string $sourceDirectory The source directory to organize files from.
     * @param string $destinationDirectory The destination directory where files will be organized.
     */
    public function __construct($sourceDirectory, $destinationDirectory) {
        $this->sourceDirectory = $sourceDirectory;
        $this->destinationDirectory = $destinationDirectory;
    }

    /**
     * Organize the files in the source directory by moving them into corresponding subfolders.
     *
     * @return bool True on success, false on failure.
     */
    public function organizeFiles() {
        try {
            if (!is_dir($this->sourceDirectory)) {
                throw new Exception("Source directory does not exist.");
            }

            if (!is_dir($this->destinationDirectory)) {
                if (!mkdir($this->destinationDirectory, 0777, true)) {
                    throw new Exception("Failed to create destination directory.");
                }
            }

            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($this->sourceDirectory, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $name => $file) {
                if (!$file->isDir()) {
                    $relativePath = $this->getRelativePath($this->sourceDirectory, $file->getPath());
                    $destinationPath = $this->destinationDirectory . DIRECTORY_SEPARATOR . $relativePath;

                    if (!is_dir($destinationPath)) {
                        if (!mkdir($destinationPath, 0777, true)) {
                            throw new Exception("Failed to create subdirectory: $destinationPath");
                        }
                    }

                    if (!rename($file->getPathname(), $destinationPath . DIRECTORY_SEPARATOR . $file->getFilename())) {
                        throw new Exception("Failed to move file: {$file->getPathname()}");
                    }
                }
            }

            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Get the relative path of a file from the source directory.
     *
     * @param string $sourceDir The source directory.
     * @param string $fileDir The directory of the file.
     * @return string The relative path.
     */
    private function getRelativePath($sourceDir, $fileDir) {
        $sourceDir = rtrim($sourceDir, DIRECTORY_SEPARATOR);
        $fileDir = rtrim($fileDir, DIRECTORY_SEPARATOR);

        $sourceDirArray = explode(DIRECTORY_SEPARATOR, $sourceDir);
        $fileDirArray = explode(DIRECTORY_SEPARATOR, $fileDir);

        $relativePathArray = array();
        foreach ($fileDirArray as $i => $dir) {
            if (isset($sourceDirArray[$i]) && $sourceDirArray[$i] === $dir) {
                $relativePathArray[] = $dir;
            } else {
                break;
            }
        }

        return implode(DIRECTORY_SEPARATOR, array_slice($relativePathArray, count($sourceDirArray)));
    }
}

// Example usage:
try {
    $organizer = new FolderStructureOrganizer("/path/to/source", "/path/to/destination");
    if ($organizer->organizeFiles()) {
        echo "Files have been organized successfully.
";
    } else {
        echo "Failed to organize files.
";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "
";
}
