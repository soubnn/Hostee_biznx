<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\DirectSales;
use App\Models\Daybook;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class CreditCustomerExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'Name',
            'Mobile',
            'Place',
            'Balance'
        ];
    }
    public function collection()
    {
        $all_customers = Customer::all();
        $customers_array = array();
    
        foreach ($all_customers as $all_customer) {
            $sales = DirectSales::where('customer_id', $all_customer->id)->where('print_status', '<>', 'cancelled')->get();
            $sales_balance = 0;
        
            foreach ($sales as $sale) {
                if ($sale->discount) {
                    $amount = ((float)$sale->grand_total) - ((float)$sale->discount);
                } else {
                    $amount = (float)$sale->grand_total;
                }
            
                $paidAmount = Daybook::where('job', $sale->invoice_number)->where('type', 'Income')->sum('amount');
                $balance = $amount - $paidAmount;
                $sales_balance = round($sales_balance + $balance, 2);
            }
        
            if($sales_balance > 0){
                $customers_array[] = [
                    'Name' => $all_customer->name,
                    'Mobile' => $all_customer->mobile,
                    'Place' => $all_customer->place,
                    'Balance' => $sales_balance
                ];
            }
        }
    
        $customers = collect($customers_array);
        return $customers;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:E1')->getFont()->setBold(true);
            },
        ];
    }
}
