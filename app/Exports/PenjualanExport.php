<?php

namespace App\Exports;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use App\Models\Penjualan;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PenjualanExport implements FromQuery, WithHeadings, WithMapping, WithEvents
{
    protected $start, $end;

    public function __construct($start = null, $end = null)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function query()
    {
        $query = Penjualan::with('details');

        if ($this->start && $this->end) {
            $query->whereBetween('tanggal_penjualan', [$this->start, $this->end]);
        }

        return $query;
    }

    public function headings(): array
{
    return [
        'ID Transaksi',
        'Tanggal Penjualan',
        'Tanggal Pelunasan',
        'Nama/ID Kostumer',
        'Metode',
        'Status',
        'Total Barang',
        'Subtotal Transaksi',
        'Daftar Barang',
    ];
}
    public function map($penjualan): array
{
    $barangList = $penjualan->details->map(function ($d) {
        return $d->inventori->nama_barang . ' (x' . $d->jumlah . ')';
    })->implode(', ');

    return [
        $penjualan->transaksi_id,
        Carbon::parse($penjualan->tanggal_penjualan)->format('d-m-Y'),
        $penjualan->tanggal_pelunasan
            ? Carbon::parse($penjualan->tanggal_pelunasan)->format('d-m-Y')
            : '-',
        $penjualan->nama_kostumer,
        $penjualan->metode_pembayaran,
        $penjualan->status_pembayaran,
        $penjualan->details->count(),
        'Rp ' . number_format($penjualan->details->sum('subtotal'), 0, ',', '.'),
        $barangList,
    ];
}
    protected function sumMetode($metode)
{
    return Penjualan::with('details')
        ->where('status_pembayaran', 'PAID')
        ->where('metode_pembayaran', $metode)
        ->when($this->start && $this->end, fn($q) => $q->whereBetween('tanggal_penjualan', [$this->start, $this->end]))
        ->get()
        ->sum(fn($p) => $p->details->sum('subtotal'));
}

protected function sumStatus($status)
{
    return Penjualan::with('details')
        ->where('status_pembayaran', $status)
        ->when($this->start && $this->end, fn($q) => $q->whereBetween('tanggal_penjualan', [$this->start, $this->end]))
        ->get()
        ->sum(fn($p) => $p->details->sum('subtotal'));
}

    public function registerEvents(): array
{
    return [
        AfterSheet::class => function (AfterSheet $event) {
            $sheet = $event->sheet;
            $rowCount = $sheet->getHighestRow();

            // === HEADER STYLE ===
            $headerRange = 'A1:I1'; // Sesuaikan kolom jika menambah kolom
            $sheet->getStyle($headerRange)->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '0d6efd'] // Bootstrap .bg-primary
                ],
                'font' => [
                    'color' => ['rgb' => 'FFFFFF'],
                    'bold' => true,
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => [
                    'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                ],
            ]);

            // === STYLING UNTUK KOLOM STATUS (F, baris 2 sampai terakhir) ===
            for ($i = 2; $i <= $rowCount; $i++) {
                $status = $sheet->getCell("F{$i}")->getValue();

                if ($status === 'PAID') {
                    $sheet->getStyle("F{$i}")->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => '28a745'], // Bootstrap .bg-success
                        ],
                        'font' => [
                            'color' => ['rgb' => 'FFFFFF'],
                            'bold' => true,
                        ],
                    ]);
                } elseif ($status === 'UNPAID') {
                    $sheet->getStyle("F{$i}")->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'dc3545'], // Bootstrap .bg-danger
                        ],
                        'font' => [
                            'color' => ['rgb' => 'FFFFFF'],
                            'bold' => true,
                        ],
                    ]);
                }
            }

            // === TOTAL CARD STYLE (Grand Total PAID, UNPAID, CASH, dll) ===
            $summaryStart = $rowCount + 2;
            $summaryData = [
                ['Total CASH:', $this->sumMetode('CASH')],
                ['Total QRIS:', $this->sumMetode('QRIS')],
                ['Total TRANSFER:', $this->sumMetode('TRANSFER')],
                ['Total PAID:', $this->sumStatus('PAID')],
                ['Total UNPAID:', $this->sumStatus('UNPAID')],
            ];

            foreach ($summaryData as $i => [$label, $value]) {
                $row = $summaryStart + $i;
                $sheet->setCellValue("G{$row}", $label);
                $sheet->setCellValue("H{$row}", $value);
                $sheet->getStyle("G{$row}")->getFont()->setBold(true);
                $sheet->getStyle("H{$row}")->getNumberFormat()->setFormatCode('#,##0');
            }
        }
    ];
}

}
