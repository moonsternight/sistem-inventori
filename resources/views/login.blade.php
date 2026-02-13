<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="icon" type="image/png" href="{{ asset('images/MekarJaya.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        body {
            background-image: url("{{ asset('images/Login.jpg') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            display: grid;
            place-items: center;
            height: 100vh;
            height: 100svh;
            height: 100dvh;
            padding: 0;
            font-family: 'Inter', sans-serif;
            position: relative;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid #FFFFFF;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
            padding: 36px 22px;
            border-radius: 24px;
            width: 100%;
            max-width: 420px;
            margin: 24px 16px;
            text-align: center;
            position: relative;
            z-index: 10;
        }

        @media (max-width: 1023.98px) {
            body {
                padding: 0 !important;
                overflow-y: hidden !important;
                overflow-x: hidden !important;
                background-attachment: scroll;
            }

            .login-card {
                margin: 0;
                width: calc(100vw - 16px);
                max-width: 420px;
                justify-self: center;
                align-self: center;
            }
        }

        .login-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent 45%, rgba(255, 255, 255, 0.1) 50%, transparent 55%);
            pointer-events: none;
            z-index: -1;
        }

        .avatar-circle {
            width: 80px;
            height: 80px;
            background-color: #0f172a;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 2px;
            color: #334155;
            font-weight: 800;
            letter-spacing: -0.025em;
            font-size: 18px;
        }

        p {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .pin-input {
            width: 100%;
            border: none;
            border-bottom: 1px solid #64748b;
            background: transparent;
            text-align: center;
            font-size: 28px;
            letter-spacing: 8px;
            margin-bottom: 20px;
            outline: none;
            color: #1e293b;
            caret-color: #0F172A;
            transition: border-color 0.3s;
        }

        .pin-input:focus {
            border-bottom-color: #0F172A;
        }

        .pin-input::placeholder {
            color: #64748b;
            letter-spacing: 8px;
        }

        .btn-masuk {
            width: 100%;
            padding: 14px;
            background-color: #0f172a;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-masuk:hover {
            transition: all 0.3s ease;
            background-color: #1e293b;
        }

        .alert-error {
            color: #e11d48;
            background: #fff1f2;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
            border: 1.5px solid #fda4af;
        }

        .footer-text {
            margin-top: 20px;
            font-size: 12px;
            color: #64748b;
        }

        .footer-text strong {
            color: #475569;
        }

        input::-ms-reveal,
        input::-ms-clear {
            display: none;
        }

        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            background: rgba(255, 255, 255, 0.2);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .loader {
            position: relative;
            width: 60px;
            height: 60px;
        }

        .loader div {
            position: absolute;
            width: 10%;
            height: 10%;
            background: #1e293b;
            left: 45%;
            top: 45%;
            border-radius: 50px;
            animation: fade-loading 1.2s linear infinite;
        }

        .loader div:nth-child(1) {
            transform: rotate(0deg) translate(0, -250%);
            animation-delay: 0s;
        }

        .loader div:nth-child(2) {
            transform: rotate(30deg) translate(0, -250%);
            animation-delay: -1.1s;
        }

        .loader div:nth-child(3) {
            transform: rotate(60deg) translate(0, -250%);
            animation-delay: -1s;
        }

        .loader div:nth-child(4) {
            transform: rotate(90deg) translate(0, -250%);
            animation-delay: -0.9s;
        }

        .loader div:nth-child(5) {
            transform: rotate(120deg) translate(0, -250%);
            animation-delay: -0.8s;
        }

        .loader div:nth-child(6) {
            transform: rotate(150deg) translate(0, -250%);
            animation-delay: -0.7s;
        }

        .loader div:nth-child(7) {
            transform: rotate(180deg) translate(0, -250%);
            animation-delay: -0.6s;
        }

        .loader div:nth-child(8) {
            transform: rotate(210deg) translate(0, -250%);
            animation-delay: -0.5s;
        }

        .loader div:nth-child(9) {
            transform: rotate(240deg) translate(0, -250%);
            animation-delay: -0.4s;
        }

        .loader div:nth-child(10) {
            transform: rotate(270deg) translate(0, -250%);
            animation-delay: -0.3s;
        }

        .loader div:nth-child(11) {
            transform: rotate(300deg) translate(0, -250%);
            animation-delay: -0.2s;
        }

        .loader div:nth-child(12) {
            transform: rotate(330deg) translate(0, -250%);
            animation-delay: -0.1s;
        }

        @keyframes fade-loading {
            0% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }

        @media (min-width: 640px) {
            .login-card {
                padding: 44px 28px;
                border-radius: 26px;
                max-width: 460px;
                margin: 32px 24px;
            }

            .pin-input {
                font-size: 32px;
                letter-spacing: 10px;
            }
        }

        @media (min-width: 1024px) {
            .login-card {
                padding: 50px 30px;
                max-width: 480px;
                margin: 40px;
            }
        }

        @media (max-width: 360px) {
            .login-card {
                padding: 28px 18px;
                border-radius: 20px;
            }

            .pin-input {
                font-size: 24px;
                letter-spacing: 6px;
            }
        }
    </style>
</head>

<body>
    <div id="loading-overlay">
        <div class="loader">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <div class="login-card">
        <div class="avatar-circle">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"
                stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
        </div>

        <h2>Halo, Selamat Datang!</h2>
        <p>Silakan masukkan PIN Anda untuk masuk ke sistem.</p>

        @php
            $error = session('error');
            $lockoutTime = session('lockout_time');
            $rem = $lockoutTime ? $lockoutTime - time() : 0;
            if ($error === 'limit' && $rem <= 0) {
                session()->forget(['error', 'remaining', 'lockout_time']);
                $error = null;
            }
        @endphp

        @if ($error === 'limit')
            <div class="alert-error" id="error-container">
                @php
                    $m = str_pad(floor($rem / 60), 2, '0', STR_PAD_LEFT);
                    $s = str_pad($rem % 60, 2, '0', STR_PAD_LEFT);
                @endphp
                <span id="countdown-timer"
                    data-seconds="{{ $rem }}">[{{ $m }}:{{ $s }}]</span>
            </div>
        @elseif ($error && $error !== 'limit')
            <div class="alert-error" id="error-container">
                <span id="error-text">{{ $error }}</span>
            </div>
        @endif

        <form id="loginForm" action="{{ route('login.proses') }}" method="POST" novalidate>
            @csrf
            <input type="password" name="pin" class="pin-input" maxlength="6" placeholder="••••••" required
                autofocus inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                {{ $error === 'limit' ? 'disabled' : '' }}>
            <button type="submit" class="btn-masuk">Masuk</button>
        </form>

        <div class="footer-text">
            <strong>Mekar Jaya</strong> · Toko Besi & Bahan Bangunan<br>
            © 2026 · Developed by Billy
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const timerDisplay = document.getElementById('countdown-timer');
            const errorContainer = document.getElementById('error-container');
            const pinInput = document.querySelector('.pin-input');

            if (timerDisplay) {
                let time = parseInt(timerDisplay.getAttribute('data-seconds')) || 60;

                const countdown = setInterval(function() {
                    if (time <= 0) {
                        clearInterval(countdown);
                        if (errorContainer) errorContainer.remove();
                        if (pinInput) {
                            pinInput.disabled = false;
                            pinInput.focus();
                        }
                        return;
                    }

                    time--;
                    let minutes = Math.floor(time / 60);
                    let seconds = time % 60;

                    minutes = minutes < 10 ? '0' + minutes : minutes;
                    seconds = seconds < 10 ? '0' + seconds : seconds;

                    timerDisplay.innerHTML = `[${minutes}:${seconds}]`;
                }, 1000);
            }
        });

        const loginForm = document.getElementById('loginForm');
        const loadingOverlay = document.getElementById('loading-overlay');

        if (loginForm) {
            loginForm.addEventListener('submit', function() {
                const timerDisplay = document.getElementById('countdown-timer');
                if (timerDisplay) return false;

                loadingOverlay.style.display = 'flex';
                loadingOverlay.style.opacity = '1';

                const btn = this.querySelector('.btn-masuk');
                if (btn) btn.disabled = true;
            });
        }
    </script>
</body>

</html>
