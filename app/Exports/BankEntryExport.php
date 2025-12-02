<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BankEntryExport implements FromView
{
    protected $bank, $transactions, $investSum, $withdrawSum, $netAmount, $openingBalance, $startDate, $endDate;

    public function __construct($bank, $transactions, $investSum, $withdrawSum, $netAmount, $openingBalance, $startDate, $endDate)
    {
        $this->bank = $bank;
        $this->transactions = $transactions;
        $this->investSum = $investSum;
        $this->withdrawSum = $withdrawSum;
        $this->netAmount = $netAmount;
        $this->openingBalance = $openingBalance;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        return view('bank.entry_report_excel', [
            'bank' => $this->bank,
            'transactions' => $this->transactions,
            'investSum' => $this->investSum,
            'withdrawSum' => $this->withdrawSum,
            'netAmount' => $this->netAmount,
            'openingBalance' => $this->openingBalance,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate
        ]);
    }
}
