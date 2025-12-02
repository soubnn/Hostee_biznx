<?php

namespace App\Exports;

use App\Models\Seller;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SellerReportExport implements FromCollection, WithHeadings
{
    protected $seller_datas;
    protected $seller_name;
    protected $startDate;
    protected $endDate;

    public function __construct($seller_datas, $seller_name, $startDate, $endDate)
    {
        $this->seller_datas = $seller_datas;
        $this->seller_name = $seller_name;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return collect($this->seller_datas);
    }

    public function headings(): array
    {
        return [
            'Date', 'Invoice Number', 'Debit', 'Credit', 'Balance'
        ];
    }
}
