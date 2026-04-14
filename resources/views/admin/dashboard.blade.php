<x-app-layout>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="front_end/dashboard.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h1>MUTIARA MEDIKA</h1>
        </div>
        <div class="sidebar-menu">
            <a href="#" class="menu-item active">
                <span class="menu-item-icon"><i class="fa-solid fa-users"></i></span>
                <span>Daftar Pasien</span>
            </a>
            <a href="#" class="menu-item">
                <span class="menu-item-icon"><i class="fa-solid fa-chart-line"></i></span>
                <span>Statistik</span>
            </a>
            <a href="#" class="menu-item">
                <span class="menu-item-icon"><i class="fa-solid fa-cogs"></i></span>
                <span>Pengaturan</span>
            </a>
             <a href="#" class="menu-item">
                <span class="menu-item-icon"><i class="fa-solid fa-right-from-bracket"></i></span>
                <span>Keluar</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card-header">
                    <div>
                        <div class="stat-value" id="totalUsers">{{ $totalPendaftaran }}</div>
                        <div class="stat-label">Total Pengguna</div>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <div>
                        <div class="stat-value" id="activeUsers">{{ $pendaftaransAktif }}</div>
                        <div class="stat-label">Pengguna Aktif</div>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <div>
                        <div class="stat-value" id="inactiveUsers">{{ $pendaftaransTidakAktif }}</div>
                        <div class="stat-label">Pengguna tidak aktif</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Management Table -->
        <div class="content-card">
            <div class="search-bar">
                <input type="text" class="search-input" placeholder="Cari menggunakan nama pengguna" id="searchInput" onkeyup="searchUsers()">
                <button class="btn btn-primary" onclick="searchUsers()">Cari</button>
            </div>

            <div class="table-container">
                <table id="usersTable">
                    <thead>
                        <tr>
                    </div>
                </div>
            </div>
{{-- Tabel Data --}}
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>NAME</th>
            <th>NO_TELEPON</th>
            <th>ALAMAT</th>
            <th>NIK</th>
            <th>JENIS_KELAMIN</th>
            <th>TANGGAL_LAHIR</th>
            <th>TANGGAL_KONSULTASI</th>
            <th>WAKTU_KONSULTASI</th>
            <th>PERMASALAHAN</th>
            <th>DOKTER</th>
            <th>PEMBAYARAN</th>
            <th>STATUS</th>
        </tr>
    </thead>
    <tbody>
        @forelse($penggunas as $pengguna)
        <tr>
            <td>{{ $pengguna->id }}</td>
            <td>{{ $pengguna->nama }}</td>
            <td>{{ $pengguna->no_telepon }}</td>
            <td>{{ $pengguna->alamat }}</td>
            <td>{{ $pengguna->nik }}</td>
            <td>{{ $pengguna->jenis_kelamin }}</td>
            <td>{{ $pengguna->tanggal_lahir }}</td>
            <td>{{ $pengguna->tanggal_konsultasi }}</td>
            <td>{{ $pengguna->waktu_konsultasi }}</td>
            <td>{{ $pengguna->permasalahan }}</td>
            <td>{{ $pengguna->dokter }}</td>
            <td>{{ $pengguna->pembayaran }}</td>
            <td>{{ $pengguna->status_pendaftaran }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="12" class="text-center">Tidak ada data</td>
        </tr>
        @endforelse
    </tbody>
</table>  
                    </thead>
                    <tbody id="tableBody">
                        <!-- Data will be inserted here -->
                    </tbody>
                </table>
            </div>

            <div class="pagination" id="pagination">
                <!-- Pagination buttons will be inserted here -->
            </div>
        </div>
    </div>
</body>
</html>
</x-app-layout>
