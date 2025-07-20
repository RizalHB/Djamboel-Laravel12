<?php

namespace App\Exports;

use App\Models\Kostumer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class KostumerExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    public function collection()
    {
        return Kostumer::all(); // Ambil SEMUA data, tidak paginate!
    }

    public function headings(): array
    {
        return [
            'ID Kostumer',
            'Nama Kostumer',
            'No Telepon',
            'Alamat',
            'Tanggal Ditambahkan',
        ];
    }

    public function map($kostumer): array
    {
        return [
            $kostumer->kode_kostumer,
            $kostumer->nama,
            $kostumer->no_telepon ?? '-',
            $kostumer->alamat ?? '-',
            $kostumer->created_at->translatedFormat('d F Y'),
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('A1:E1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['rgb' => '0d6efd'], // Bootstrap Primary
                    ],
                ]);
            },
        ];
    }
}
