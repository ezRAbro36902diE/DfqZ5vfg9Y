<?php
// 代码生成时间: 2025-09-23 15:25:21
// 用户登录验证系统
// 使用Phalcon框架实现

use Phalcon\Mvc\Model\Message as Message;
use Phalcon\Mvc\Model\MessageBag;
use Phalcon\Mvc\Controller;
use Phalcon\Di;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class AuthController extends Controller
{
    // 用户登录方法
    public function loginAction()
    {
        if ($this->request->isPost()) {
            // 获取用户输入
            $email = $this->request->getPost('email', 'email');
            $password = $this->request->getPost('password', 'string');

            // 创建验证器
            $validation = new Validation();

            // 验证电子邮箱
            $validation->add('email', new Email(array(
                'message' => '请输入有效的电子邮箱地址'
            )));

            // 验证密码存在
            $validation->add('password', new PresenceOf(array(
                'message' => '密码不能为空'
            )));

            // 验证密码长度
            $validation->add('password', new StringLength(array(
                'min' => 8,
                'messageMinimum' => '密码至少需要8个字符'
            )));

            // 执行验证
            $messages = $validation->validate($this->request->getPost());

            // 检查是否有验证错误
            if (count($messages)) {
                // 将错误信息存储到消息袋中
                $this->flashSession->error($messages->getMessages());

                // 重定向回登录页面
                return $this->dispatcher->forward(array(
                    'controller' => 'auth',
                    'action' => 'login'
                ));
            }

            // 验证通过，执行登录操作
            $user = Users::findFirst(
                array(
                    'email = :email: AND password = :password:',
                    'bind' => array(
                        'email' => $email,
                        'password' => sha1($password)
                    )
                )
            );

            if ($user) {
                // 用户认证成功，设置会话
                $this->session->set('auth', array(
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email
                ));

                // 重定向到首页
                return $this->response->redirect('index/index');
            } else {
                // 用户认证失败，显示错误信息
                $this->flashSession->error('用户名或密码错误');
            }
        }
    }

    // 用户注销方法
    public function logoutAction()
    {
        // 销毁会话
        $this->session->remove('auth');

        // 重定向回登录页面
        return $this->response->redirect('auth/login');
    }
}
