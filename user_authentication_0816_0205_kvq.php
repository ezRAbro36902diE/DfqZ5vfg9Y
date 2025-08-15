<?php
// 代码生成时间: 2025-08-16 02:05:55
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset;
use Phalcon\Mvc\Model\Resultset\Simple;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Flash\Session as Flash;

class AuthController extends Controller
{
    private $authService;
    private $flash;

    public function initialize()
    {
        $this->authService = new UserService();
        $this->flash = new Flash();
    }

    public function loginAction()
    {
        if ($this->request->isPost()) {
            $login = $this->request->getPost();

            $validation = new Validation();
            $validation->add('username', new PresenceOf(array(
                'message' => 'Username is required'
            )));
            $validation->add('email', new Email(array(
                'message' => 'Email is not valid'
            )));
            $validation->add('password', new PresenceOf(array(
                'message' => 'Password is required'
            )));
            $validation->add('password', new StringLength(array(
                'min' => 8,
                'messageMinimum' => 'Password is too short. Minimum 8 characters'
            )));
            $validation->add('password', new Identical(array(
                'value' => $login['password'],
                'message' => 'Password does not match'
            )));

            $messages = $validation->validate($login);
            if (count($messages)) {
                foreach ($messages as $message) {
                    $this->flash->error($message);
                }
            } else {
                $user = $this->authService->authenticate($login['username'], $login['password']);
                if ($user) {
                    $this->session->start();
                    $this->session->set('auth', $user);
                    $this->flash->success('You have been successfully logged in');
                    return $this->response->redirect('index/index');
                } else {
                    $this->flash->error('Invalid credentials');
                }
            }
        }
    }

    public function logoutAction()
    {
        $this->session->destroy();
        $this->flash->success('You have been successfully logged out');
        return $this->response->redirect('auth/login');
    }
}

/**
 * User Service
 *
 * This service handles user authentication logic.
 */
class UserService
{
    public function authenticate($username, $password)
    {
        // Check if user exists and password is correct
        // This should be replaced with actual database query
        // For demonstration, it returns a mock user
        $user = array(
            'id' => 1,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        );

        if (isset($user) && $this->checkPassword($password, $user['password'])) {
            return $user;
        }
        return null;
    }

    private function checkPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}
