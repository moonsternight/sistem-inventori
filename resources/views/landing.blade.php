<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Toko Mekar Jaya · Besi & Bahan Bangunan</title>
    <link rel="icon" type="image/png" href="{{ asset('images/MekarJaya.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400&display=swap"
        rel="stylesheet" />
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --navy: #1a2332;
            --navy-mid: #22304a;
            --red: #c0392b;
            --red-light: #e74c3c;
            --bg: #e8ecf0;
            --bg-card: #dce2e8;
            --white: #f8f9fb;
            --border: #c8d0da;
            --text: #1a2332;
            --muted: #6b7a8d;
            --light: #9aa5b4;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            overflow-x: hidden;
        }

        /* ══════════════════════════════════
       STICKY NAV
    ══════════════════════════════════ */
        .nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: rgba(26, 35, 50, 0.97);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 72px;
            height: 68px;
            transition: box-shadow 0.3s;
        }

        .nav.scrolled {
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            /* Membuat kursor tetap panah biasa dan tidak bisa diklik */
            cursor: default;
            user-select: none;
        }

        .nav-logo:hover {
            opacity: 1;
            transform: none;
        }

        .logo-box {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            overflow: hidden;
            flex-shrink: 0;
        }

        .logo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Container untuk mengatur jarak (gap) antara judul dan sub-judul */
        .nav-logo-text {
            display: flex;
            flex-direction: column;
            gap: 2px;
            /* Angka ini yang membuat tulisan atas dan bawah renggang */
        }

        .nav-logo-name {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--white);
            line-height: 1;
        }

        /* Memberi warna merah khusus pada kata 'Jaya' */
        .nav-logo-name span {
            color: #e74c3c;
        }

        .nav-logo-sub {
            font-size: 9px;
            color: rgba(255, 255, 255, 0.38);
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 36px;
            list-style: none;
        }

        .nav-links a {
            font-size: 13px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.55);
            text-decoration: none;
            transition: color 0.3s;
            letter-spacing: 0.3px;
        }

        .nav-links a:hover {
            color: var(--white);
        }

        /* Hamburger */
        .nav-hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 4px;
        }

        .nav-hamburger span {
            display: block;
            width: 22px;
            height: 2px;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 2px;
            transition: all 0.3s;
        }

        /* ══════════════════════════════════
       HERO
    ══════════════════════════════════ */
        .hero {
            min-height: 100vh;
            background: var(--navy);
            display: grid;
            grid-template-columns: 1fr 1fr;
            padding-top: 68px;
            overflow: hidden;
            position: relative;
        }

        /* grid texture */
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.018) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.018) 1px, transparent 1px);
            background-size: 48px 48px;
            pointer-events: none;
        }

        .hero-left {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 80px 60px 56px 72px;
            position: relative;
            z-index: 2;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
        }

        .hero-eyebrow-line {
            width: 32px;
            height: 2px;
            background: var(--red);
        }

        .hero-eyebrow-text {
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            color: rgba(255, 255, 255, 0.45);
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(44px, 4.8vw, 72px);
            font-weight: 900;
            line-height: 1.05;
            color: var(--white);
            margin-bottom: 6px;
            animation: fadeUp 0.8s ease both;
        }

        .hero-title em {
            font-style: italic;
            color: var(--red-light);
        }

        .hero-title-sub {
            font-family: 'Playfair Display', serif;
            font-size: clamp(28px, 3vw, 44px);
            font-weight: 700;
            line-height: 1.15;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 32px;
            animation: fadeUp 0.8s ease 0.1s both;
        }

        .hero-desc {
            font-size: 15px;
            font-weight: 300;
            line-height: 1.9;
            color: rgba(255, 255, 255, 0.5);
            max-width: 400px;
            margin-bottom: 48px;
            animation: fadeUp 0.8s ease 0.2s both;
        }

        .hero-actions {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            animation: fadeUp 0.8s ease 0.3s both;
        }

        .btn-red {
            background: var(--red);
            color: var(--white);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            padding: 15px 32px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            /* Transisi lebih halus */
            display: inline-flex;
            align-items: center;
            gap: 10px;
            /* Jarak ikon sedikit lebih renggang agar lega */
        }

        .btn-red:hover {
            background: #c0392b;
            opacity: 0.85;
        }

        .btn-ghost {
            background: transparent;
            color: rgba(255, 255, 255, 0.8);
            /* Warna teks sedikit lebih terang agar mudah dibaca */
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 400;
            padding: 15px 32px;
            border-radius: 6px;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.25);
            /* Garis sedikit lebih nyata */
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-ghost:hover {
            border-color: var(--white);
            color: var(--white);
            background: rgba(255, 255, 255, 0.05);
        }

        /* Trust bar */
        .trust-bar {
            display: flex;
            gap: 32px;
            margin-top: 56px;
            animation: fadeUp 0.8s ease 0.4s both;
        }

        .trust-item {
            display: flex;
            flex-direction: column;
            border-left: 2px solid rgba(192, 57, 43, 0.4);
            padding-left: 14px;
        }

        .trust-num {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 700;
            color: var(--white);
            line-height: 1;
        }

        .trust-label {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.38);
            font-weight: 300;
            margin-top: 3px;
            letter-spacing: 0.3px;
        }

        /* Hero right — visual */
        .hero-right {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 56px 72px 56px 40px;
            position: relative;
            z-index: 2;
        }

        .hero-visual {
            width: 100%;
            max-width: 420px;
            position: relative;
            animation: fadeUp 0.8s ease 0.3s both;
        }

        /* Main store card */
        .store-card {
            background: var(--navy-mid);
            border: 1px solid rgba(255, 255, 255, 0.09);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.4);
        }

        .store-card-header {
            background: var(--red);
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .store-card-icon {
            width: 48px;
            height: 48px;
            background: var(--red);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            /* font-size: 24px; */
            /* Hapus/Komen bagian ini karena bukan teks lagi */
            flex-shrink: 0;
            overflow: hidden;
            /* Memastikan logo tidak keluar dari lingkaran */
        }

        /* Tambahkan kode baru ini di bawahnya untuk mengatur gambar logo */
        .store-card-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            /* Memastikan logo merah terlihat utuh di dalam lingkaran */
            display: block;
        }

        .store-card-name {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--white);
        }

        .store-card-addr {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.65);
            margin-top: 2px;
        }

        .store-card-body {
            padding: 20px 24px;
        }

        .store-info-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            font-size: 13px;
        }

        .store-info-row:last-child {
            border-bottom: none;
        }

        .store-info-icon {
            width: 30px;
            height: 30px;
            background: rgba(192, 57, 43, 0.15);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
            margin-top: 1px;
            /* Merah bata transparan */
            border: 1px solid rgba(192, 57, 43, 0.25);
        }

        .store-info-icon svg {
            width: 50%;
            height: 50%;
            /* Gunakan warna merah khas Mekar Jaya agar ikon terlihat tegas di atas kartu putih */
            color: #e74c3c;
            stroke-width: 2;
            /* Ketebalan garis yang pas */
        }

        .store-info-label {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.35);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .store-info-val {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 400;
        }

        /* Floating badge */
        .float-badge {
            position: absolute;
            top: -18px;
            right: -18px;
            background: var(--white);
            border-radius: 12px;
            padding: 14px 18px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .float-badge-icon {
            font-size: 24px;
        }

        .float-badge-val {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--navy);
            line-height: 1;
        }

        .float-badge-label {
            font-size: 10px;
            color: var(--muted);
            letter-spacing: 0.5px;
            margin-top: 2px;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.3;
            }
        }

        /* ══════════════════════════════════
       TENTANG KAMI
    ══════════════════════════════════ */
        .about {
            padding: 100px 72px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
            background: var(--bg);
        }

        .about-label {
            font-family: 'DM Mono', monospace;
            font-size: 10px;
            color: var(--red);
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .about-label::before {
            content: '';
            width: 28px;
            height: 2px;
            background: var(--red);
        }

        .about-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(30px, 3.2vw, 46px);
            font-weight: 900;
            line-height: 1.12;
            color: var(--navy);
            margin-bottom: 24px;
        }

        .about-title em {
            font-style: italic;
            color: var(--red);
        }

        .about-text {
            font-size: 15px;
            font-weight: 300;
            line-height: 1.9;
            color: var(--muted);
            margin-bottom: 18px;
        }

        .about-highlight {
            background: var(--navy);
            border-radius: 10px;
            padding: 20px 24px;
            margin-top: 32px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .ah-icon {
            width: 32px;
            /* Sedikit lebih besar dari font-size agar proporsional */
            height: 32px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ah-icon svg {
            width: 100%;
            height: 100%;
            /* Gunakan warna putih dengan sedikit opasitas agar terlihat elegan di background gelap */
            color: rgba(255, 255, 255, 0.8);
            stroke-width: 1.8;
            /* Ketebalan garis agar tidak terlalu berat */
        }

        .ah-text {
            font-size: 13px;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.65);
        }

        .ah-text strong {
            color: var(--white);
        }

        /* About right: stacked cards */
        .about-cards {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .about-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            transition: all 0.25s;
        }

        .about-card-icon {
            width: 44px;
            height: 44px;
            flex-shrink: 0;
            background: rgba(192, 57, 43, 0.08);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .about-card-icon svg {
            width: 22px;
            /* Ukuran ikon di dalam kotak */
            height: 22px;
            color: #c0392b;
            /* Warna merah tegas untuk garis ikon */
            stroke-width: 2;
        }

        .about-card-title {
            font-size: 14px;
            font-weight: 500;
            color: var(--navy);
            margin-bottom: 5px;
        }

        .about-card-desc {
            font-size: 13px;
            font-weight: 300;
            color: var(--muted);
            line-height: 1.65;
        }

        /* ══════════════════════════════════
       barang UNGGULAN
    ══════════════════════════════════ */
        .products {
            padding: 100px 72px;
            background: var(--navy);
            position: relative;
            overflow: hidden;
        }

        .products::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.015) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.015) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        .section-head {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 52px;
            position: relative;
            z-index: 2;
        }

        .section-label {
            font-family: 'DM Mono', monospace;
            font-size: 10px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.35);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-label::before {
            content: '';
            width: 28px;
            height: 2px;
            background: var(--red);
        }

        .section-title-light {
            font-family: 'Playfair Display', serif;
            font-size: clamp(28px, 3vw, 40px);
            font-weight: 900;
            color: var(--white);
            line-height: 1.15;
        }

        .section-title-light em {
            font-style: italic;
            color: rgba(255, 255, 255, 0.45);
        }

        .prod-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            position: relative;
            z-index: 2;
        }

        .prod-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.25s;
        }

        .prod-card:hover {
            background: rgba(255, 255, 255, 0.07);
            border-color: rgba(192, 57, 43, 0.35);
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.3);
        }

        .prod-card-img {
            height: 130px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.03);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .prod-card-img svg {
            width: 58px;
            height: 58px;
            stroke: rgba(255, 255, 255, 0.92);
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .prod-card--paint .prod-card-img {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.18), rgba(239, 68, 68, 0.06));
        }

        .prod-card--electric .prod-card-img {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.20), rgba(34, 197, 94, 0.06));
        }

        .prod-card--accessory .prod-card-img {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.20), rgba(245, 158, 11, 0.06));
        }

        .prod-card--tools .prod-card-img {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.20), rgba(59, 130, 246, 0.06));
        }

        .prod-card--material .prod-card-img {
            background: linear-gradient(135deg, rgba(168, 85, 247, 0.20), rgba(168, 85, 247, 0.06));
        }

        .prod-card--building .prod-card-img {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.22), rgba(14, 165, 233, 0.06));
        }

        .prod-card-body {
            padding: 16px;
        }

        .prod-card-cat {
            font-size: 9px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--red-light);
            font-weight: 500;
            margin-bottom: 6px;
        }

        .prod-card-name {
            font-size: 14px;
            font-weight: 500;
            color: var(--white);
            margin-bottom: 5px;
            line-height: 1.3;
        }

        .prod-card-desc {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.38);
            font-weight: 300;
            line-height: 1.6;
        }

        .prod-more {
            text-align: center;
            margin-top: 40px;
            position: relative;
            z-index: 2;
        }

        /* ══════════════════════════════════
       KEUNGGULAN
    ══════════════════════════════════ */
        .keunggulan {
            padding: 100px 72px;
            background: var(--bg);
        }

        .keunggulan-header {
            text-align: center;
            margin-bottom: 64px;
        }

        .keunggulan-label {
            font-family: 'DM Mono', monospace;
            font-size: 10px;
            color: var(--red);
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 14px;
            display: block;
        }

        .keunggulan-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(28px, 3vw, 42px);
            font-weight: 900;
            color: var(--navy);
            line-height: 1.15;
        }

        .keunggulan-title em {
            font-style: italic;
            color: var(--red);
        }

        .keunggulan-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .keung-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 36px 28px;
            transition: all 0.25s;
            position: relative;
            overflow: hidden;
        }

        .keung-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: transparent;
            transition: background 0.25s;
        }

        .keung-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 40px rgba(26, 35, 50, 0.1);
            border-color: rgba(192, 57, 43, 0.2);
        }

        .keung-card:hover::before {
            background: var(--red);
        }

        .keung-num {
            font-family: 'Playfair Display', serif;
            font-size: 48px;
            font-weight: 900;
            color: rgba(26, 35, 50, 0.06);
            line-height: 1;
            margin-bottom: 12px;
        }

        .keung-icon {
            margin-bottom: 16px;
            display: flex;
            /* Menggunakan flex agar ikon mudah diatur posisinya */
            align-items: center;
            justify-content: flex-start;
            /* Ikon rata kiri sesuai teks */
            height: 40px;
            /* Memberikan ruang tinggi yang konsisten */
        }

        /* Mengatur ukuran dan warna ikon SVG */
        .keung-icon svg {
            width: 32px;
            /* Ukuran yang mirip dengan font-size 30px Anda sebelumnya */
            height: 32px;
            color: #c0392b;
            /* Warna merah bata khas Toko Mekar Jaya */
            stroke-width: 2;
            /* Ketebalan garis agar terlihat jelas */
            transition: all 0.3s ease;
        }

        .keung-title {
            font-size: 16px;
            font-weight: 500;
            color: var(--navy);
            margin-bottom: 10px;
        }

        .keung-desc {
            font-size: 13px;
            font-weight: 300;
            color: var(--muted);
            line-height: 1.75;
        }

        /* ══════════════════════════════════
       JAM OPERASIONAL + KONTAK
    ══════════════════════════════════ */
        .info-section {
            padding: 100px 72px;
            background: var(--navy);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 72px;
            align-items: start;
            position: relative;
            overflow: hidden;
        }

        .info-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.015) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.015) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        .info-col {
            position: relative;
            z-index: 2;
        }

        .info-label {
            font-family: 'DM Mono', monospace;
            font-size: 10px;
            color: rgba(255, 255, 255, 0.35);
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-label::before {
            content: '';
            width: 28px;
            height: 2px;
            background: var(--red);
        }

        .info-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(26px, 2.8vw, 38px);
            font-weight: 900;
            color: var(--white);
            line-height: 1.15;
            margin-bottom: 32px;
        }

        /* Jam operasional table */
        .jam-table {
            width: 100%;
        }

        .jam-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            font-size: 14px;
        }

        .jam-row:last-child {
            border-bottom: none;
        }

        .jam-day {
            color: rgba(255, 255, 255, 0.55);
            font-weight: 300;
        }

        .jam-time {
            color: var(--white);
            font-weight: 400;
        }

        .jam-badge {
            font-size: 10px;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .jam-badge.open {
            background: rgba(30, 126, 52, 0.2);
            color: #5adb7a;
            border: 1px solid rgba(90, 219, 122, 0.2);
        }

        /* Kontak cards container */
        .kontak-cards {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        /* Kartu kontak utama */
        .kontak-card {
            background: rgba(255, 255, 255, 0.04);
            /* Background kartu gelap transparan */
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            padding: 18px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: all 0.3s;
            cursor: default;
            /* Kursor panah standar */
        }

        /* KUNCI PERUBAHAN: Kotak Alas Ikon */
        .kontak-card-icon {
            /* Ukuran kotak alas */
            width: 40px;
            height: 40px;
            flex-shrink: 0;

            /* Perubahan alas (kotak latar belakang) */
            background: rgba(192, 57, 43, 0.15);
            /* Merah bata transparan */
            border: 1px solid rgba(192, 57, 43, 0.25);
            /* Border tipis merah */
            border-radius: 6px;
            /* Sesuai permintaan Anda */

            /* Penyelarasan ikon SVG di tengah */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Mengatur ukuran dan warna ikon SVG di dalamnya */
        .kontak-card-icon svg {
            width: 20px;
            /* Ukuran ikon SVG */
            height: 20px;
            color: #c0392b;
            /* Warna merah tegas untuk garis ikon */
            stroke-width: 1.8;
            /* Ketebalan garis agar seimbang */
        }

        /* Label & Nilai Kontak */
        .kontak-card-label {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.35);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .kontak-card-val {
            font-size: 14px;
            color: #ffffff;
            /* Putih bersih agar kontras */
            font-weight: 400;
        }

        /* ══════════════════════════════════
       CTA BOTTOM
    ══════════════════════════════════ */
        .cta-bottom {
            background: var(--bg);
            padding: 80px 72px;
        }


        .cta-text-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(26px, 2.8vw, 38px);
            font-weight: 900;
            color: var(--white);
            line-height: 1.15;
        }

        .btn-white {
            background: var(--white);
            color: var(--red);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            padding: 16px 36px;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            position: relative;
            z-index: 2;
        }

        .btn-white:hover {
            background: rgba(255, 255, 255, 0.85);
        }

        /* ══════════════════════════════════
       FOOTER
    ══════════════════════════════════ */
        footer {
            background: #e8ecf0;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            padding: 52px 72px 32px;
        }

        .footer-top {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 56px;
            padding-bottom: 40px;
            border-bottom: 1px solid rgba(15, 23, 42, 0.12);
        }

        .footer-brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            color: #0F172A;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-brand-name span {
            width: 10px;
            height: 10px;
            background: var(--red);
            border-radius: 2px;
        }

        .footer-brand-desc {
            font-size: 13px;
            font-weight: 300;
            line-height: 1.8;
            color: rgba(15, 23, 42, 0.72);
            max-width: 280px;
        }

        .footer-col-title {
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(15, 23, 42, 0.62);
            margin-bottom: 20px;
        }

        .footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .footer-links a {
            font-size: 13px;
            color: rgba(15, 23, 42, 0.68);
            text-decoration: none;
            transition: color 0.3s;
            font-weight: 300;
        }

        .footer-links a:hover {
            color: rgba(15, 23, 42, 0.95);
        }

        .footer-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 28px;
            font-size: 12px;
            color: rgba(15, 23, 42, 0.56);
        }

        .footer-bottom strong {
            color: rgba(15, 23, 42, 0.78);
        }

        /* ══════════════════════════════════
       ANIMATIONS & SCROLL REVEAL
    ══════════════════════════════════ */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.65s ease, transform 0.65s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-delay-1 {
            transition-delay: 0.1s;
        }

        .reveal-delay-2 {
            transition-delay: 0.2s;
        }

        .reveal-delay-3 {
            transition-delay: 0.3s;
        }

        .reveal-delay-4 {
            transition-delay: 0.4s;
        }

        .reveal-delay-5 {
            transition-delay: 0.5s;
        }

        /* ══════════════════════════════════
       RESPONSIVE
    ══════════════════════════════════ */
        @media (max-width: 1024px) {
            .prod-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 900px) {
            .nav {
                padding: 0 28px;
            }

            .nav-links {
                display: none;
            }

            .nav-hamburger {
                display: flex;
            }

            .hero {
                grid-template-columns: 1fr;
            }

            .hero-left {
                padding: 60px 28px 48px;
            }

            .hero-right {
                display: none;
            }

            .trust-bar {
                gap: 20px;
                flex-wrap: wrap;
            }

            .about {
                grid-template-columns: 1fr;
                padding: 64px 28px;
                gap: 40px;
            }

            .products {
                padding: 64px 28px;
            }

            .prod-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .keunggulan {
                padding: 64px 28px;
            }

            .keunggulan-grid {
                grid-template-columns: 1fr;
            }

            .info-section {
                grid-template-columns: 1fr;
                padding: 64px 28px;
                gap: 48px;
            }

            .cta-bottom {
                padding: 48px 28px;
            }

            footer {
                padding: 40px 28px 24px;
            }

            .footer-top {
                grid-template-columns: 1fr;
                gap: 36px;
            }

            .footer-bottom {
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }
        }

        @media (max-width: 600px) {
            .prod-grid {
                grid-template-columns: 1fr;
            }

            .section-head {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
        }
    </style>
</head>

<body>

    <!-- ══════════════ NAV ══════════════ -->
    <nav class="nav" id="mainNav">
        <div class="nav-logo">
            <div class="logo-box">
                <img src="{{ asset('images/NavMekarJaya.png') }}" alt="Logo Mekar Jaya">
            </div>
            <div class="nav-logo-text">
                <div class="nav-logo-name">Mekar <span>Jaya</span></div>
                <div class="nav-logo-sub">Toko Besi & Bahan Bangunan</div>
            </div>
        </div>

        <ul class="nav-links">
            <li><a href="#tentang">Tentang Kami</a></li>
            <li><a href="#barang">Barang</a></li>
            <li><a href="#keunggulan">Keunggulan</a></li>
            <li><a href="#kontak">Kontak</a></li>
        </ul>

        <div class="nav-hamburger" onclick="toggleMenu()">
            <span></span><span></span><span></span>
        </div>
    </nav>

    <!-- ══════════════ HERO ══════════════ -->
    <section class="hero">
        <div class="hero-left">
            <div class="hero-eyebrow">
                <div class="hero-eyebrow-line"></div>
                <div class="hero-eyebrow-text">Berdiri sejak 1998 · Jl. Yos Sudarso No.184</div>
            </div>

            <h1 class="hero-title">Toko Besi &<br><em>Bahan Bangunan</em></h1>
            <div class="hero-title-sub">Terpercaya di Kota Anda</div>

            <p class="hero-desc">
                Mekar Jaya menyediakan berbagai kebutuhan bahan bangunan dan peralatan untuk Anda. Kami siap
                membantu memberikan pilihan terbaik agar rencana pembangunan Anda berjalan lancar.
            </p>

            <div class="hero-actions">
                <a href="#barang" class="btn-red">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73z">
                        </path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                    Kategori Barang
                </a>
                <a href="#kontak" class="btn-ghost">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    Lokasi Toko
                </a>
            </div>

            <div class="trust-bar">
                <div class="trust-item">
                    <div class="trust-num">25+</div>
                    <div class="trust-label">Tahun Berkarya</div>
                </div>
                <div class="trust-item">
                    <div class="trust-num">±200</div>
                    <div class="trust-label">Jenis Barang</div>
                </div>
            </div>
        </div>

        <div class="hero-right">
            <div class="hero-visual">
                <div class="store-card">
                    <div class="store-card-header">
                        <div class="store-card-icon">
                            <img src="{{ asset('images/NavMekarJaya.png') }}" alt="Icon Mekar Jaya">
                        </div>
                        <div>
                            <div class="store-card-name">Toko Mekar Jaya</div>
                            <div class="store-card-addr">Jl. Yos Sudarso No.184</div>
                        </div>
                    </div>
                    <div class="store-card-body">
                        <div class="store-info-row">
                            <div class="store-info-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                            <div>
                                <div class="store-info-label">Alamat</div>
                                <div class="store-info-val">Jl. Yos Sudarso No.184, Panjang Utara, Kec. Panjang, Kota
                                    Bandar Lampung, Lampung 35145</div>
                            </div>
                        </div>

                        <div class="store-info-row">
                            <div class="store-info-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                            </div>
                            <div>
                                <div class="store-info-label">Jam Operasional</div>
                                <div class="store-info-val">Setiap Hari · 08.00 – 17.00</div>
                            </div>
                        </div>

                        <div class="store-info-row">
                            <div class="store-info-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <div class="store-info-label">WhatsApp</div>
                                <div class="store-info-val">0821-7533-0610</div>
                            </div>
                        </div>

                        <div class="store-info-row">
                            <div class="store-info-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73z">
                                    </path>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                    <line x1="11" y1="22.08" x2="12" y2="12"></line>
                                </svg>
                            </div>
                            <div>
                                <div class="store-info-label">Ketersediaan Barang</div>
                                <div class="store-info-val">Berbagai macam jenis alat dan bahan bangunan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ══════════════ TENTANG ══════════════ -->
    <section class="about" id="tentang">
        <div class="reveal">
            <div class="about-label">Tentang Kami</div>
            <h2 class="about-title">Lebih dari Sekadar<br><em>Toko Bangunan</em></h2>
            <p class="about-text">
                Berdiri sejak 1998, Toko Mekar Jaya menyediakan berbagai kebutuhan material besi dan bahan bangunan.
                Toko ini melayani kebutuhan kontraktor, pemborong, maupun pemilik rumah.
            </p>
            <p class="about-text">
                Berlokasi di Jl. Yos Sudarso No.184, toko ini mudah dijangkau dan menyediakan berbagai jenis barang
                dengan stok yang tersedia di toko.
            </p>
            <div class="about-highlight">
                <div class="ah-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                        </path>
                    </svg>
                </div>
                <div class="ah-text">
                    <strong>"Kepuasan pelanggan adalah prioritas kami."</strong><br>
                    Kami berkomitmen memberikan barang yang berkualitas dengan harga yang terjangkau dan pelayanan yang
                    memuaskan.
                </div>
            </div>
        </div>

        <div class="reveal reveal-delay-2">
            <div class="about-cards">
                <div class="about-card">
                    <div class="about-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73z">
                            </path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                    </div>
                    <div>
                        <div class="about-card-title">Material Lengkap</div>
                        <div class="about-card-desc">Mulai dari besi, cat, pipa, hingga keramik tersedia di satu tempat
                            untuk kebutuhan bangunan Anda.</div>
                    </div>
                </div>

                <div class="about-card">
                    <div class="about-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                            <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                            <line x1="9" y1="12" x2="15" y2="12"></line>
                            <line x1="9" y1="16" x2="15" y2="16"></line>
                            <line x1="10" y1="8" x2="14" y2="8"></line>
                        </svg>
                    </div>
                    <div>
                        <div class="about-card-title">Bebas Konsultasi</div>
                        <div class="about-card-desc">Kami siap membantu memberikan informasi material yang sesuai
                            dengan kebutuhan dan anggaran yang dimiliki.
                        </div>
                    </div>
                </div>

                <div class="about-card">
                    <div class="about-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="1" y="3" width="15" height="13"></rect>
                            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                            <circle cx="5.5" cy="18.5" r="2.5"></circle>
                            <circle cx="18.5" cy="18.5" r="2.5"></circle>
                        </svg>
                    </div>
                    <div>
                        <div class="about-card-title">Layanan Pengiriman</div>
                        <div class="about-card-desc">Pesanan dapat diantar ke lokasi apabila jumlah atau
                            ukurannya tidak memungkinkan dibawa sendiri.</div>
                    </div>
                </div>

                <div class="about-card">
                    <div class="about-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg>
                    </div>
                    <div>
                        <div class="about-card-title">Berbagai Pembayaran</div>
                        <div class="about-card-desc">Pembayaran dapat dilakukan secara tunai maupun melalui transfer
                            BCA sesuai kebutuhan transaksi.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ══════════════ barang ══════════════ -->
    <section class="products" id="barang">
        <div class="section-head">
            <div>
                <div class="section-label">Barang Kami</div>
                <h2 class="section-title-light">Kategori Barang<br><em>yang Tersedia</em></h2>
            </div>
        </div>

        <div class="prod-grid">
            <div class="prod-card prod-card--paint reveal">
                <div class="prod-card-img">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M14 3l7 7"></path>
                        <path d="M12 5l7 7"></path>
                        <path d="M2 13l10.5-10.5a2.12 2.12 0 0 1 3 3L5 16l-3 1 1-4z"></path>
                        <path d="M15 6l3 3"></path>
                        <path d="M7.5 16.5c.5 1.5 2 3 4.5 3 3 0 4-2.2 4-4.2V13"></path>
                    </svg>
                </div>
                <div class="prod-card-body">
                    <div class="prod-card-cat">Kategori</div>
                    <div class="prod-card-name">Cat &amp; Finishing</div>
                    <div class="prod-card-desc">Tersedia berbagai pilihan cat tembok dan bahan finishing
                        untuk hasil akhir yang rapi dan tahan lama.</div>
                </div>
            </div>
            <div class="prod-card prod-card--electric reveal reveal-delay-1">
                <div class="prod-card-img">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M13 2L3 14h7l-1 8 12-14h-7l-1-6z"></path>
                    </svg>
                </div>
                <div class="prod-card-body">
                    <div class="prod-card-cat">Kategori</div>
                    <div class="prod-card-name">Kelistrikan</div>
                    <div class="prod-card-desc">Menyediakan perlengkapan listrik seperti lampu, steker, fitting, dan
                        stop kontak.</div>
                </div>
            </div>
            <div class="prod-card prod-card--accessory reveal reveal-delay-2">
                <div class="prod-card-img">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M21 16l-4 4-7-7 4-4 7 7z"></path>
                        <path d="M7.5 6.5l4 4"></path>
                        <path d="M5 8l3-3"></path>
                        <path d="M9 4l-3 3"></path>
                        <path d="M3 21l6.5-6.5"></path>
                    </svg>
                </div>
                <div class="prod-card-body">
                    <div class="prod-card-cat">Kategori</div>
                    <div class="prod-card-name">Aksesoris</div>
                    <div class="prod-card-desc">Beragam aksesoris pendukung bangunan seperti kunci, gembok, dan tandon
                        air.</div>
                </div>
            </div>
            <div class="prod-card prod-card--tools reveal reveal-delay-3">
                <div class="prod-card-img">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path
                            d="M14.7 6.3a4 4 0 0 0-5.7 5.6L3 18l3 3 6.1-6a4 4 0 0 0 5.6-5.7l-2.2 2.2-2.5-2.5 1.7-2.7z">
                        </path>
                    </svg>
                </div>
                <div class="prod-card-body">
                    <div class="prod-card-cat">Kategori</div>
                    <div class="prod-card-name">Alat Teknik</div>
                    <div class="prod-card-desc">Tersedia berbagai alat teknik yang membantu pekerjaan konstruksi dan
                        perbaikan.</div>
                </div>
            </div>
            <div class="prod-card prod-card--material reveal reveal-delay-4">
                <div class="prod-card-img">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M3 10h18"></path>
                        <path d="M3 14h18"></path>
                        <path d="M7 10v4"></path>
                        <path d="M17 10v4"></path>
                        <path d="M21 6H3v12h18V6z"></path>
                        <path d="M6 18v2h12v-2"></path>
                    </svg>
                </div>
                <div class="prod-card-body">
                    <div class="prod-card-cat">Kategori</div>
                    <div class="prod-card-name">Bahan Bangunan</div>
                    <div class="prod-card-desc">Menyediakan bahan bangunan utama untuk kebutuhan pembangunan maupun
                        renovasi.</div>
                </div>
            </div>

            <div class="prod-card prod-card--building reveal reveal-delay-5">
                <div class="prod-card-img">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M3 21h18"></path>
                        <path d="M5 21V9l7-5 7 5v12"></path>
                        <path d="M9 21v-7h6v7"></path>
                        <path d="M9 11h.01"></path>
                        <path d="M15 11h.01"></path>
                    </svg>
                </div>
                <div class="prod-card-body">
                    <div class="prod-card-cat">Kategori</div>
                    <div class="prod-card-name">Alat Bangunan</div>
                    <div class="prod-card-desc">Peralatan bangunan dan konstruksi untuk mendukung pekerjaan proyek,
                        perbaikan, dan renovasi.</div>
                </div>
            </div>
        </div>

        <div class="prod-more reveal">
            <a href="#kontak" class="btn-ghost" style="border-color:rgba(255,255,255,0.25);">
                Tanya Ketersediaan Barang
            </a>
        </div>
    </section>

    <!-- ══════════════ KEUNGGULAN ══════════════ -->
    <section class="keunggulan" id="keunggulan">
        <div class="keunggulan-header reveal">
            <span class="keunggulan-label">Mengapa Pilih Kami</span>
            <h2 class="keunggulan-title">Keunggulan yang Membuat<br><em>Kami Berbeda</em></h2>
        </div>

        <div class="keunggulan-grid">
            <div class="keung-card reveal">
                <div class="keung-num">01</div>
                <span class="keung-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="7"></circle>
                        <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                    </svg>
                </span>
                <div class="keung-title">Kualitas Barang Terjamin</div>
                <div class="keung-desc">Kami memastikan setiap barang dalam kondisi baik dan siap digunakan.</div>
            </div>
            <div class="keung-card reveal reveal-delay-1">
                <div class="keung-num">02</div>
                <span class="keung-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                        <line x1="7" y1="7" x2="7.01" y2="7"></line>
                    </svg>
                </span>
                <div class="keung-title">Harga Terjangkau</div>
                <div class="keung-desc">Kami menawarkan harga terjangkau untuk berbagai kebutuhan bangunan Anda.
                </div>
            </div>
            <div class="keung-card reveal reveal-delay-2">
                <div class="keung-num">03</div>
                <span class="keung-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z">
                        </path>
                        <path d="m3.3 7 8.7 5 8.7-5"></path>
                        <path d="M12 22V12"></path>
                    </svg>
                </span>
                <div class="keung-title">Stok Barang Lengkap</div>
                <div class="keung-desc">Kami menjaga ketersediaan berbagai barang bangunan agar kebutuhan Anda dapat
                    terpenuhi.</div>
            </div>
            <div class="keung-card reveal">
                <div class="keung-num">04</div>
                <span class="keung-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </span>
                <div class="keung-title">Siap Membantu Anda</div>
                <div class="keung-desc">Kami siap membantu Anda memilih barang yang sesuai dengan kebutuhan bangunan
                    Anda.</div>
            </div>
            <div class="keung-card reveal reveal-delay-1">
                <div class="keung-num">05</div>
                <span class="keung-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="1" y="3" width="15" height="13"></rect>
                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                    </svg>
                </span>
                <div class="keung-title">Layanan Pengiriman</div>
                <div class="keung-desc">Kami menyediakan layanan pengiriman untuk memudahkan Anda menerima barang di
                    lokasi yang diinginkan.</div>
            </div>
            <div class="keung-card reveal reveal-delay-2">
                <div class="keung-num">06</div>
                <span class="keung-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                        <path d="M3 5V19A9 3 0 0 0 21 19V5"></path>
                        <path d="M3 12A9 3 0 0 0 21 12"></path>
                    </svg>
                </span>
                <div class="keung-title">Sistem Pengelolaan Toko</div>
                <div class="keung-desc">Kami menerapkan sistem pengelolaan toko yang membantu menjaga ketersediaan
                    barang dan memudahkan pelayanan.</div>
            </div>
        </div>
    </section>

    <!-- ══════════════ JAM + KONTAK ══════════════ -->
    <section class="info-section" id="kontak">
        <div class="info-col reveal">
            <div class="info-label">Jam Operasional</div>
            <h2 class="info-title">Kapan Kami<br>Buka?</h2>

            <div class="jam-table">
                <div class="jam-row">
                    <div class="jam-day">Senin</div>
                    <div class="jam-time">08.00 – 17.00</div>
                    <div class="jam-badge open">Buka</div>
                </div>
                <div class="jam-row">
                    <div class="jam-day">Selasa</div>
                    <div class="jam-time">08.00 – 17.00</div>
                    <div class="jam-badge open">Buka</div>
                </div>
                <div class="jam-row">
                    <div class="jam-day">Rabu</div>
                    <div class="jam-time">08.00 – 17.00</div>
                    <div class="jam-badge open">Buka</div>
                </div>
                <div class="jam-row">
                    <div class="jam-day">Kamis</div>
                    <div class="jam-time">08.00 – 17.00</div>
                    <div class="jam-badge open">Buka</div>
                </div>
                <div class="jam-row">
                    <div class="jam-day">Jumat</div>
                    <div class="jam-time">08.00 – 17.00</div>
                    <div class="jam-badge open">Buka</div>
                </div>
                <div class="jam-row">
                    <div class="jam-day">Sabtu</div>
                    <div class="jam-time">08.00 – 17.00</div>
                    <div class="jam-badge open">Buka</div>
                </div>
                <div class="jam-row">
                    <div class="jam-day">Minggu</div>
                    <div class="jam-time">08.00 – 17.00</div>
                    <div class="jam-badge open">Buka</div>
                </div>
            </div>
        </div>

        <div class="info-col reveal reveal-delay-2">
            <div class="info-label">Hubungi Kami</div>
            <h2 class="info-title">Ada Pertanyaan?<br>Kami Siap Bantu.</h2>

            <div class="kontak-cards">
                <div class="kontak-card">
                    <div class="kontak-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <div>
                        <div class="kontak-card-label">Alamat</div>
                        <div class="kontak-card-val">Jl. Yos Sudarso No.184, Panjang Utara, Kec. Panjang, Kota
                            Bandar Lampung, Lampung 35145</div>
                    </div>
                </div>

                <div class="kontak-card">
                    <div class="kontak-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <div class="kontak-card-label">Telepon</div>
                        <div class="kontak-card-val">072131154</div>
                    </div>
                </div>

                <div class="kontak-card">
                    <div class="kontak-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <div class="kontak-card-label">WhatsApp</div>
                        <div class="kontak-card-val">0821-7533-0610</div>
                    </div>
                </div>

                <div class="kontak-card">
                    <div class="kontak-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                            </path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </div>
                    <div>
                        <div class="kontak-card-label">Email</div>
                        <div class="kontak-card-val">chandraayie77@gmail.com</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ══════════════ FOOTER ══════════════ -->
    <footer>
        <div class="footer-top">
            <div>
                <div class="footer-brand-name"><span></span> Toko Mekar Jaya</div>
                <div class="footer-brand-desc">
                    Toko besi dan bahan bangunan sejak 1998. Menyediakan berbagai kebutuhan material untuk pembangunan
                    dan perbaikan bangunan.
                </div>
            </div>
            <div>
                <div class="footer-col-title">Navigasi</div>
                <ul class="footer-links">
                    <li><a href="#tentang">Tentang Kami</a></li>
                    <li><a href="#barang">Barang</a></li>
                    <li><a href="#keunggulan">Keunggulan</a></li>
                    <li><a href="#kontak">Kontak</a></li>
                </ul>
            </div>
            <div>
                <div class="footer-col-title">Informasi</div>
                <ul class="footer-links">
                    <li><a href="/login">Login</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <div>© 2026 <strong>Toko Mekar Jaya</strong> · Jl. Yos Sudarso No.184</div>
        </div>
    </footer>

    <script>
        /* Sticky nav shadow */
        window.addEventListener('scroll', () => {
            document.getElementById('mainNav').classList.toggle('scrolled', window.scrollY > 40);
        });

        /* Scroll reveal */
        const reveals = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) e.target.classList.add('visible');
            });
        }, {
            threshold: 0.12
        });
        reveals.forEach(el => observer.observe(el));

        /* Hamburger (mobile) */
        function toggleMenu() {
            const links = document.querySelector('.nav-links');
            if (links.style.display === 'flex') {
                links.style.display = 'none';
            } else {
                links.style.cssText = `
        display: flex; flex-direction: column; gap: 0;
        position: fixed; top: 68px; left: 0; right: 0;
        background: #1a2332; padding: 16px 28px 24px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
      `;
            }
        }

        /* Highlight active nav link */
        const sections = document.querySelectorAll('section[id]');
        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(s => {
                if (window.scrollY >= s.offsetTop - 100) current = s.id;
            });
            document.querySelectorAll('.nav-links a').forEach(a => {
                a.style.color = a.getAttribute('href') === '#' + current ?
                    'rgba(255,255,255,0.95)' : 'rgba(255,255,255,0.55)';
            });
        });
    </script>
</body>

</html>
