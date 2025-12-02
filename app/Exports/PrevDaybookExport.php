<?php

namespace App\Exports;

use App\Models\DaybookPrev;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class PrevDaybookExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'Date',
            'Expense',
            'Income',
            'Amount',
            'Accounts'
        ];
    }

    public function collection()
    {
        $daybook_prevs =  DaybookPrev::select(
            'date','expense','income','amount','accounts'
            )->get();

        return $daybook_prevs;
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:F1')->getFont()->setBold(true);
            },
        ];
    }
}
