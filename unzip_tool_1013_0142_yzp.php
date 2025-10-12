<?php
// 代码生成时间: 2025-10-13 01:42:26
// UnzipTool.php
// 使用Phalcon框架实现的压缩文件解压工具

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;
use Phalcon\Http\ResponseInterface;
use Phalcon\Filter;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\File;
use Phalcon\Validation\Validator\StringLength;
use ZipArchive;
use Phalcon\Flash\Session as FlashSession;

class UnzipToolController extends Controller
{
    public function indexAction()
    {
        // 设置视图
        $this->view->setVar('form', $this->request->getPost());
    }

    public function extractAction()
    {
        // 获取表单数据
        $file = $this->request->getUploadedFiles()[0];
        $destination = $this->request->getPost('destination', 'string');

        // 文件验证
        $validation = new Validation();
        $validation->add(
            'file',
            new File(['maxSize' => '2097152', 'message' => '文件大小不能超过2MB'])
        );
        $validation->add(
            'file',
            new PresenceOf(['message' => '必须上传文件'])
        );
        $validation->add(
            'destination',
            new PresenceOf(['message' => '必须指定解压目录'])
        );
        $validation->add(
            'destination',
            new StringLength(
                [
                    'max' => 255,
                    'messageMax' => '目录名不能超过255个字符'
                ]
            )
        );

        $messages = $validation->validate($this->request->getPost());
        if (count($messages)) {
            $flash = new FlashSession(['error' => 'Validation failed']);
            foreach ($messages as $message) {
                $flash->error($message->getMessage());
            }
            return $this->response->redirect('unzip_tool/index');
        }

        // 尝试解压文件
        try {
            $zip = new ZipArchive();
            if ($zip->open($file->getTempName()) === true) {
                $zip->extractTo($destination);
                $zip->close();
                $this->flashSession->success('文件解压成功');
            } else {
                throw new Exception('无法打开文件或文件不是有效的ZIP格式');
            }
        } catch (Exception $e) {
            $this->flashSession->error($e->getMessage());
            return $this->response->redirect('unzip_tool/index');
        }

        return $this->response->redirect('unzip_tool/index');
    }
}
