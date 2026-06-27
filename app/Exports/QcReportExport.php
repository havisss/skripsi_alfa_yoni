<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class QcReportExport implements FromCollection, WithHeadings, WithMapping
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
            'PO Number',
            'Client',
            'Product Code',
            'Product Name',
            'Color',
            'Qty',
            'Status',
            'Description'
        ];
    }

    public function map($row): array
    {
        return [
            $row->date,
            $row->po_number,
            $row->client,
            $row->product->code,
            $row->product->name,
            $row->color,
            $row->qty,
            $row->status,
            $row->description,
        ];
    }
}
