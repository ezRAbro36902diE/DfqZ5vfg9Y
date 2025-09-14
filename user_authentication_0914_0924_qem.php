<?php
// 代码生成时间: 2025-09-14 09:24:55
use Phalcon\Mvc\Model;
use Phalcon\Mvc\User\Component;
use Phalcon\Mvc\View;
use Phalcon\Di;
use Phalcon\Security;
use Phalcon\Mvc\Url;
use Phalcon\Flash\Direct;

class UserAuthentication extends Component
{
    // 依赖注入容器
    protected $di;

    // 安全组件
    protected $security;

    // 视图组件
    protected $view;

    // 构造函数
    public function __construct(Di $di)
    {
        $this->di = $di;
        $this->security = $this->di->getSecurity();
        $this->view = $this->di->get('view');
        $this->view->setTemplateBefore('private');
    }

    // 用户身份验证方法
    public function authenticate($username, $password)
    {
        try {
            // 从数据库中检查用户凭证
            $user = Users::findFirst([
                'columns' => 'id, username, password',
                'conditions' => "username = :username: AND active = 1",
                'bind' => ['username' => $username]
            ]);

            if (!$user) {
                $this->flashSession->error('Username does not exist');
                return false;
            }

            // 验证密码
            if (!$this->security->checkHash($password, $user->password)) {
                $this->flashSession->error('Password is incorrect');
                return false;
            }

            // 创建会话
            $this->security->setIdentity($user->id);
            $this->security->getSession()->setName('user');
            $token = $this->security->getToken();
            $this->security->getSession()->start();
            $this->security->getSession()->set($token . 'Identity', $user->id);

            // 设置闪存消息
            $this->flashSession->success('You are now signed in');

            return true;
        } catch (Exception $e) {
            // 错误处理
            $this->flashSession->error($e->getMessage());
            return false;
        }
    }

    // 用户登出方法
    public function logout()
    {
        $this->security->destroyToken();
        $this->flashSession->success('You are now signed out');
    }
}
