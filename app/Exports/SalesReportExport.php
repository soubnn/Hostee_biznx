<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesReportExport implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $tableData;

    public function __construct(array $tableData)
    {
        $this->tableData = $tableData;
    }

    public function array(): array
    {
        return $this->tableData;
    }

    public function headings(): array
    {
        return [
            'Invoice #',
            'Date',
            'B2C/B2B',
            'GSTIN/TIN',
            'Customer',
            'Place',
            'Product',
            'Hsn Code',
            'In Price',
            'Unit Price',
            'Qty',
            'Taxable',
            'Tax',
            'CGST',
            'SGST',
            'IGST',
            'CESS',
            'Total'
        ];
    }
}
