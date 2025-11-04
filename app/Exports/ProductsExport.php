<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ProductsExport implements FromCollection, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Product Name',
            'Unit',
            'Category',
            'Description',
            'Stock',
            'Supplier',
            'Created At',
            'Updated At',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->insertNewRowBefore(1, 2);

                $sheet->setCellValue('A1', 'PT Indofood Tbk.');
                $sheet->setCellValue('A2', 'Rekap Stok Gudang');

                $sheet->mergeCells('A1:I1');
                $sheet->mergeCells('A2:I2');

                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(13);

                $sheet->getStyle('A1:A2')->getAlignment()->setHorizontal('center');
            },
        ];
    }
}
