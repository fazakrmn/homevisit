<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bukti Pembayaran – Mutiara Medika</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg: #6b8a91;
      --panel: #e8f0ef;
      --white: #ffffff;
      --text-dark: #1e2e30;
      --text-mid: #4a6568;
      --text-light: #7a9598;
      --badge-bg: #9db8bc;
      --header-bg: #5c7e85;
      --shadow: 0 6px 32px rgba(30,46,48,0.13);
      --radius: 18px;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: var(--bg);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 16px;
    }

    /* ── OUTER CARD ── */
    .outer-card {
      background: var(--panel);
      border-radius: 24px;
      padding: 32px;
      width: 100%;
      max-width: 960px;
      box-shadow: var(--shadow);
      display: grid;
      grid-template-columns: 260px 1fr;
      grid-template-rows: auto auto;
      gap: 24px;
      animation: fadeUp .5s cubic-bezier(.22,1,.36,1) both;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(24px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 680px) {
      .outer-card {
        grid-template-columns: 1fr;
        padding: 20px;
      }
    }

    /* ── LEFT PANEL ── */
    .left {
      display: flex;
      flex-direction: column;
      gap: 24px;
    }

    .info-block {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .info-block label {
      font-size: .78rem;
      font-weight: 700;
      color: var(--text-dark);
      letter-spacing: .03em;
    }

    .info-pill {
      background: var(--badge-bg);
      border-radius: 12px;
      padding: 12px 16px;
      display: flex;
      align-items: center;
      gap: 12px;
      color: var(--white);
      font-size: .88rem;
      font-weight: 600;
    }

    .info-pill svg {
      flex-shrink: 0;
      opacity: .9;
    }

    /* order meta */
    .order-meta {
      margin-top: auto;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .meta-row {
      display: flex;
      flex-direction: column;
      gap: 2px;
    }

    .meta-row .meta-label {
      font-size: .72rem;
      font-weight: 600;
      color: var(--text-mid);
      letter-spacing: .04em;
    }

    .meta-row .meta-value {
      font-size: .82rem;
      font-weight: 500;
      color: var(--text-dark);
    }

    /* ── RIGHT PANEL – RECEIPT ── */
    .receipt {
      background: var(--white);
      border-radius: var(--radius);
      overflow: hidden;
      box-shadow: 0 2px 12px rgba(30,46,48,0.07);
      display: flex;
      flex-direction: column;
    }

    /* clinic header */
    .receipt-header {
      background: var(--header-bg);
      padding: 18px 24px;
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .clinic-address {
      font-size: .72rem;
      color: rgba(255,255,255,.85);
      line-height: 1.5;
      flex: 1;
    }

    .clinic-name-block {
      text-align: center;
      flex: 1;
    }

    .clinic-name {
      font-size: 1.3rem;
      font-weight: 800;
      color: var(--white);
      letter-spacing: .06em;
      line-height: 1.2;
    }

    .clinic-sub {
      font-size: .65rem;
      color: rgba(255,255,255,.75);
      letter-spacing: .12em;
      margin-top: 2px;
    }

    .clinic-contact {
      font-size: .7rem;
      color: rgba(255,255,255,.85);
      text-align: right;
      line-height: 1.6;
      flex: 1;
    }

    /* receipt body */
    .receipt-body {
      padding: 24px 28px 28px;
      display: flex;
      flex-direction: column;
      gap: 14px;
      flex: 1;
    }

    .receipt-title {
      text-align: center;
      font-size: .95rem;
      font-weight: 700;
      color: var(--text-dark);
      letter-spacing: .04em;
    }

    .receipt-no {
      text-align: center;
      font-size: .82rem;
      color: var(--text-mid);
      font-weight: 500;
      margin-top: -8px;
    }

    .divider {
      height: 1px;
      background: #d4e3e5;
    }

    .receipt-row {
      display: flex;
      gap: 8px;
      font-size: .88rem;
      color: var(--text-dark);
    }

    .receipt-row .r-label {
      width: 150px;
      flex-shrink: 0;
      font-weight: 600;
      color: var(--text-mid);
    }

    .receipt-row .r-sep {
      color: var(--text-mid);
    }

    .receipt-row .r-value {
      font-weight: 500;
    }

    /* untuk pembayaran section */
    .section-title {
      font-size: .85rem;
      font-weight: 700;
      color: var(--text-dark);
      margin-top: 4px;
    }

    .service-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: .88rem;
      padding-left: 16px;
    }

    .service-row .s-name {
      color: var(--text-mid);
      font-weight: 500;
    }

    .service-row .s-price {
      font-weight: 700;
      color: var(--text-dark);
      border-bottom: 1.5px solid var(--text-dark);
      padding-bottom: 2px;
    }

    .total-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: .9rem;
      font-weight: 700;
      color: var(--text-dark);
      margin-top: 2px;
    }

    .method-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: .88rem;
    }

    .method-row .m-label {
      font-weight: 600;
      color: var(--text-dark);
    }

    .method-row .m-value {
      font-weight: 500;
      color: var(--text-mid);
    }

    .receipt-date {
      text-align: right;
      font-size: .82rem;
      color: var(--text-mid);
      font-weight: 500;
      margin-top: 8px;
    }

    /* ── BUTTON ROW ── */
    .btn-row {
      grid-column: 1 / -1;
      display: flex;
      justify-content: center;
    }

    .btn-kembali {
      background: var(--header-bg);
      color: var(--white);
      border: none;
      border-radius: 12px;
      padding: 16px 72px;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 1rem;
      font-weight: 800;
      letter-spacing: .14em;
      text-transform: uppercase;
      cursor: pointer;
      box-shadow: 0 4px 18px rgba(92,126,133,0.35);
      transition: background .18s ease, transform .18s ease, box-shadow .18s ease;
    }

    .btn-kembali:hover {
      background: #4a6e76;
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(92,126,133,0.45);
    }

    .btn-kembali:active { transform: translateY(0); }
  </style>
</head>
<body>
  <div class="outer-card">

    <!-- ── LEFT ── -->
    <div class="left">

      <div class="info-block">
        <label>Estimasi Perawat Sampai</label>
        <div class="info-pill">
          <!-- scooter icon -->
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 17H3a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h11l2-4h3"/>
            <circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/>
            <path d="M9 17h6"/>
          </svg>
          Perawat dalam perjalanan
        </div>
      </div>

      <div class="info-block">
        <label>Alamat Pasien</label>
        <div class="info-pill">
          <!-- location icon -->
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
            <circle cx="12" cy="9" r="2.5"/>
          </svg>
          Jl. Kamboja No.23
        </div>
      </div>

      <div class="info-block">
        <label>Butuh Bantuan ?</label>
        <div class="info-pill">
          <!-- headset icon -->
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 18v-6a9 9 0 0 1 18 0v6"/>
            <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3z"/>
            <path d="M3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/>
          </svg>
          Hubungi Perawat
        </div>
      </div>

      <!-- order meta -->
      <div class="order-meta">
        <div class="meta-row">
          <span class="meta-label">No. Pesanan</span>
          <span class="meta-value">13751931110</span>
        </div>
        <div class="meta-row">
          <span class="meta-label">Waktu Pemesanan</span>
          <span class="meta-value">25-12-2025 &nbsp; 10:00</span>
        </div>
        <div class="meta-row">
          <span class="meta-label">Waktu Pesanan Selesai</span>
          <span class="meta-value">25-12-2025 &nbsp; 10:45</span>
        </div>
      </div>

    </div>

    <!-- ── RIGHT – RECEIPT ── -->
    <div class="receipt">

      <!-- clinic header -->
      <div class="receipt-header">
        <p class="clinic-address">
          Pabuaran, Pabuaran, Kec. Purwokerto Utara,<br>
          Kabupaten Banyumas, Jawa Tengah 53124
        </p>
        <div class="clinic-name-block">
          <div class="clinic-name">MUTIARA MEDIKA</div>
          <div class="clinic-sub">KLINIK PRATAMA MUTIARA MEDIKA</div>
        </div>
        <p class="clinic-contact">
          Telepon (0281) 641973<br>
          Whatsapp 085225522131
        </p>
      </div>

      <!-- receipt body -->
      <div class="receipt-body">
        <p class="receipt-title">Bukti Pembayaran</p>
        <p class="receipt-no">No. 13751931110</p>

        <div class="divider"></div>

        <div class="receipt-row">
          <span class="r-label">Sudah diterima dari</span>
          <span class="r-sep">:</span>
          <span class="r-value">Ny. Hermione</span>
        </div>
        <div class="receipt-row">
          <span class="r-label">Nama Pastien</span>
          <span class="r-sep">:</span>
          <span class="r-value">Ny. Hermione</span>
        </div>
        <div class="receipt-row">
          <span class="r-label">Nama Dokter</span>
          <span class="r-sep">:</span>
          <span class="r-value">Bd. Ainun Salisiya Nuri. A</span>
        </div>

        <p class="section-title">Untuk Pembayaran</p>

        <div class="service-row">
          <span class="s-name">Layanan Home Visit</span>
          <span class="s-price">Rp. 300.000.00</span>
        </div>

        <div class="divider"></div>

        <div class="total-row">
          <span>Total Pembayaran</span>
          <span>Rp. 300.000.00</span>
        </div>

        <div class="method-row">
          <span class="m-label">Metode Pembayaran</span>
          <span class="m-value">Transfer Bank</span>
        </div>

        <p class="receipt-date">Purwokerto, 25 Desember 2025</p>
      </div>
    </div>

    <!-- ── BUTTON ── -->
    <div class="btn-row">
      <button class="btn-kembali">
        <a href="{{ url('pendaftaran/step3') }}">KEMBALI</a>
      </button>
    </div>

  </div>
</body>
</html>