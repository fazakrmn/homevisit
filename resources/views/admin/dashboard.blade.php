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
                <span>Pendaftaran</span>
            </a>
        </div>
        <div class="sidebar-menu">
            <a href="#" class="menu-item active">
                <span class="menu-item-icon"><i class="fa-solid fa-users"></i></span>
                <span>Pengguna</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card-header">
                    <div>
                        <div class="stat-value" id="totalUsers">4</div>
                        <div class="stat-label">Total Pengguna</div>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <div>
                        <div class="stat-value" id="activeUsers">3</div>
                        <div class="stat-label">Pengguna Aktif</div>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <div>
                        <div class="stat-value" id="inactiveUsers">1</div>
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
                            <th>ID</th>
                            <th>Name</th>
                            <th>No_Telepon</th>
                            <th>Alamat</th>
                            <th>NIK</th>
                            <th>Jenis_Kelamin</th>
                            <th>Tanggal_Lahir</th>
                            <th>tanggal_konsultasi</th>
                            <th>waktu_konsultasi</th>
                            <th>permasalahan</th>
                            <th>kategori_masalah</th>
                            <th>dokumen_ktp</th>
                            <th>dokumen_pendukung</th>
                            <th>status_step</th>
                            <th>status_pendaftaran</th>
                        </tr>
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

</x-app-layout>
