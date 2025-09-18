<?php
// 代码生成时间: 2025-09-19 05:16:17
// 加载Phalcon Autoloader
require __DIR__ . '/../vendor/autoload.php';

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Model\Message;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Db\Column;
use Phalcon\Mvc\Model\Resultset\Simple as ResultsetSimple;
use Phalcon\Mvc\Model\Resultset\Cached as ResultsetCached;
use Phalcon\Mvc\Model\Resultset;

class AuthController extends Controller
{
    /**
     * 登录方法
     *
     * @return mixed
     */
    public function loginAction()
    {
        $this->view->disable();

        // 获取请求数据
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (empty($email) || empty($password)) {
            $this->response->setStatusCode(400, 'Bad Request')->sendHeaders();
            return json_encode(['status' => 'error', 'message' => 'Email and password are required']);
        }

        // 验证邮箱
        $validation = new Validation();
        $validation->add('email', new PresenceOf(['message' => 'Email is required']));
        $validation->add('email', new Email(['message' => 'Email is not valid']));

        // 验证结果
        $messages = $validation->validate($this->request->getPost());
        if (count($messages)) {
            $this->response->setStatusCode(400, 'Bad Request')->sendHeaders();
            return json_encode(['status' => 'error', 'message' => $messages->getMessages()]);
        }

        // 验证密码
        $validation->add('password', new PresenceOf(['message' => 'Password is required']));
        $messages = $validation->validate($this->request->getPost());
        if (count($messages)) {
            $this->response->setStatusCode(400, 'Bad Request')->sendHeaders();
            return json_encode(['status' => 'error', 'message' => $messages->getMessages()]);
        }

        // 查询数据库
        $user = Users::findFirstByEmail($email);
        if (!$user) {
            $this->response->setStatusCode(404, 'Not Found')->sendHeaders();
            return json_encode(['status' => 'error', 'message' => 'User not found']);
        }

        // 验证密码
        if (!$this->security->checkHash($password, $user->password)) {
            $this->response->setStatusCode(401, 'Unauthorized')->sendHeaders();
            return json_encode(['status' => 'error', 'message' => 'Invalid password']);
        }

        // 创建会话
        $session = $this->session->start();
        $session->set('auth', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ]);

        // 设置响应
        $this->response->setStatusCode(200, 'OK')->sendHeaders();
        return json_encode(['status' => 'success', 'message' => 'Logged in successfully']);
    }
}
