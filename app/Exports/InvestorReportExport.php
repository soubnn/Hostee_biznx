<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class InvestorReportExport implements FromArray, WithHeadings
{
    protected $investor;
    protected $transactions;

    // Accept Collection instead of array
    public function __construct($investor, Collection $transactions)
    {
        $this->investor = $investor;
        $this->transactions = $transactions;
    }

    public function array(): array
    {
        $data = [];

        foreach ($this->transactions as $transaction) {
            $data[] = [
                'Date'        => $transaction->date,
                'Description' => $transaction->description,
                'Accounts'    => $transaction->accounts,
                'Investment'  => $transaction->income_id == 'INVESTOR_INVESTMENT' ? $transaction->amount : '',
                'Withdrawal'  => $transaction->expense_id == 'INVESTOR_WITHDRAWAL' ? $transaction->amount : '',
            ];
        }

        return $data;
    }

    // ✅ Add the missing headings method
    public function headings(): array
    {
        return [
            'Date',
            'Description',
            'Accounts',
            'Investment',
            'Withdrawal',
        ];
    }
}
