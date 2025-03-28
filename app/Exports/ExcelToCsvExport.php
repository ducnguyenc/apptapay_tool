<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Facades\Excel;

class ExcelToCsvExport implements FromCollection, ShouldAutoSize
{
    protected $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function collection()
    {
        // Load the Excel file and convert it to a collection
        $data = Excel::toCollection(null, $this->file);
        return $data[0];  // Get the first sheet data
    }
}
