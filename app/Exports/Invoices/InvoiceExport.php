<?php

namespace App\Exports\Invoices;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InvoiceExport implements FromArray, WithStrictNullComparison, WithHeadings, ShouldAutoSize
{
    protected $items;

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function array(): array
    {
    	$result = [];

    	foreach ($this->items as $item) {
    		$result[] = [
                '#' => $item['id'],
                'Reference Code' => $item['reference_code'],
                'Main Contact Person' => $item['main_contact'],
                'Email' => $item['email'],
                'Contact #' => $item['contact_number'],
                'Emergency Contact #' => $item['emergency_contact_number'],
                'Destination' => $item['destination'],
                '# of Guests' => $item['total_guest'],
                'Experience' => $item['allocation'],
                'Schedule' => $item['scheduled_at'],
                'Payment Method' => $item['payment_method'],
                'Conservation Fee' => $item['conservation_fee'],
                'Platform Fee' => $item['platform_fee'],
                'Transaction Fee' => $item['transaction_fee'],
                'Sub Total' => $item['sub_total'],
                'Initial Payment' => $item['amount_settled'],
                'Succeeding Payment' => $item['balance'],
                'Total' => $item['grand_total'],
                'Payment Type' => $item['payment_type'],
                'Is Approved' => $item['is_approved'],
                'Payment Status' => $item['is_paid'],
                'Reservation' => $item['reservation_from'],
                'Created Date' => $item['created_at'],
                'Rejected Date' => $item['deleted_at'],
            ];
    	}

        return $result;
    }

    public function headings(): array
    {
        return [
            '#',
            'Reference Code',
            'Main Contact Person',
            'Email',
            'Contact #',
            'Emergency Contact #',
            'Destination',
            '# of Guests',
            'Experience',
            'Schedule',
            'Payment Method',
            'Conservation Fee',
            'Platform Fee',
            'Transaction Fee',
            'Sub Total',
            'Initial Payment',
            'Succeeding Payment',
            'Total',
            'Payment Type',
            'Is Approved',
            'Payment Status',
            'Reservation',
            'Created Date',
            'Rejected Date',
        ];
    }
}
