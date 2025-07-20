<?php

namespace App\Exports;

use App\Models\Pengeluaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PengeluaranExport implements FromCollection, WithMapping, WithHeadings, WithEvents
{
    protected $start, $end;

    public function __construct($start = null, $end = null)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function collection()
    {
        $query = Pengeluaran::query();

        if ($this->start && $this->end) {
            $query->whereBetween('tanggal_pengeluaran', [$this->start, $this->end]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            ['Laporan Pengeluaran'], // Judul tabel
            [
                'ID',
                'Nama Pengeluaran',
                'Tanggal',
                'Kuantitas',
                'Harga Satuan',
                'Total'
            ],
        ];
    }

    public function map($pengeluaran): array
{
    return [
        $pengeluaran->id,
        $pengeluaran->nama_pengeluaran,
        $pengeluaran->tanggal_pengeluaran
            ? \Carbon\Carbon::parse($pengeluaran->tanggal_pengeluaran)->format('d-m-Y')
            : '-', 
        $pengeluaran->kuantitas,
        $pengeluaran->harga_satuan, 
        $pengeluaran->kuantitas * $pengeluaran->harga_satuan, 
    ];
}
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;

                // Bold Judul
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                ]);

                // Header style
                $sheet->getStyle('A2:F2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['rgb' => '0d6efd'],
                    ],
                ]);

                // Hitung total
                $lastRow = $sheet->getHighestRow() + 1;
                $sheet->setCellValue("E{$lastRow}", "TOTAL KESELURUHAN:");
                $sheet->getStyle("E{$lastRow}")->getFont()->setBold(true);

                $totalRange = "F3:F" . ($lastRow - 1);
                $sheet->setCellValue("F{$lastRow}", "=SUM({$totalRange})");
                $sheet->getStyle("F{$lastRow}")->getFont()->setBold(true);
            }
        ];
    }
}
