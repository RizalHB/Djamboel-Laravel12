@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="text-2xl font-semibold mb-6">Input Data Inventori Barang</h2>

    <form action="{{ route('inventori.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        @csrf

        <div class="mb-4">
            <label for="nama_barang" class="block mb-2 font-medium">Nama Barang</label>
            <input type="text" id="nama_barang" name="nama_barang" placeholder="Masukan Nama Barang" class="form-control" required>
        </div>

        <div class="mb-4">
            <label for="unit" class="block mb-2 font-medium">Unit</label>
            <select id="unit" name="unit" class="form-control" required>
                <option value="">-- Pilih Unit --</option>
                <option value="ekor">Ekor</option>
                <option value="pcs">Pcs</option>
                <option value="kg">Kg</option>
                <option value="ons">Ons</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="amount" class="block mb-2 font-medium">Jumlah Barang</label>
            <input type="number" id="amount" name="amount" placeholder="Masukan Jumlah Barang Per Unit" min="1" class="form-control" required>
        </div>

        <div class="mb-4">
            <label for="price_per_unit" class="block mb-2 font-medium">Harga per Unit (Rp)</label>
            <input type="number" id="price_per_unit" name="price_per_unit" placeholder="Masukan harga perunit" min="0" class="form-control" required>
        </div>

        <div class="mb-4">
            <label for="supplier" class="block mb-2 font-medium">Supplier</label>
            <input type="text" id="supplier" name="supplier" placeholder="Masukan Nama Supplier" class="form-control" required>
        </div>

        <div class="mb-4">
            <label for="tanggal_pembelian" class="block mb-2 font-medium">Tanggal Pembelian</label>
            <input type="date" id="tanggal_pembelian" name="tanggal_pembelian" class="form-control" min="{{ date('Y-m-d') }}" required>
        </div>

        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Simpan Inventori
        </button>
    </form>
    @if (session('success'))
    <div class="alert alert-success my-3">
        {{ session('success') }}
    </div>
@endif

<h3 class="mt-5">Daftar Inventori</h3>

<table class="table table-striped mt-3">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Unit</th>
            <th>Jumlah</th>
            <th>Harga Per Unit</th>
            <th>Supplier</th>
            <th>Tanggal Pembelian</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($inventoris as $index => $inventori)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $inventori->nama_barang }}</td>
                <td>{{ $inventori->unit }}</td>
                <td>{{ $inventori->amount }}</td>
                <td>Rp{{ number_format($inventori->price_per_unit, 0, ',', '.') }}</td>
                <td>{{ $inventori->supplier }}</td>
                <td>{{ $inventori->tanggal_pembelian }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</div>
@endsection
