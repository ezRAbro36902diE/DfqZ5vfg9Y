<?php
// 代码生成时间: 2025-08-07 09:46:00
// ImageSizeRescaler.php
// 这个类用于批量调整图片尺寸

use Phalcon\Image\Adapter\GD;
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\Application;

class ImageSizeRescaler extends Application
{

    public function onConstruct()
    {
        // 设置自动加载器
        $loader = new Loader();
        $loader->registerNamespaces(
            array(
                'ImageSizeRescaler' => __DIR__ . '/models/',
            )
        );
        $loader->register();
    }

    public function adjustImageSizes($sourceDirectory, $targetDirectory, $newWidth, $newHeight)
    {
        // 检查源目录是否存在
        if (!is_dir($sourceDirectory)) {
            throw new \Exception("源目录不存在: {$sourceDirectory}");
        }

        // 获取源目录中的所有图片文件
        $files = scandir($sourceDirectory);
        foreach ($files as $file) {
            if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) {
                $sourcePath = $sourceDirectory . '/' . $file;
                $targetPath = $targetDirectory . '/' . $file;

                // 创建图片对象
                $image = new GD($sourcePath);

                // 调整图片尺寸
                $image->resize($newWidth, $newHeight);

                // 保存调整后的图片
                $image->save($targetPath);
            }
        }
    }
}

// 假设我们有一个命令行脚本来执行这个类
if (php_sapi_name() == 'cli') {
    try {
        $rescaler = new ImageSizeRescaler($di);
        $rescaler->adjustImageSizes(
            __DIR__ . '/images/source/',
            __DIR__ . '/images/resized/',
            800, // 新宽度
            600  // 新高度
        );
        echo "图片尺寸调整完成\
";
    } catch (Exception $e) {
        echo "错误: ",  $e->getMessage(), "\
";
    }
}
