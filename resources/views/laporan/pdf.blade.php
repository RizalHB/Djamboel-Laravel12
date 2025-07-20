<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Analisis Bisnis</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { display: flex; align-items: center; }
        .logo { width: 60px; height: auto; margin-right: 15px; }
        .company-info {
            font-size: 12px;
            color: #000;
        }
        .company-info h2 {
            margin: 0;
            color: #e60000;
            font-size: 16px;
        }
        .line {
            border-top: 2px solid #000;
            margin: 10px 0 20px 0;
        }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        .no-border td {
            border: none;
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <img src="{{ public_path('logo/LogoDAP-removebg-preview.png') }}" class="logo" alt="Logo">
        <div class="company-info">
            <h2>D'jamboel Ayam Potong</h2>
            <p>
                Bumi Wanamuk Blok H3 No 33/35 RT 08 RW 04 Kelurahan Sambiroto Kecamatan Tembalang Kodya Semarang<br>
                Kode Pos 50276
            </p>
        </div>
    </div>

    <div class="line"></div>

    <h3 class="text-center">Laporan Analisis Bisnis {{ \Carbon\Carbon::parse($awal)->format('d-m-Y') }} sd {{ \Carbon\Carbon::parse($akhir)->format('d-m-Y') }}</h3>

    {{-- TABEL UTAMA --}}
    <table>
        <tr>
            <th>Total Penjualan</th>
            <td>Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Stok Tersisa</th>
            <td>Rp {{ number_format($remainingStock, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Total Pembelian</th>
            <td>Rp {{ number_format($totalPembelian, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Biaya Operasional</th>
            <td>Rp {{ number_format($operationalCost, 0, ',', '.') }}</td>
        </tr>
    </table>

    {{-- TOTAL PENGHASILAN --}}
    <table>
        <tr>
            <th style="width: 50%">Gross Income</th>
            <td>Rp {{ number_format($grossIncome, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Net Income</th>
            <td>Rp {{ number_format($netIncome, 0, ',', '.') }}</td>
        </tr>
    </table>

    {{-- CATATAN --}}
    <p class="text-left"><em>Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</em></p>

</body>
</html>
