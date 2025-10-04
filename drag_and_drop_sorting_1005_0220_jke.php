<?php
// 代码生成时间: 2025-10-05 02:20:23
use Phalcon\Mvc\Controller;

class DragAndDropController extends Controller
{
    /**
     * 初始化组件
     */
    public function initialize()
    {
        // 这里可以进行组件初始化设置
    }

    /**
     * 获取拖拽排序的数据
     */
    public function getDataAction()
    {
        try {
            // 假设我们有一个模型来处理数据
            $items = Items::find();
            $this->response->setJsonContent($items->toArray());
            $this->response->send();
        } catch (Exception $e) {
            $this->response->setJsonContent(['error' => $e->getMessage()]);
            $this->response->send();
        }
    }

    /**
     * 保存拖拽排序后的数据
     */
    public function saveOrderAction()
    {
        try {
            // 获取排序后的数据
            $newOrder = $this->request->getJsonRawBody();
            if (!is_array($newOrder)) {
                throw new Exception('Invalid data received');
            }

            foreach ($newOrder as $index => $itemId) {
                $item = Items::findFirstById($itemId);
                if (!$item) {
                    throw new Exception('Item not found');
                }
                $item->position = $index;
                $item->save();
            }

            $this->response->setJsonContent(['success' => 'Order saved successfully']);
            $this->response->send();
        } catch (Exception $e) {
            $this->response->setJsonContent(['error' => $e->getMessage()]);
            $this->response->send();
        }
    }
}

/**
 * 假设的Items模型，用于处理拖拽排序的数据
 */
class Items extends \Phalcon\Mvc\Model
{
    public $id;
    public $name;
    public $position;
    // 模型的其他属性和方法
}
