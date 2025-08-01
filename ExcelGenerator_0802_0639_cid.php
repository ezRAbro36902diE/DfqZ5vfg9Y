<?php
// 代码生成时间: 2025-08-02 06:39:28
 * This class provides a simple interface to generate Excel files using PHP and Phalcon framework.
 *
 * @package    ExcelGenerator
 * @copyright  (c) 2023 Your Company
 * @license    MIT License
 * @author     Your Name
 * @version    1.0
 */

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelGenerator extends Model
{

    /**
     * Generates an Excel file based on a query and saves it.
     *
     * @param string $query SQL query to fetch data
     * @param string $filename Name of the Excel file
     * @return bool
     */
    public function generateExcel(string $query, string $filename): bool
    {
        try {
            // Execute the query and get the results
            $results = $this->getDI()->get('db')->query($query)->fetchAll();
            
            // Check if results are empty
            if (empty($results)) {
                throw new Exception('No data found for the query.');
            }

            // Create a new Spreadsheet object
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Set the header row
            $headerRow = array_keys((array) $results[0]);
            $sheet->fromArray($headerRow, null, 'A1'); // Add header row with column letters
            
            // Set the data rows
            $sheet->fromArray($results, null, 'A2'); // Add data starting from row 2
            
            // Set the file name
            $writer = new Xlsx($spreadsheet);
            $writer->save($filename);
            
            return true;
        } catch (Exception $e) {
            // Log the error or handle it as needed
            error_log($e->getMessage());
            return false;
        }
    }

    // Additional methods or logic can be added here
}
