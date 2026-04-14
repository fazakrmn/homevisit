<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pembayaran</title>
  <link rel="stylesheet" href="{{ asset('front_end/pendaftaran.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
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
.stepper {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-bottom: 30px;
}

.step {
    text-align: center;
    opacity: 0.6;
}

.step span {
    display: inline-flex;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: #b7c9cd;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-bottom: 6px;
    color: #4b646b;
}

.step.active {
    opacity: 1;
}

.step.active span {
    background: #ffffff;
    color: #4b646b;
}

    /* ── TITLE ── */
    h1 {
      font-size: clamp(1.6rem, 4vw, 2.1rem);
      font-weight: 800;
      letter-spacing: .14em;
      color: var(--white);
      text-transform: uppercase;
    }

    /* ── CARDS ── */
    .cards {
      margin: 0 auto;
      max-width: 900px;
      gap: 20px;
      width: 100%;
    }

    @media (max-width: 640px) {
      .cards { grid-template-columns: 1fr; }
    }

    .card {
      background: var(--card-bg);
      border-radius: 18px;
      padding: 28px 24px 24px;
      box-shadow: var(--shadow);
      display: flex;
      flex-direction: column;
      gap: 16px;
      transition: transform .22s ease, box-shadow .22s ease;
    }

   

    .badge {
      background: var(--badge-bg);
      color: var(--badge-text);
      font-weight: 700;
      font-size: .95rem;
      letter-spacing: .04em;
      padding: 8px 20px;
      border-radius: 999px;
      align-self: center;
      text-align: center;
    }

    .price-list {
      display: flex;
      flex-direction: column;
      gap: 8px;
      width: 100%;
    }

    .price-row {
      display: flex;
      justify-content: space-between;
      align-items: baseline;
      gap: 8px;
    }

    .price-row .label {
      font-size: .88rem;
      color: var(--text-mid);
      font-weight: 500;
      line-height: 1.4;
    }

    .price-row .amount {
      font-size: .9rem;
      font-weight: 700;
      color: var(--text-dark);
      white-space: nowrap;
    }

    .amount.gratis {
      color: #2e7a60;
    }

    /* indent sub-items */
    .indent .label { padding-left: 12px; }

    /* ── PAYMENT METHODS ── */
    .methods {
      display: flex;
      gap: 20px;
      justify-content: center;
      flex-wrap: wrap;
      width: 100%;
    }

    .method-pill {
      background: var(--white);
      border-radius: 999px;
      padding: 14px 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: var(--shadow);
      min-width: 160px;
      transition: transform .18s ease, box-shadow .18s ease;
    }

    .method-pill:hover {
      transform: scale(1.04);
      box-shadow: 0 8px 28px rgba(30,46,48,0.14);
    }

    /* BNI logo */
    .bni-logo {
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .bni-icon {
      width: 28px;
      height: 28px;
    }

    .bni-text {
      font-size: 1.4rem;
      font-weight: 800;
      color: #f47920;
      letter-spacing: .04em;
    }

    /* QRIS logo */
    .qris-logo {
      display: flex;
      align-items: center;
      gap: 4px;
    }

    .qris-box {
      width: 22px;
      height: 22px;
      border: 2.5px solid #1a1a2e;
      border-radius: 3px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      grid-template-rows: 1fr 1fr;
      padding: 2px;
      gap: 2px;
    }

    .qris-box span {
      background: #1a1a2e;
      border-radius: 1px;
    }

    .qris-text {
      font-size: 1.3rem;
      font-weight: 800;
      color: #1a1a2e;
      letter-spacing: .06em;
    }

    /* ── BUTTON ── */
    .btn-proses {
      width: 100%;
      max-width: 480px;
      background: var(--accent);
      color: var(--white);
      border: none;
      border-radius: 14px;
      padding: 20px 0;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 1.05rem;
      font-weight: 700;
      letter-spacing: .08em;
      text-transform: uppercase;
      cursor: pointer;
      box-shadow: 0 6px 24px rgba(30,46,61,0.28);
      transition: background .18s ease, transform .18s ease, box-shadow .18s ease;
    }

    .btn-proses:hover {
      background: #162336;
      transform: translateY(-2px);
      box-shadow: 0 10px 32px rgba(30,46,61,0.36);
    }

    .btn-proses:active {
      transform: translateY(0);
    }
  </style>
</head>
<body>
  <div class="container">

  <!-- STEPPER -->
    <div class="stepper">
        <div class="step">
            <span>1</span>
            <p>Input Data</p>
        </div>
        <div class="step">
            <span>2</span>
            <p>pilih dokter</p>
        </div>
        <div class="step active">
            <span>3</span>
            <p>pembayaran</p>
        </div>
        <div class="step">
            <span>4</span>
            <p>dokumen</p>
        </div>
    </div>

    <h1>Pembayaran</h1>

    <!-- CARDS -->
    <div class="cards">
      <!-- Home Visit -->
      <div class="card">
        <div class="badge">total price</div>
        <div class="price-list">
          <div class="price-row">
            <span class="label">Area Pabuaran</span>
            <span class="amount">Rp 50</span>
          </div>
          <div class="price-row">
            <span class="label">Diluar Pabuaran</span>
          </div>
          <div class="price-row indent">
            <span class="label">+ 5km</span>
            <span class="amount">Rp 80</span>
          </div>
          <div class="price-row indent">
            <span class="label">+10km</span>
            <span class="amount">Rp 100</span>
          </div>
        </div>
      </div>
    </div>

    <!-- PAYMENT METHODS -->
    <div class="methods">
      <!-- BNI -->
      <div class="method-pill">
        <div class="bni-logo">
          <svg class="bni-icon" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="40" height="40" rx="8" fill="#f47920"/>
            <path d="M8 28V12l10 10V12h4v16l-10-10v10H8z" fill="white"/>
            <path d="M24 12h8v4h-4v2h4v4h-4v2h4v4h-8V12z" fill="white"/>
          </svg>
          <span class="bni-text">BNI</span>
        </div>
      </div>

      <!-- QRIS -->
      <div class="method-pill">
        <div class="qris-logo">
          <div class="qris-box">
            <span></span><span></span>
            <span></span><span></span>
          </div>
          <span class="qris-text">QRIS</span>
        </div>
      </div>
    </div>

    <form class="form" action="{{ route('pendaftaran.step3.store', $pendaftaran->id) }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label>Nama pembayaran</label>
            <input class="placeholder" type="text" name="pembayaran" value="{{ old('pembayaran') }}" placeholder="nama pembayaran wajib diisi">
            @error('pembayaran')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

    <!-- CTA BUTTON -->
    <button type="submit" class="btn-next">Proses</button>
    <button type="btn-proses" class="btn-back">
      <a href="{{ url('pendaftarann/step2') }}">KEMBALI</a>
    </button>
  </div>
</body>
</html>