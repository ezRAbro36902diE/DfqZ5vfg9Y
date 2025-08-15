<?php
// 代码生成时间: 2025-08-15 14:04:13
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelGenerator extends Controller
{

    private $spreadsheet;
    private $writer;

    public function initialize()
    {
        // Initialize the Spreadsheet and XlsxWriter
        $this->spreadsheet = new Spreadsheet();
        $this->writer = new Xlsx($this->spreadsheet);
    }

    /**
     * Generate an Excel file based on data provided
     *
     * @param array $data Data to be written to the Excel file
     * @param string $filename The name of the Excel file
     * @return void
     */
    public function generateFile(array $data, string $filename): void
    {
        try {
            // Set the active sheet
            $sheet = $this->spreadsheet->getActiveSheet();
            $sheet->setTitle('Sheet1');

            // Write data to the sheet
            $row = 1;
            foreach ($data as $rowData) {
                foreach ($rowData as $column => $value) {
                    $sheet->setCellValueByColumnAndRow($column + 1, $row, $value);
                }
                $row++;
            }

            // Save the Excel file
            $this->saveFile($filename);
        } catch (Exception $e) {
            // Handle any exceptions
            $this->flashSession->error('Error generating Excel file: ' . $e->getMessage());
        }
    }

    /**
     * Save the Excel file to disk
     *
     * @param string $filename The name of the Excel file
     * @return void
     */
    private function saveFile(string $filename): void
    {
        $path = $this->config->application->uploadDir . '/' . $filename;
        $this->writer->save($path);
        $this->flashSession->success('Excel file generated successfully.');
    }

    /**
     * Action to handle the Excel file generation request
     *
     * @return void
     */
    public function createAction()
    {
        // Example data to be written to the Excel file
        $data = [
            ['Header1', 'Header2', 'Header3'],
            ['Data1', 'Data2', 'Data3'],
            ['Data4', 'Data5', 'Data6'],
        ];

        // Generate and save the Excel file
        $this->generateFile($data, 'example.xlsx');
    }
}
