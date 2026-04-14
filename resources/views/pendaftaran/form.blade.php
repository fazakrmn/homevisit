<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran - Step 1</title>
    <link rel="stylesheet" href="{{ asset('front_end/pendaftaran.css') }}">
</head>
<body>

<div class="container">
    <!-- STEPPER -->
    <div class="stepper">
        <div class="step active">
            <span>1</span>
            <p>Input Data</p>
        </div>
        <div class="step">
            <span>2</span>
            <p>pilih dokter</p>
        </div>
        <div class="step">
            <span>3</span>
            <p>pembayaran</p>
        </div>
        <div class="step">
            <span>4</span>
            <p>dokumen</p>
        </div>
    </div>

    <h2>PENDAFTARAN</h2>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <!-- FORM -->
    <form class="form" action="{{ route('pendaftaran.step1.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label>Nama</label>
            <input class="placeholder" type="text" name="nama" value="{{ old('nama') }}" placeholder="nama wajib diisi">
            @error('nama')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>No. Telepon</label>
            <input class="placeholder" type="text" name="no_telepon" value="{{ old('no_telepon') }}" placeholder="maksimal 12 karakter" maxlength="12">
            @error('no_telepon')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <input class="placeholder" type="text" name="alamat" value="{{ old('alamat') }}" placeholder="masukan alamat lengkap sesuai KTP">
            @error('alamat')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>NIK</label>
            <input class="placeholder" type="text" name="nik" value="{{ old('nik') }}" placeholder="masukan NIK sesuai KTP" maxlength="16">
            @error('nik')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin">
                <option value="">-- Pilih --</option>
                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
            @error('jenis_kelamin')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
            @error('tanggal_lahir')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>Tanggal Konsultasi</label>
            <input type="date" name="tanggal_konsultasi" value="{{ old('tanggal_konsultasi') }}">
            @error('tanggal_konsultasi')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>waktu konsultasi</label>
            <input type="time" name="waktu_konsultasi" value="{{ old('waktu_konsultasi') }}">
            @error('waktu_konsultasi')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>permasalahan</label>
            <input type="text" name="permasalahan" value="{{ old('permasalahan') }}" placeholder="masukan permasalahan">
            @error('permasalahan')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- BUTTON -->
        <div class="button-group">
            <button type="button" class="btn-back">
                <a href="{{ url('/') }}">KEMBALI</a>
            </button>
            <button type="submit" class="btn-next">SELANJUTNYA</button>
        </div>
    </form>
</div>

</body>
</html>