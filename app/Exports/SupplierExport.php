<?php

namespace App\Exports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class SupplierExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    public function collection()
    {
        return Supplier::all(); // Ambil semua tanpa pagination & filter
    }

    public function headings(): array
    {
        return [
            'ID Supplier',
            'Nama',
            'Alamat',
            'No Telepon',
            'No Rekening',
            'Email',
        ];
    }

    public function map($supplier): array
    {
        return [
            $supplier->id_supplier,
            $supplier->nama,
            $supplier->alamat,
            $supplier->no_telepon ?? '-',
            $supplier->no_rekening ?? '-',
            $supplier->email ?? '-',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('A1:F1')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '0d6efd']], // Bootstrap Primary
                ]);
            },
        ];
    }
}
