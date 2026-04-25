<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pembayaran</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

  {{-- Midtrans Snap.js — gunakan sandbox untuk testing --}}
  @if(config('midtrans.is_production'))
    <script src="https://app.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
  @else
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
  @endif

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg: #6b8a91;
      --card-bg: #e8f0ef;
      --badge-bg: #9db8bc;
      --badge-text: #fff;
      --text-dark: #1e2e30;
      --text-mid: #2e4547;
      --accent: #1e2e3d;
      --white: #ffffff;
      --shadow: 0 4px 24px rgba(30,46,48,0.10);
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: var(--bg);
      min-height: 100vh;
      display: flex;
      align-items: flex-start;
      justify-content: center;
      padding: 48px 20px 60px;
    }

    .container {
      width: 100%;
      max-width: 860px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 40px;
      animation: fadeUp .55s cubic-bezier(.22,1,.36,1) both;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(28px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* STEPPER */
    .stepper { display: flex; justify-content: center; gap: 20px; margin-bottom: 30px; }
    .step { text-align: center; opacity: 0.6; }
    .step span {
      display: inline-flex; width: 45px; height: 45px; border-radius: 50%;
      background: #b7c9cd; align-items: center; justify-content: center;
      font-weight: bold; margin-bottom: 6px; color: #4b646b;
    }
    .step.active { opacity: 1; }
    .step.active span { background: #ffffff; color: #4b646b; }

    h1 {
      font-size: clamp(1.6rem, 4vw, 2.1rem);
      font-weight: 800; letter-spacing: .14em;
      color: var(--white); text-transform: uppercase;
    }

    .card {
      background: var(--card-bg); border-radius: 18px;
      padding: 28px 24px 24px; box-shadow: var(--shadow);
      display: flex; flex-direction: column; gap: 16px; width: 100%;
    }

    .badge {
      background: var(--badge-bg); color: var(--badge-text);
      font-weight: 700; font-size: .95rem; letter-spacing: .04em;
      padding: 8px 20px; border-radius: 999px;
      align-self: center; text-align: center;
    }

    .price-list { display: flex; flex-direction: column; gap: 8px; width: 100%; }

    .price-row {
      display: flex; justify-content: space-between;
      align-items: baseline; gap: 8px;
    }

    .price-row .label { font-size: .88rem; color: var(--text-mid); font-weight: 500; }
    .price-row .amount { font-size: .9rem; font-weight: 700; color: var(--text-dark); white-space: nowrap; }
    .indent .label { padding-left: 12px; }

    /* TOTAL ROW */
    .total-row {
      display: flex; justify-content: space-between;
      border-top: 1.5px solid #b7c9cd; padding-top: 12px; margin-top: 4px;
    }
    .total-row .label { font-weight: 700; color: var(--text-dark); font-size: 1rem; }
    .total-row .amount { font-size: 1.1rem; font-weight: 800; color: var(--accent); }

    /* PAYMENT METHODS */
    .methods { display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; width: 100%; }

    .method-pill {
      background: var(--white); border-radius: 999px;
      padding: 14px 36px; display: flex;
      align-items: center; justify-content: center;
      box-shadow: var(--shadow); min-width: 160px;
      cursor: pointer;
      border: 3px solid transparent;
      transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    }

    .method-pill:hover { transform: scale(1.04); box-shadow: 0 8px 28px rgba(30,46,48,0.14); }

    /* Highlight metode yang dipilih */
    .method-pill.selected {
      border-color: var(--accent);
      box-shadow: 0 0 0 4px rgba(30,46,61,0.12);
    }

    .bni-logo { display: flex; align-items: center; gap: 6px; }
    .bni-icon { width: 28px; height: 28px; }
    .bni-text { font-size: 1.4rem; font-weight: 800; color: #f47920; letter-spacing: .04em; }

    .qris-logo { display: flex; align-items: center; gap: 4px; }
    .qris-box {
      width: 22px; height: 22px; border: 2.5px solid #1a1a2e;
      border-radius: 3px; display: grid;
      grid-template-columns: 1fr 1fr; grid-template-rows: 1fr 1fr;
      padding: 2px; gap: 2px;
    }
    .qris-box span { background: #1a1a2e; border-radius: 1px; }
    .qris-text { font-size: 1.3rem; font-weight: 800; color: #1a1a2e; letter-spacing: .06em; }

    /* FORM */
    .form-group { display: flex; flex-direction: column; gap: 8px; width: 100%; max-width: 480px; }
    .form-group label { font-weight: 600; color: var(--white); font-size: .95rem; }
    .form-group input {
      padding: 14px 16px; border-radius: 12px; border: 2px solid transparent;
      font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1rem;
      background: var(--white); color: var(--text-dark);
      outline: none; transition: border-color .2s;
    }
    .form-group input:focus { border-color: var(--accent); }
    .error-message { color: #ffd6d6; font-size: .85rem; font-weight: 500; }

    /* BUTTONS */
    .btn-group { display: flex; gap: 16px; width: 100%; max-width: 480px; }

    .btn-proses {
      flex: 1; background: var(--accent); color: var(--white);
      border: none; border-radius: 14px; padding: 18px 0;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 1.05rem; font-weight: 700;
      letter-spacing: .08em; text-transform: uppercase;
      cursor: pointer; box-shadow: 0 6px 24px rgba(30,46,61,0.28);
      transition: background .18s ease, transform .18s ease;
    }
    .btn-proses:hover { background: #162336; transform: translateY(-2px); }
    .btn-proses:disabled { background: #aaa; cursor: not-allowed; transform: none; }

    .btn-back {
      flex: 1; background: transparent; color: var(--white);
      border: 2px solid rgba(255,255,255,0.6); border-radius: 14px;
      padding: 18px 0; font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 1rem; font-weight: 600; text-transform: uppercase;
      cursor: pointer; text-decoration: none;
      display: flex; align-items: center; justify-content: center;
      transition: background .18s, border-color .18s;
    }
    .btn-back:hover { background: rgba(255,255,255,0.1); border-color: white; }

    /* ALERT */
    .alert {
      background: #fdecea; color: #c0392b;
      border-radius: 10px; padding: 12px 18px;
      font-size: .9rem; font-weight: 500; width: 100%; max-width: 480px;
    }
  </style>
</head>
<body>
<div class="container">

  {{-- STEPPER --}}
  <div class="stepper">
    <div class="step"><span>1</span><p>Input Data</p></div>
    <div class="step"><span>2</span><p>Pilih Dokter</p></div>
    <div class="step active"><span>3</span><p>Pembayaran</p></div>
    <div class="step"><span>4</span><p>Dokumen</p></div>
  </div>

  <h1>Pembayaran</h1>

  {{-- SESSION ERROR --}}
  @if(session('error'))
    <div class="alert">{{ session('error') }}</div>
  @endif

  {{-- CARD HARGA --}}
  <div class="card">
    <div class="badge">Total Price</div>
    <div class="price-list">
      <div class="price-row">
        <span class="label">Area Pabuaran</span>
        <span class="amount">Rp 50.000</span>
      </div>
      <div class="price-row">
        <span class="label">Diluar Pabuaran</span>
      </div>
      <div class="price-row indent">
        <span class="label">+ 5km</span>
        <span class="amount">Rp 80.000</span>
      </div>
      <div class="price-row indent">
        <span class="label">+ 10km</span>
        <span class="amount">Rp 100.000</span>
      </div>
    </div>
    {{-- Total sesuai data pendaftaran --}}
    <div class="price-row total-row">
      <span class="label">Total Pembayaran</span>
      <span class="amount">Rp {{ number_format($pendaftaran->total_amount, 0, ',', '.') }}</span>
    </div>
  </div>

  {{-- PILIHAN METODE BAYAR --}}
  <div class="methods">
    <div class="method-pill" data-method="bni" onclick="pilihMetode(this)">
      <div class="bni-logo">
        <svg class="bni-icon" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="40" height="40" rx="8" fill="#f47920"/>
          <path d="M8 28V12l10 10V12h4v16l-10-10v10H8z" fill="white"/>
          <path d="M24 12h8v4h-4v2h4v4h-4v2h4v4h-8V12z" fill="white"/>
        </svg>
        <span class="bni-text">BNI</span>
      </div>
    </div>

    <div class="method-pill" data-method="qris" onclick="pilihMetode(this)">
      <div class="qris-logo">
        <div class="qris-box">
          <span></span><span></span>
          <span></span><span></span>
        </div>
        <span class="qris-text">QRIS</span>
      </div>
    </div>
  </div>

  {{-- FORM --}}
  <form id="payment-form" action="{{ route('pendaftaran.step3.store', $pendaftaran->id) }}" method="POST" style="width:100%;display:flex;flex-direction:column;align-items:center;gap:20px;">
    @csrf

    {{-- Hidden: snap token dari controller --}}
    <input type="hidden" id="snap_token" name="snap_token" value="{{ $snapToken ?? '' }}">
    <input type="hidden" id="metode_bayar" name="metode_bayar" value="">

    <div class="form-group">
      <label>Nama Pembayar</label>
      <input type="text" name="pembayaran"
             value="{{ old('pembayaran', auth()->user()->name ?? '') }}"
             placeholder="Masukkan nama pembayar">
      @error('pembayaran')
        <div class="error-message">{{ $message }}</div>
      @enderror
    </div>

    <div class="btn-group">
      <a href="{{ url('pendaftaran/step2/' . $pendaftaran->id) }}" class="btn-back">← Kembali</a>
      <button type="button" id="btn-bayar" class="btn-proses" onclick="bayar()">
        Proses Bayar
      </button>
    </div>
  </form>

</div>

<script>
  // Pilih metode pembayaran
  function pilihMetode(el) {
    document.querySelectorAll('.method-pill').forEach(p => p.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('metode_bayar').value = el.dataset.method;
  }

  // Trigger Midtrans Snap
  function bayar() {
    const snapToken = document.getElementById('snap_token').value;
    const metode    = document.getElementById('metode_bayar').value;

    if (!metode) {
      alert('Pilih metode pembayaran terlebih dahulu!');
      return;
    }

    if (!snapToken) {
      alert('Token pembayaran tidak tersedia. Hubungi admin.');
      return;
    }

    snap.pay(snapToken, {
      onSuccess: function(result) {
        // Setelah sukses, submit form ke backend
        document.getElementById('payment-form').submit();
      },
      onPending: function(result) {
        alert('Pembayaran pending. Selesaikan pembayaran Anda.');
      },
      onError: function(result) {
        alert('Pembayaran gagal. Silakan coba lagi.');
      },
      onClose: function() {
        // User menutup popup tanpa bayar
      }
    });
  }
</script>
</body>
</html>