<?php
// 代码生成时间: 2025-09-02 14:03:36
class ApiResponseFormatter
{
    /**
     * Format a successful API response
     *
     * @param array $data The data to be returned in the response
     * @param string $message Optional message to include in the response
     * @return array
     */
    public function success(array $data, string $message = 'Operation successful'): array
    {
        return [
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ];
    }

    /**
     * Format an API response for an error
     *
     * @param string $message The error message to include in the response
     * @param int $code The HTTP status code for the error
     * @return array
     */
    public function error(string $message, int $code = 400): array
    {
        return [
            'status' => 'error',
            'message' => $message,
            'code' => $code
        ];
    }

    /**
     * Handle validation errors and format them into an API response
     *
     * @param array $errors An array of validation errors
     * @param int $code The HTTP status code for the error
     * @return array
     */
    public function validationError(array $errors, int $code = 422): array
    {
        return $this->error("Validation errors: " . implode(', ', $errors), $code);
    }
}
