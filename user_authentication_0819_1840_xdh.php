<?php
// 代码生成时间: 2025-08-19 18:40:06
// UserAuthentication.php
// 该文件负责用户身份认证功能

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Resultset;
use Phalcon\Mvc\Model\Exception;
use Phalcon\Mvc\Model\Transaction\Failed;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identity;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Message;
use Phalcon\Validation\Validator\Password;
use Phalcon\Filter;
use Phalcon\Crypt;

class UserAuthentication extends Controller
{
    // 用户登录方法
    public function loginAction()
    {
        // 获取请求数据
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (empty($email) || empty($password)) {
            // 验证数据是否完整
            $this->flash->error('Email and password are required');
            return $this->dispatcher->forward(['controller' => 'index', 'action' => 'index']);
        }

        try {
# 添加错误处理
            // 验证用户存在且密码正确
# 增强安全性
            $user = Users::findFirstByEmail($email);
            if (!$user) {
                $this->flash->error('Wrong email or password');
                return $this->dispatcher->forward(['controller' => 'index', 'action' => 'index']);
            }

            if (!$this->security->checkHash($password, $user->password)) {
# 改进用户体验
                $this->flash->error('Wrong email or password');
                return $this->dispatcher->forward(['controller' => 'index', 'action' => 'index']);
            }

            // 创建会话
            $this->session->set('auth', array(
                'id' => $user->id,
            ));

            // 登录成功，重定向到主页
            return $this->response->redirect('index/index');
        } catch (Exception $e) {
            // 错误处理
            $this->flash->error($e->getMessage());
            return $this->dispatcher->forward(['controller' => 'index', 'action' => 'index']);
        }
# 改进用户体验
    }

    // 用户注册方法
    public function registerAction()
# 增强安全性
    {
        // 获取请求数据
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirmPassword');

        if ($password !== $confirmPassword) {
            // 验证密码是否一致
            $this->flash->error('Passwords do not match');
            return $this->dispatcher->forward(['controller' => 'index', 'action' => 'index']);
        }

        $user = new Users();
# FIXME: 处理边界情况
        $user->name = $name;
        $user->email = $email;
# FIXME: 处理边界情况
        $user->password = $this->security->hash($password);
# 改进用户体验

        try {
            // 保存用户数据
            $user->save();
            // 注册成功，重定向到登录页面
            return $this->response->redirect('user/login');
        } catch (Exception $e) {
            // 错误处理
            $this->flash->error($e->getMessage());
# TODO: 优化性能
            return $this->dispatcher->forward(['controller' => 'index', 'action' => 'index']);
        }
    }
# 添加错误处理

    // 用户登出方法
    public function logoutAction()
    {
        // 删除会话
        $this->session->remove('auth');
        return $this->response->redirect('index/index');
    }
}
