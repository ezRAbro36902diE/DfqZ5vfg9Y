<?php
// 代码生成时间: 2025-08-24 20:11:28
use Phalcon\Escaper;
use Phalcon\Filter;
use Phalcon\Mvc\Controller;

/**
 * XSS防护控制器
 *
 * 提供XSS攻击防护功能
 */
class XssProtectionController extends Controller
{
    /**
     * Escaper服务
     *
     * @var Escaper
     */
    private $escaper;

    /**
     * 构造函数
     *
     * @param Escaper $escaper
     */
    public function __construct(Escaper $escaper)
    {
        $this->escaper = $escaper;
    }

    /**
     * 获取用户输入并进行XSS过滤
     *
     * @param string $input 用户输入
     * @return string 过滤后的输出
     */
    public function filterInput($input)
    {
        /**
         * 使用Phalcon的Filter服务进行XSS过滤
         *
         * @var Filter $filter
         */
        $filter = $this->getDI()->get('filter');

        // 使用strip_tags移除HTML标签
        $filter->add('strip_tags', function($input) {
            return strip_tags($input);
        });

        // 使用htmlspecialchars转换特殊字符
        $filter->add('htmlspecialchars', function($input) {
            return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        });

        // 应用过滤器
        $output = $filter->sanitize($input, 'strip_tags');
        $output = $filter->sanitize($output, 'htmlspecialchars');

        return $output;
    }

    /**
     * 测试XSS过滤功能
     */
    public function testAction()
    {
        try {
            // 获取用户输入
            $userInput = $this->request->getPost('input', 'strip_tags');

            // 进行XSS过滤
            $filteredOutput = $this->filterInput($userInput);

            // 输出过滤后的结果
            $this->response->setContent($filteredOutput);

        } catch (\Exception $e) {
            // 错误处理
            $this->response->setContent('Error: ' . $e->getMessage());
        }
    }
}
