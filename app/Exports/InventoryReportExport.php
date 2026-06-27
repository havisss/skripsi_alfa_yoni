<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InventoryReportExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Date',
            'Product Code',
            'Product Name',
            'Type',
            'Qty',
            'Beginning Stock',
            'Ending Stock',
            'Description'
        ];
    }

    public function map($row): array
    {
        return [
            $row->created_at->format('Y-m-d H:i:s'),
            $row->product->code,
            $row->product->name,
            $row->type,
            $row->qty,
            $row->stock_before,
            $row->stock_after,
            $row->description,
        ];
    }
}
