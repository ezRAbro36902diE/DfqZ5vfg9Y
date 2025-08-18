<?php
// 代码生成时间: 2025-08-18 12:32:10
// 文件夹结构整理器
// 使用PHALCON框架开发

class FolderStructureOrganizer {

    private $folderPath;
    private $targetStructure;
    private $config;

    // 构造函数
    public function __construct($folderPath, $config) {
        $this->folderPath = $folderPath;
        $this->config = $config;
        // 定义目标文件夹结构
        $this->targetStructure = $this->getConfig('targetStructure', []);
    }

    // 获取配置项
    private function getConfig($key, $default = null) {
        return isset($this->config[$key]) ? $this->config[$key] : $default;
    }

    // 开始整理文件夹结构
    public function organize() {
        try {
            // 检查文件夹路径是否存在
            if (!is_dir($this->folderPath)) {
                throw new \Exception("Folder path does not exist: {$this->folderPath}");
            }

            // 遍历目标文件夹结构
            foreach ($this->targetStructure as $dir) {
                // 创建目录
                $this->createDirectory($dir);
            }

            // 删除多余的文件夹
            $this->removeExtraFolders();

            return 'Folder structure organized successfully.';

        } catch (\Exception $e) {
            // 错误处理
            return "Error: {$e->getMessage()}";
        }
    }

    // 创建目录
    private function createDirectory($dirPath) {
        $fullPath = $this->folderPath . DIRECTORY_SEPARATOR . $dirPath;

        if (!is_dir($fullPath)) {
            // 创建目录
            mkdir($fullPath, 0777, true);
        }
    }

    // 删除多余的文件夹
    private function removeExtraFolders() {
        // 获取目标文件夹结构
        $targetFolders = array_map(function($dir) {
            return $this->folderPath . DIRECTORY_SEPARATOR . $dir;
        }, $this->targetStructure);

        // 获取当前目录下的所有文件夹
        $allFolders = glob($this->folderPath . DIRECTORY_SEPARATOR . "*", GLOB_ONLYDIR);

        foreach ($allFolders as $folder) {
            // 检查是否为目标文件夹
            if (!in_array($folder, $targetFolders)) {
                // 删除多余的文件夹
                $this->deleteDirectory($folder);
            }
        }
    }

    // 删除目录
    private function deleteDirectory($dirPath) {
        // 检查目录是否为空
        if ($this->isEmptyDirectory($dirPath)) {
            // 删除目录
            rmdir($dirPath);
        } else {
            // 递归删除目录
            $this->deleteDirectoryRecursive($dirPath);
        }
    }

    // 递归删除目录
    private function deleteDirectoryRecursive($dirPath) {
        // 获取目录下的所有文件和子目录
        $files = glob($dirPath . DIRECTORY_SEPARATOR . '*', GLOB_MARK|GLOB_NOSORT);

        foreach ($files as $file) {
            // 如果是目录，则递归删除
            if (is_dir($file)) {
                $this->deleteDirectoryRecursive($file);
            } else {
                // 删除文件
                unlink($file);
            }
        }

        // 删除目录
        rmdir($dirPath);
    }

    // 检查目录是否为空
    private function isEmptyDirectory($dirPath) {
        // 获取目录下的所有文件和子目录
        $files = glob($dirPath . DIRECTORY_SEPARATOR . '*', GLOB_MARK|GLOB_NOSORT);

        return count($files) == 0;
    }
}

// 配置示例
$config = [
    'targetStructure' => ['dir1', 'dir2', 'dir3'],
];

// 使用示例
$organizer = new FolderStructureOrganizer('/path/to/folder', $config);
$result = $organizer->organize();
echo $result;
