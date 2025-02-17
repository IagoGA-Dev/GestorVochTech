<?php

namespace App\Traits;

use League\Csv\Writer;
use SplTempFileObject;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

trait WithExport
{
    abstract public function getExportData(): array;
    abstract public function getExportHeaders(): array;
    abstract public function getExportFilename(): string;

    public function exportCsv(): StreamedResponse
    {
        $csv = Writer::createFromFileObject(new SplTempFileObject());
        
        // Headers
        $csv->insertOne($this->getExportHeaders());

        // Data
        foreach ($this->getExportData() as $row) {
            $csv->insertOne($row);
        }

        return response()->streamDownload(function() use ($csv) {
            echo $csv->toString();
        }, $this->getExportFilename() . '.csv');
    }

    public function exportXlsx(): StreamedResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Headers
        $headers = $this->getExportHeaders();
        foreach (array_values($headers) as $i => $header) {
            $sheet->setCellValue(chr(65 + $i) . '1', $header);
        }

        // Data
        $row = 2;
        foreach ($this->getExportData() as $dataRow) {
            foreach (array_values($dataRow) as $i => $value) {
                $sheet->setCellValue(chr(65 + $i) . $row, $value);
            }
            $row++;
        }

        // Auto size columns
        foreach (range('A', chr(64 + count($headers))) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        
        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $this->getExportFilename() . '.xlsx');
    }
}
