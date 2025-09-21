<?php
// 代码生成时间: 2025-09-21 16:35:31
// Hash Calculator using Phalcon Framework
// This class provides functionality to calculate hash values of strings

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;
use Phalcon\Http\ResponseInterface as HttpResponse;

class HashController extends Controller
{
    	// Function to calculate hash for a given string
    	public function calculateAction($string = ""): HttpResponse
    	{
    		try {
    			// Check if the input string is empty
    			if (empty($string)) {
    				throw new Exception("The input string cannot be empty.");
    			}

    			// Calculate hash using various algorithms
    			$hashMD5 = md5($string);
    			$hashSHA1 = sha1($string);
    			$hashSHA256 = hash('sha256', $string);

    			// Return the hash values as JSON response
    			$response = $this->response;
    			$response->setContentType('application/json', 'UTF-8');
    			$response->setJsonContent(
    				[
    				'status' => 'success',
    				'hash_md5' => $hashMD5,
    				'hash_sha1' => $hashSHA1,
    				'hash_sha256' => $hashSHA256
    				]
    			);
    			$response->send();
    		} catch (Exception $e) {
    			// Handle exceptions and return error response
    			$response = $this->response;
    			$response->setContentType('application/json', 'UTF-8');
    			$response->setJsonContent(
    				[
    				'status' => 'error',
    				'message' => $e->getMessage()
    				]
    			);
    			$response->send();
    		}
    	}
}

// Usage: $di->get('url')->setQuery(['string' => 'your_string_here']);