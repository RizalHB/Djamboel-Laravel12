<?php

namespace App\Exports;

use App\Models\Inventori;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class InventoriExport implements FromCollection, WithMapping, WithHeadings, WithEvents
{
    protected $start, $end;
    protected $total = 0; // untuk total sisa barang

    public function __construct($start = null, $end = null)
    {
        $this->start = $start;
        $this->end = $end;
    }

    protected $data;

    public function collection()
    {
        $query = Inventori::with('supplier');

        if ($this->start && $this->end) {
            $query->whereBetween('tanggal_pembelian', [$this->start, $this->end]);
        }

        $this->data = $query->get();

        // Hitung total: stok x harga beli
        $this->total = $this->data->sum(function ($item) {
            return $item->amount * $item->price_per_unit;
        });

        return $this->data;
    }

    public function headings(): array
    {
        return [
            'ID Barang',
            'Nama Barang',
            'Unit',
            'Stok',
            'Supplier',
            'Harga Beli/Unit',
            'Harga Jual',
            'Tanggal Pembelian',
        ];
    }

    public function map($item): array
    {
        return [
            $item->kode_barang,
            $item->nama_barang,
            $item->unit,
            number_format($item->amount, 2),
            $item->supplier->nama ?? '-',
            'Rp ' . number_format($item->price_per_unit, 0, ',', '.'),
            'Rp ' . number_format($item->harga_jual, 0, ',', '.'),
            \Carbon\Carbon::parse($item->tanggal_pembelian)->translatedFormat('d F Y'),
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Styling header
                $event->sheet->getStyle('A1:H1')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '0d6efd']],
                ]);

                // Hitung baris total akan ditulis di baris setelah data
                $rowCount = count($this->data) + 2;

                // Label total
                $event->sheet->setCellValue("A{$rowCount}", 'Total Biaya Barang Pembelian:');

                // Nilai total
                $event->sheet->setCellValue("B{$rowCount}", 'Rp ' . number_format($this->total, 0, ',', '.'));

                // Styling total
                $event->sheet->getStyle("A{$rowCount}:B{$rowCount}")->applyFromArray([
                    'font' => ['bold' => true],
                ]);
            },
        ];
    }
}
