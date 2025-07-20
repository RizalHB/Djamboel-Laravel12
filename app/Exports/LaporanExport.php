<?php

namespace App\Exports;

use App\Models\Penjualan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $start, $end;

    protected $totals = [
        'cash' => 0,
        'qris' => 0,
        'transfer' => 0,
        'total' => 0,
    ];

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function collection()
    {
        $query = Penjualan::where('status_pembayaran', 'PAID')
            ->whereBetween('tanggal_penjualan', [$this->start, $this->end])
            ->get()
            ->groupBy('tanggal_penjualan')
            ->map(function ($items, $tanggal) {
                $cash = $items->where('metode_pembayaran', 'CASH')->sum('total_harga');
                $qris = $items->where('metode_pembayaran', 'QRIS')->sum('total_harga');
                $transfer = $items->where('metode_pembayaran', 'TRANSFER')->sum('total_harga');
                $total = $cash + $qris + $transfer;

                $this->totals['cash'] += $cash;
                $this->totals['qris'] += $qris;
                $this->totals['transfer'] += $transfer;
                $this->totals['total'] += $total;

                return [
                    'tanggal' => $tanggal,
                    'cash' => $cash,
                    'qris' => $qris,
                    'transfer' => $transfer,
                    'total' => $total,
                ];
            })->values();

        return $query;
    }

    public function headings(): array
    {
        return ['Tanggal', 'Cash', 'QRIS', 'TRANSFER', 'Total Pendapatan'];
    }

    public function map($row): array
    {
        return [
            $row['tanggal'],
            'Rp ' . number_format($row['cash'], 0, ',', '.'),
            'Rp ' . number_format($row['qris'], 0, ',', '.'),
            'Rp ' . number_format($row['transfer'], 0, ',', '.'),
            'Rp ' . number_format($row['total'], 0, ',', '.'),
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $rowCount = count($event->sheet->getDelegate()->toArray()) + 1;

                // Tambahkan baris total di bawah data
                $event->sheet->append([
                    '',
                    'Total Cash: Rp ' . number_format($this->totals['cash'], 0, ',', '.'),
                    'Total QRIS: Rp ' . number_format($this->totals['qris'], 0, ',', '.'),
                    'Total Transfer: Rp ' . number_format($this->totals['transfer'], 0, ',', '.'),
                    'Total Pendapatan: Rp ' . number_format($this->totals['total'], 0, ',', '.'),
                ]);

                // Header style
                $event->sheet->getStyle('A1:E1')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '0d6efd']],
                ]);

                // Total baris style
                $event->sheet->getStyle("A{$rowCount}:E{$rowCount}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'E2E3E5']],
                ]);
            },
        ];
    }
}
