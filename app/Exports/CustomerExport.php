<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $combinedData;

    public function __construct(array $combinedData)
    {
        $this->combinedData = $combinedData;
    }
    public function array(): array
    {
        return $this->combinedData;
    }

    public function headings(): array
    {
        return [
            'Date',
            'Invoice #',
            'Debit',
            'Credit',
            'Balance'
        ];
    }
}
