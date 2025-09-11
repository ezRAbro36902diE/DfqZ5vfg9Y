<?php
// 代码生成时间: 2025-09-11 21:13:12
class URLValidatorService {

    /**
     * Check if a URL is valid and active.
     *
     * @param string $url The URL to be validated.
     * @return bool Returns true if the URL is valid and active, false otherwise.
     */
    public function isValid($url) {
        // Check if the URL is empty
        if (empty($url)) {
            return false;
        }

        // Use filter_var to check if URL is in correct format
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        // Try to fetch the URL to check its effectiveness
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Check if the URL is valid and responded with a successful status code
        return $response !== false && $statusCode >= 200 && $statusCode < 400;
    }
}

/**
 * Example usage of URLValidatorService.
 */
$urlValidator = new URLValidatorService();
$testUrl = "http://example.com";
$isValid = $urlValidator->isValid($testUrl);

// Output the result
echo $isValid ? "The URL is valid and active." : "The URL is not valid or not active.";