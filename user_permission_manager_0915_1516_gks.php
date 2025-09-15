<?php
// 代码生成时间: 2025-09-15 15:16:48
// UserPermissionManager.php
// 定义一个用户权限管理系统的类

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;
use Phalcon\Mvc\Model\Resultset;

class UserPermissionManager extends Model
{
    // UserPermission 表的主键
    public $id;
    // 用户ID
    public $userId;
    // 权限ID
    public $permissionId;

    // 初始化方法，设置表名
    public function initialize()
    {
        $this->setSource('user_permissions');
    }

    // 添加用户的权限
    public function addUserPermission($userId, $permissionId)
    {
        try {
            // 检查用户ID和权限ID是否有效
            if (!is_int($userId) || !is_int($permissionId)) {
                throw new Exception('Invalid user or permission ID');
            }

            // 创建新的用户权限记录
            $this->userId = $userId;
            $this->permissionId = $permissionId;

            // 保存记录
            if (!$this->save()) {
                // 处理保存失败的情况
                $messages = $this->getMessages();
                foreach ($messages as $message) {
                    throw new Exception($message->getMessage());
                }
            }

            return true;
        } catch (Exception $e) {
            // 错误处理
            error_log($e->getMessage());
            return false;
        }
    }

    // 删除用户的权限
    public function removeUserPermission($userId, $permissionId)
    {
        try {
            // 检查用户ID和权限ID是否有效
            if (!is_int($userId) || !is_int($permissionId)) {
                throw new Exception('Invalid user or permission ID');
            }

            // 找到要删除的用户权限记录
            $userPermission = UserPermissionManager::findFirst([
                'conditions' => 'userId = :userId: AND permissionId = :permissionId:',
                'bind' => [
                    'userId' => $userId,
                    'permissionId' => $permissionId
                ]
            ]);

            // 如果记录存在，则删除
            if ($userPermission) {
                $userPermission->delete();
            }

            return true;
        } catch (Exception $e) {
            // 错误处理
            error_log($e->getMessage());
            return false;
        }
    }

    // 检查用户是否有特定权限
    public function checkUserPermission($userId, $permissionId)
    {
        try {
            // 检查用户ID和权限ID是否有效
            if (!is_int($userId) || !is_int($permissionId)) {
                throw new Exception('Invalid user or permission ID');
            }

            // 查找用户权限记录
            $userPermission = UserPermissionManager::findFirst([
                'conditions' => 'userId = :userId: AND permissionId = :permissionId:',
                'bind' => [
                    'userId' => $userId,
                    'permissionId' => $permissionId
                ]
            ]);

            // 如果记录存在，返回 true，否则返回 false
            return $userPermission ? true : false;

        } catch (Exception $e) {
            // 错误处理
            error_log($e->getMessage());
            return false;
        }
    }

    // 获取用户的所有权限
    public function getUserPermissions($userId)
    {
        try {
            // 检查用户ID是否有效
            if (!is_int($userId)) {
                throw new Exception('Invalid user ID');
            }

            // 查找用户的所有权限记录
            $permissions = UserPermissionManager::find([
                'conditions' => 'userId = :userId:',
                'bind' => [
                    'userId' => $userId
                ]
            ]);

            return $permissions;

        } catch (Exception $e) {
            // 错误处理
            error_log($e->getMessage());
            return null;
        }
    }
}
