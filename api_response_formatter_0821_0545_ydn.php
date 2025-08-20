<?php
// 代码生成时间: 2025-08-21 05:45:15
class ApiResponseFormatter {

    /**
     * 格式化成功的API响应
     *
     * @param mixed $data 响应数据
     * @param string $message 响应消息
     * @return array 格式化后的响应数组
     */
    public function success($data = null, $message = 'Success') {
        return [
            'status' => 'success',
            'data' => $data,
            'message' => $message
        ];
    }

    /**
     * 格式化失败的API响应
     *
     * @param string $message 错误消息
     * @param int $code 错误码，默认为400
     * @return array 格式化后的错误响应数组
     */
    public function error($message, $code = 400) {
        return [
            'status' => 'error',
            'message' => $message,
            'code' => $code
        ];
    }
}

// 使用示例
/**
 * 使用ApiResponseFormatter类来格式化API响应
 */
$responseFormatter = new ApiResponseFormatter();

// 成功响应
$successResponse = $responseFormatter->success(['user' => 'John Doe'], 'User data retrieved successfully');

// 错误响应
$errorResponse = $responseFormatter->error('Invalid request', 400);

// 将响应转换为JSON格式
echo json_encode($successResponse);
echo "
";
echo json_encode($errorResponse);
