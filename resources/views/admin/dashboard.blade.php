<x-app-layout>
<link rel="stylesheet" href="{{ asset('front_end/dashboard.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

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
            <a href="{{ route('profile.edit') }}" class="menu-item">
                <span class="menu-item-icon"><i class="fa-solid fa-user"></i></span>
                <span>Profile</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" class="menu-item"
                   onclick="event.preventDefault(); this.closest('form').submit();">
                    <span class="menu-item-icon"><i class="fa-solid fa-right-from-bracket"></i></span>
                    <span>Keluar</span>
                </a>
            </form>
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
                <input type="text" class="search-input" placeholder="Cari menggunakan nama pengguna" id="searchInput">
                <button class="btn btn-primary" onclick="searchUsers()">Cari</button>
            </div>

            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAMA</th>
                            <th>NO TELEPON</th>
                            <th>ALAMAT</th>
                            <th>NIK</th>
                            <th>JENIS KELAMIN</th>
                            <th>TANGGAL LAHIR</th>
                            <th>TANGGAL KONSULTASI</th>
                            <th>WAKTU KONSULTASI</th>
                            <th>PERMASALAHAN</th>
                            <th>DOKTER</th>
                            <th>PEMBAYARAN</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
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
                            <td colspan="13" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
