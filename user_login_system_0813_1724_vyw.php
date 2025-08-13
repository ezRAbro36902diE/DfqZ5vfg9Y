<?php
// 代码生成时间: 2025-08-13 17:24:05
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Model\Message;
use Phalcon\Mvc\Model\Exception;
use Phalcon\Session\Adapter\Files as Session;
use Phalcon\Di;
use Phalcon\Validation;
use Phalcon\Validation\Validation\Message\ValidationMessage;
use Phalcon\Mvc\Model;

class AuthController extends Controller
{
    // 定义构造函数
    public function initialize()
    {
        $this->view->setTemplateAfter('index');
        $this->session = Di::getDefault()->getShared('session');
    }

    // 用户登录方法
    public function loginAction()
    {
        if ($this->request->isPost()) {
            try {
                // 验证表单数据
                $messages = [];
                $username = $this->request->getPost('username', 'string');
                $password = $this->request->getPost('password', 'string');

                if (empty($username) || empty($password)) {
                    $messages[] = new Message('Username or password cannot be empty');
                } else {
                    // 验证用户凭据
                    $user = Users::findFirstByusername($username);
                    if ($user) {
                        if (password_verify($password, $user->password)) {
                            $this->session->start();
                            $this->session->set('auth', true);
                            $this->session->set('username', $user->username);
                            return $this->response->redirect('dashboard');
                        } else {
                            $messages[] = new Message('Invalid password');
                        }
                    } else {
                        $messages[] = new Message('User not found');
                    }
                }

                // 设置错误消息
                if (!empty($messages)) {
                    $this->flashSession->error('Login failed: ' . implode(' | ', $messages));
                }
            } catch (Exception $e) {
                $this->flashSession->error($e->getMessage());
            }
        }
    }

    // 用户登出方法
    public function logoutAction()
    {
        $this->session->destroy();
        return $this->response->redirect('auth/login');
    }
}
