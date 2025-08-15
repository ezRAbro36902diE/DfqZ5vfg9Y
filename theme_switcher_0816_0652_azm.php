<?php
// 代码生成时间: 2025-08-16 06:52:15
// ThemeSwitcher.php
// 该类用于实现主题切换功能

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;
use Phalcon\Session\Adapter\Files as Session;

class ThemeSwitcher extends Controller
{
    // 存储当前主题的会话变量
    private $session;

    // 构造函数
    public function __construct()
    {
        // 初始化会话变量
        $this->session = new Session();
    }

    // 切换主题的方法
    public function switchThemeAction($theme = 'default')
    {
        try {
            // 设置当前主题到会话
            $this->session->set('theme', $theme);
            
            // 设置视图的选项
            $this->view->setTheme($theme);
        } catch (\Exception $e) {
            // 错误处理
            $this->flash->error('Error switching theme: ' . $e->getMessage());
        }
    }

    // 保存当前主题到会话
    public function setThemeAction()
    {
        try {
            // 从GET参数获取主题名称
            $theme = $this->request->getQuery('theme', 'string');
            
            // 调用切换主题的方法
            $this->switchThemeAction($theme);
        } catch (\Exception $e) {
            // 错误处理
            $this->flash->error('Error setting theme: ' . $e->getMessage());
        }
    }
}
