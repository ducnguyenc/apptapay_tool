<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CsvToExcelExport implements FromCollection, ShouldAutoSize
{
    public function __construct(private $path) {
    }

    public function collection()
    {
        // Here you read your CSV file and return the data as a collection
        $csvFile = fopen($this->path, 'r');
        $data = [];
        $i = 0;
        while (($row = fgetcsv($csvFile)) !== false) {
            if ($i == 0) {
                $row = array_map(function($item) {
                    return $item = str_replace('"', '', $item);
                }, $row);
            }

            // Add cleaned-up row to data
            $data[] = $row;
        }
        fclose($csvFile);

        return collect($data);
    }
}
