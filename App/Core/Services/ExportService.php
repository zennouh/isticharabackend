<?php

namespace App\Core\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;

class ExportService
{
    private Spreadsheet $spreadsheet;
    private Worksheet $sheet;

    public function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
        $this->sheet =  $this->spreadsheet->getActiveSheet();
    }

    public function export(array $data, array $header)
    {
        $col = 'A';
        foreach ($header as $h) {
            $this->sheet->setCellValue($col . '1', $h);
            $col++;
        }

        $row = 2;
        foreach ($data as $record) {
            $col = 'A';
            foreach ($record as $value) {
                $this->sheet->setCellValue($col . $row, $value);
                $col++;
            }
            $row++;
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="users.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new WriterXlsx($this->spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
