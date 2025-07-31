<?php
// 代码生成时间: 2025-07-31 16:52:59
// 引入Phalcon框架相关的Autoload和DI组件
use Phalcon\Loader, Phalcon\DI, Phalcon\DiInterface;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\User\Component;
use Phalcon\Mvc\Model\Message as Message;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Security;

class UserAuthentication extends Plugin {

    protected $_di;
    protected $security;

    public function __construct(DI $di) {
        $this->_di = $di;
        $this->security = $di->getSecurity();
    }

    // 用户登录验证
    public function authenticate($username, $password) {
        try {
            // 从数据库获取用户信息
            $user = Users::findFirst(
                array(
                    'conditions' => 'username = :username:',
                    'bind' => array('username' => $username)
                )
            );

            if ($user) {
                // 验证密码是否正确
                if ($this->security->checkHash($password, $user->password)) {
                    // 创建会话
                    $this->security->setSession('auth', array(
                        'id' => $user->id,
                        'name' => $user->name
                    ));

                    return true;
                } else {
                    throw new Exception('Incorrect password.');
                }
            } else {
                throw new Exception('Username does not exist.');
            }
        } catch (Exception $e) {
            // 错误处理
            return new Message('error', $e->getMessage());
        }
    }

    // 用户登出
    public function logout() {
        if ($this->security->destroySession()) {
            return true;
        } else {
            return false;
        }
    }
}
