<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pendaftaran - Step 2</title>
    <link rel="stylesheet" href="{{ asset('front_end/pendaftaran.css') }}">
    <!-- <style>
      .error-message {
        color: #fd0019;
        font-size: 13px;
        margin-top: 5px;
      }
      .alert-success {
        background: #e2f5e7;
        color: #155724;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
        max-width: 900px;
        margin: auto;
      }
    </style> -->
  </head>
  <body>
    <div class="container">
      <!-- STEPPER -->
      <div class="stepper">
        <div class="step">
          <span>1</span>
          <p>Input Data</p>
        </div>
        <div class="step active">
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

      <h2>PILIH DOKTER</h2>

      

      <!-- FORM -->
      <!-- <form
        class="form"
        action="{{ route('pendaftaran.step1.store') }}"
        method="POST"
      > -->
        <!-- Doctor 1 -->
        <div class="doctor-card" onclick="selectDoctor(this)">
          <div class="doctor-img-placeholder">
            <!-- Ganti dengan <img src="foto.jpg" class="doctor-img" alt="Dokter"> -->
            <img
              src="{{ asset('front_end/meedika.png') }}"
              class="doctor-img"
            />
          </div>
          <div class="doctor-info">
            <div class="doctor-name">
              Ainun Salisiya Nuri Azizah, STr.Keb., Bd.
            </div>
            <div class="doctor-specialty">Kesehatan Ibu dan Anak</div>
            <div class="doctor-hours">7:00 AM - 8:00 PM</div>
          </div>
        </div>

      <form class="form" action="{{ route('pendaftaran.step2.store', $pendaftaran->id) }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label>Nama dokter</label>
            <input class="placeholder" type="text" name="dokter" value="{{ old('dokter') }}" placeholder="nama dokter wajib diisi">
            @error('dokter')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- BUTTON -->
        <div class="button-group">
          <button type="button" class="btn-back">
            <a href="{{ url('/pendaftaran/step1') }}">KEMBALI</a>
          </button>
          <button type="submit" class="btn-next">SELANJUTNYA</button>
        </div>
      </form>
    </div>
  </body>
</html>
