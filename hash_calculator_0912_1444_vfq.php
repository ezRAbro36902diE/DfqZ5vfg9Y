<?php
// 代码生成时间: 2025-09-12 14:44:11
 * given strings using various algorithms.
 *
 * @package     HashCalculator
 * @author      Your Name
 * @version     1.0
 * @copyright   (c) 2023 Your Company
 */

use Phalcon\Mvc\Controller;
use Phalcon\Di;
use Phalcon\Crypt;

class HashCalculatorController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        // Initialize the DI container
        Di::getDefault()->setShared('crypt', function () {
            return new Crypt();
        });
    }

    /**
     * Calculate hash for a given string
     *
     * @param string $algorithm
     * @param string $input
     * @return string
     */
    public function calculateAction($algorithm = 'sha256', $input = '')
    {
        try {
            // Get the Crypt service from the DI container
            $crypt = $this->getDI()->getShared('crypt');

            // Calculate the hash
            $hash = $crypt->hash($input, $algorithm);

            // Return the result as JSON
            echo json_encode(['success' => true, 'hash' => $hash]);
        } catch (Exception $e) {
            // Handle errors and return an error message
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
