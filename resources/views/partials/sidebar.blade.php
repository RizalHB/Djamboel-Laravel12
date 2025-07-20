<div class="sidebar p-3">
    <h5 class="fw-bold mb-4">Toko Ayam</h5>
    <ul class="nav flex-column">
        <li><a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a></li>
        <li><a href="{{ route('inventori.index') }}" class="nav-link {{ request()->is('inventori*') ? 'active' : '' }}">Inventori</a></li>
        <li><a href="{{ route('penjualan.index') }}" class="nav-link {{ request()->is('penjualan*') ? 'active' : '' }}">Penjualan</a></li>
        <li><a href="{{ route('pengeluaran.index') }}" class="nav-link {{ request()->is('pengeluaran*') ? 'active' : '' }}">Pengeluaran</a></li>
        <li><a href="{{ route('laporan.index') }}" class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}">Laporan</a></li>
    </ul>
</div>
