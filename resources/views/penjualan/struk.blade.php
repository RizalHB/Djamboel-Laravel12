<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            size: 75mm 60mm portrait;
            margin: 5mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .header img {
            height: 50px;
            margin-right: 10px;
        }

        .header .info {
            flex-grow: 1;
        }

        .header .info h2 {
            color: red;
            font-size: 14px;
            margin: 0;
        }

        .header .info small {
            font-size: 10px;
            color: #555;
        }

        hr {
            border: 0;
            border-top: 1px solid #000;
            margin: 6px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }

        .table td {
            padding: 2px 0;
        }

        .footer {
            margin-top: 8px;
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .red {
            color: red;
        }

        .green {
            color: green;
        }
    </style>
</head>
<body>

<div class="header">
    <img src="{{ public_path('logo/LogoDAP-removebg-preview.png') }}" alt="Logo">
    <div class="info">
        <h2>D'jamboel Ayam Potong</h2>
        <small>Telp. 0877-2204-2528</small>
    </div>
</div>

<hr>

<div class="info">
    <div>Tanggal: {{ \Carbon\Carbon::parse($penjualan->tanggal_pelunasan)->format('d-m-Y') }}</div>
    <div>ID Transaksi: {{ $penjualan->transaksi_id }}</div>
    <div>Nama/ID Kostumer: {{ $penjualan->nama_kostumer }}</div>
</div>

<hr>

<table class="table">
    @foreach ($penjualan->details as $item)
    <tr>
        <td colspan="2">{{ $item->inventori->nama_barang }}</td>
    </tr>
    <tr>
        <td>{{ number_format($item->jumlah, 2) }} x Rp{{ number_format($item->harga_satuan, 2, ',', '.') }}</td>
        <td class="text-end">
            @if ($item->diskon)
                <s>Rp{{ number_format($item->jumlah * $item->harga_satuan, 0, ',', '.') }}</s><br>
                <span class="{{ $item->subtotal < $item->jumlah * $item->harga_satuan ? 'green' : 'black' }}">
                    Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                </span>
            @else
                Rp{{ number_format($item->subtotal, 0, ',', '.') }}
            @endif
        </td>
    </tr>
    @endforeach
</table>

<hr>

<table class="table">
    <tr>
        <td class="bold">Metode</td>
        <td class="text-end">{{ $penjualan->metode_pembayaran }}</td>
    </tr>
    <tr>
        <td class="bold">Status</td>
        <td class="text-end">{{ $penjualan->status_pembayaran }}</td>
    </tr>
    <tr>
        <td class="bold">Total Bayar</td>
        <td class="text-end">Rp{{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
    </tr>
</table>

<div class="footer">
    Terima kasih atas kunjungan Anda.
</div>

</body>
</html>
