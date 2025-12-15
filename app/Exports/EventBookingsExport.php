<?php

namespace App\Exports;

use App\Models\EventBooking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventBookingsExport implements FromCollection, WithHeadings
{
    protected $event_id;

    public function __construct($event_id)
    {
        $this->event_id = $event_id;
    }

    public function collection()
    {
        return EventBooking::where('event_id', $this->event_id)
            ->select('name', 'place', 'whatsapp_no', 'phone')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Place',
            'Whatsapp No',
            'Phone'
        ];
    }
}
