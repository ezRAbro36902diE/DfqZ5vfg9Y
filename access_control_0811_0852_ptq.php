<?php
// 代码生成时间: 2025-08-11 08:52:58
// 引入Phalcon框架的核心类
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Di;
use Phalcon\Mvc\Url;
use Phalcon\Events\EventsAwareInterface;
use Phalcon\Mvc\View;
use Phalcon\Security;
use Phalcon\Filter;
use Phalcon\Dispatcher;
use Phalcon\Mvc\ControllerBase;
use Phalcon\Mvc\Model\Message;
use Phalcon\Mvc\Model\MessageInterface;
use Phalcon\Mvc\Model\Resultset;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Transaction\Failed;
use Phalcon\Mvc\Model\Transaction;
use Phalcon\Db;
use Phalcon\Config;

// 访问权限控制类
class AccessControl extends ControllerBase
{
    protected $acl;
    protected $security;
    protected $dispatcher;
    protected $url;

    public function onConstruct()
    {
        // 初始化Acl
        $this->acl = new AclList();
        $this->acl->setDefaultAction(Acl::DENY);

        // 添加角色
        $this->acl->addRole(new Role('Guests'));
        $this->acl->addRole(new Role('Members'));
        $this->acl->addRole(new Role('Admins'));

        // 添加资源
        $this->acl->addResource(new Resource('Index'), 'index');
        $this->acl->addResource(new Resource('Users'), 'index, create');
        $this->acl->addResource(new Resource('Posts'), 'index, create, edit, delete');

        // 设置访问规则
        $this->acl->allow('Guests', 'Index', 'index');
        $this->acl->allow('Members', 'Users', 'index');
        $this->acl->allow('Admins', 'Posts', '*');

        // 初始化安全组件
        $this->security = new Security();
        $this->security->setWorkFactor(12);

        // 初始化URL组件
        $this->url = new Url();

        // 初始化Dispatcher组件
        $this->dispatcher = Di::getDefault()->getShared('dispatcher');
    }

    public function beforeExecuteRoute()
    {
        // 获取当前访问的资源和动作
        $controllerName = $this->dispatcher->getControllerName();
        $actionName = $this->dispatcher->getActionName();

        // 检查是否允许访问
        $allowed = $this->acl->isAllowed($this->auth()->getRole(), $controllerName, $actionName);

        if (!$allowed) {
            // 重定向到登录页面
            $this->response->redirect('index/login');
            return false;
        }
    }

    protected function auth()
    {
        // 获取当前登录的用户
        $session = Di::getDefault()->getShared('session');
        if ($session->has('user')) {
            return $session->get('user')->role;
        } else {
            return 'Guests';
        }
    }
}
