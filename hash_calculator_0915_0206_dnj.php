<?php
// 代码生成时间: 2025-09-15 02:06:12
 * This tool provides a simple interface to calculate hash values for a given input.
 *
 * @package HashCalculator
 * @author Your Name
 * @version 1.0
 */

use Phalcon\Mvc\Controller;
use Phalcon\Crypt;

class HashCalculatorController extends Controller
{
    private $crypt;

    public function initialize()
    {
        // Initialize the Crypt service
        $this->crypt = new Crypt();
        $this->crypt->setKey("your_secret_key"); // Replace with your secret key
    }

    /**
     * Calculate hash for a given input
     *

     * @param string $input The input string to be hashed

     * @return string The calculated hash value

     */
    public function calculateAction($input)
    {
        try {
            // Check if input is empty
            if (empty($input)) {
                return $this->response->setJsonContent(["error" => "Input cannot be empty."]);
            }

            // Calculate hash using Phalcon's Crypt service
            $hash = $this->crypt->hash($input);

            // Return the calculated hash as JSON
            return $this->response->setJsonContent(["hash" => $hash]);
        } catch (Exception $e) {
            // Handle any exceptions and return an error message
            return $this->response->setJsonContent(["error" => $e->getMessage()]);
        }
    }
}
