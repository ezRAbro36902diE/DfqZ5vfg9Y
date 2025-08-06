<?php
// 代码生成时间: 2025-08-06 11:10:32
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\User\Component;
use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Di;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View;
use Phalcon\Events\Event;
use Phalcon\Events\EventsAwareInterface;
use Phalcon\Mvc\ControllerBase;
use Phalcon\Mvc\Model\Exception;
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\View\Exception as ViewException;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\ControllerInterface;
use Phalcon\Mvc\ModelInterface;

class AccessControl extends Component implements EventsAwareInterface
{
    // Events
    protected $eventsManager;
    
    // ACL
    protected $acl;
    
    // Roles
    protected $roles;
    
    // Resources
    protected $resources;
    
    public function initialize()
    {
        // Set up the ACL
        $this->acl = new Acl();
        
        // Define roles
        $this->roles = [
            new Role('Guest'),
            new Role('Member'),
            new Role('Admin')
        ];
        
        // Define resources
        $this->resources = [
            new Resource('Index'),
            new Resource('Users'),
            new Resource('Products')
        ];
        
        // Add roles to the ACL
        foreach ($this->roles as $role) {
            $this->acl->addRole($role);
        }
        
        // Add resources to the ACL
        foreach ($this->resources as $resource) {
            $this->acl->addResource($resource, 'index');
        }
        
        // Define access rules
        $this->acl->allow('Guest', 'Index', 'index');
        $this->acl->allow('Member', 'Users', 'index');
        $this->acl->allow('Admin', 'Products', 'index');
        
        // Attach the ACL to the DI container for later use
        Di::getDefault()->set('acl', $this->acl);
    }
    
    public function checkAccess($roleName, $resourceName, $actionName)
    {
        // Check if the role exists
        if (!$this->acl->isRole($roleName)) {
            throw new Exception("Role '{$roleName}' does not exist.");
        }
        
        // Check if the resource exists
        if (!$this->acl->isResource($resourceName)) {
            throw new Exception("Resource '{$resourceName}' does not exist.");
        }
        
        // Check access
        return $this->acl->isAllowed($roleName, $resourceName, $actionName);
    }
    
    // EventsAwareInterface implementation
    public function setEventsManager($eventsManager)
    {
        $this->eventsManager = $eventsManager;
    }
    
    public function getEventsManager()
    {
        return $this->eventsManager;
    }
}
