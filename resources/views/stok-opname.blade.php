<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Stok Opname</title>
    <link rel="icon" type="image/png" href="{{ asset('images/MekarJaya.png') }}">
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            margin: 0;
            display: flex;
            height: 100vh;
            background-color: #F1F5F9;
            font-family: 'Inter', sans-serif;
            color: #1E293B;
        }

        .sidebar {
            width: 245px;
            background-color: #0f172a;
            display: flex;
            flex-direction: column;
            height: 100vh;
            flex-shrink: 0;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        .header-sidebar {
            padding: 25px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            box-sizing: border-box;
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
        }

        .title-box {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .title-box h1 {
            font-size: 13.5px;
            font-weight: 800;
            margin: 0;
            line-height: 1.5;
            color: #F8FAFC;
            text-transform: uppercase;
            white-space: nowrap;
            letter-spacing: 0.5px;
        }

        .title-box p {
            font-size: 10px;
            margin: 0;
            color: #94A3B8;
            white-space: nowrap;
            letter-spacing: 0.3px;
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            text-decoration: none;
            color: #94A3B8;
            font-size: 14px;
            font-weight: 500;
            gap: 12px;
            transition: all 0.3s ease;
            width: 100%;
            box-sizing: border-box;
            border-left: 4px solid transparent;
        }

        .nav-link:hover {
            background-color: #334155;
            color: #F8FAFC;
            transition: all 0.3s ease;
        }

        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            color: #FFFFFF;
            border-left: 4px solid #F8FAFC;
            transition: all 0.3s ease;
        }

        .nav-link:hover:not(.active) {
            background-color: rgba(255, 255, 255, 0.03);
            color: #F8FAFC;
            transition: all 0.3s ease;
        }

        .icon-circle {
            width: 32px;
            height: 32px;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .nav-link.active .icon-circle {
            background-color: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .icon-circle svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            stroke-width: 2.5;
            fill: none;
        }

        .main-container {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .page-header {
            background-color: #CBD5E1;
            padding: 10px 20px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border: 1.5px solid #94A3B8;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-title-icon,
        .user-profile-btn {
            width: 38px;
            height: 38px;
            background-color: #F8FAFC;
            border: 1.5px solid #94A3B8;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .header-title-icon {
            border-radius: 8px;
            color: #1E293B;
        }

        .user-profile-btn {
            border-radius: 50%;
            color: #1E293B;
            cursor: pointer;
        }

        .header-title-icon svg,
        .user-profile-btn svg {
            width: 18px;
            height: 18px;
        }

        .page-header h2 {
            font-size: 20px;
            font-weight: 800;
            margin: 0;
            color: #0F172A;
            letter-spacing: 0.5px;
        }

        .header-right {
            position: relative;
        }

        .user-profile-btn {
            background-color: #F8FAFC;
            border: 1.5px solid #94A3B8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1E293B;
        }

        .user-tooltip {
            visibility: hidden;
            width: 140px;
            background-color: #0F172A;
            color: #FFFFFF;
            text-align: center;
            border-radius: 8px;
            padding: 10px 10px;
            position: absolute;
            z-index: 10;
            right: 0;
            top: 45px;
            opacity: 0;
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
            pointer-events: none;
        }

        .user-tooltip::after {
            content: "";
            position: absolute;
            bottom: 100%;
            right: 13px;
            border-width: 6px;
            border-style: solid;
            border-color: transparent transparent #0F172A transparent;
        }

        .header-right:hover .user-tooltip {
            visibility: visible;
            opacity: 1;
        }

        .user-tooltip .name {
            display: block;
            font-size: 10px;
            font-weight: 700;
            color: #F8FAFC;
            margin-bottom: 3px;
            line-height: 1.2;
        }

        .user-tooltip .role {
            display: block;
            font-size: 8px;
            color: #94A3B8;
            margin-top: -2px;
            line-height: 1.2;
        }

        .opname-filter-wrapper {
            background-color: #CBD5E1;
            padding: 18px;
            border-radius: 8px;
            border: 1.5px solid #94A3B8;
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 18px;
            align-items: flex-end;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .form-group label {
            display: block;
            font-size: 11px;
            font-weight: 800;
            color: #0F172A;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .form-group select {
            width: 100%;
            height: 38px;
            border-radius: 8px;
            border: 1.5px solid #94A3B8;
            background-color: #F8FAFC;
            font-size: 12px;
            color: #1E293B;
            font-family: 'Inter', sans-serif;
            outline: none;
            box-sizing: border-box;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: none;
            text-align: center;
            text-align-last: center;
            cursor: pointer;
            padding: 0;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            height: 38px;
            border-radius: 8px;
            border: 1.5px solid #94A3B8;
            background-color: #F8FAFC;
            font-size: 12px;
            color: #1E293B;
            font-family: 'Inter', sans-serif;
            outline: none;
            box-sizing: border-box;
            padding: 0 15px;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #94A3B8 !important;
            outline: none !important;
            box-shadow: none !important;
        }

        .btn-opname {
            height: 38px;
            border-radius: 6px;
            border: 1.5px solid #64748B;
            text-transform: uppercase;
            font-weight: 800;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
            padding: 0 10px;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-tampilkan {
            background-color: #94A3B8;
            color: #1E293B;
            transition: all 0.3s ease;
        }

        .btn-tampilkan:hover {
            background-color: #64748B;
            color: #FFFFFF;
            border-color: #475569 !important;
            transition: all 0.3s ease;
        }

        .btn-excel {
            background-color: #F8FAFC;
            color: #475569;
            border: 1.5px solid #64748B;
            transition: all 0.3s ease;
        }

        .btn-excel:hover {
            background-color: #1e293b;
            border: 1.5px solid #0f172a;
            color: #FFFFFF;
            transition: all 0.3s ease;
        }

        .btn-import {
            background-color: #F8FAFC;
            color: #475569;
            border: 1.5px solid #64748B;
            transition: all 0.3s ease;
        }

        .btn-import:hover {
            background-color: #1e293b;
            border: 1.5px solid #0f172a;
            color: #FFFFFF;
            transition: all 0.3s ease;
        }

        .content-wrapper {
            background-color: #FFFFFF;
            border-radius: 8px;
            border: 1.5px solid #E2E8F0;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 100%;
        }

        table {
            width: 100% !important;
            max-width: 100%;
            table-layout: fixed;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 12px;
        }

        table th {
            background-color: #F8FAFC;
            color: #64748B;
            padding: 12px 8px;
            text-transform: uppercase;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.3px;
            white-space: nowrap;
            border-top: 1.5px solid #E2E8F0;
            border-bottom: 1.5px solid #E2E8F0;
        }

        table td {
            padding: 8px;
            border-bottom: 1.5px solid #F1F5F9;
            color: #1E293B;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        table th:first-child,
        table td:first-child {
            border-left: 1.5px solid #E2E8F0;
        }

        table th:last-child,
        table td:last-child {
            border-right: 1.5px solid #E2E8F0;
        }

        table thead tr th:first-child {
            border-top-left-radius: 8px;
        }

        table thead tr th:last-child {
            border-top-right-radius: 8px;
        }

        table tbody tr:last-child td {
            border-bottom: 1.5px solid #E2E8F0 !important;
        }

        table tbody tr:last-child td:first-child {
            border-bottom-left-radius: 8px;
        }

        table tbody tr:last-child td:last-child {
            border-bottom-right-radius: 8px;
        }

        .col-no {
            width: 50px;
        }

        .col-nama {
            width: 210px;
        }

        .col-merek {
            width: 150px;
        }

        .col-satuan {
            width: 90px;
        }

        .col-stok-sis {
            width: 100px;
        }

        .col-stok-fis {
            width: 100px;
        }

        .col-selisih {
            width: 100px;
        }

        .col-status {
            width: 110px;
        }

        table th:nth-child(1),
        table td:nth-child(1),
        table th:nth-child(4),
        table td:nth-child(4),
        table th:nth-child(5),
        table td:nth-child(5),
        table th:nth-child(6),
        table td:nth-child(6),
        table th:nth-child(7),
        table td:nth-child(7),
        table th:nth-child(8),
        table td:nth-child(8) {
            text-align: center;
        }

        table th:nth-child(2),
        table td:nth-child(2),
        table th:nth-child(3),
        table td:nth-child(3) {
            text-align: left;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 800;
            background-color: #F1F5F9;
            border: 1.5px solid #E2E8F0;
        }

        .info-capsule {
            display: inline-block;
            padding: 2px 0;
            width: 70px;
            border-radius: 4px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: center;
            line-height: 1.2;
            vertical-align: middle;
            margin: -2px 0;
        }

        .pagination-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 15px;
            position: relative;
            min-height: 40px;
        }

        .pagination-info-right {
            position: absolute;
            right: 0;
            font-size: 13px;
            color: #64748B;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .pagination-info-right select {
            padding: 2px 5px;
            border-radius: 4px;
            border: 1.5px solid #E2E8F0;
            color: #1E293B;
            outline: none;
            cursor: pointer;
        }

        .pagination-btns {
            display: flex;
            gap: 8px;
        }

        .btn-page.disabled {
            background-color: #F1F5F9;
            color: #94A3B8;
            cursor: not-allowed;
            border: 1.5px solid #E2E8F0;
        }

        .btn-page {
            background-color: #F8FAFC;
            border: 1.5px solid #E2E8F0;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            color: #64748B;
        }

        a.btn-page {
            text-decoration: none;
            display: inline-block;
        }

        .page-select {
            width: 35px;
            border-radius: 4px;
            border: 1.5px solid #E2E8F0;
            color: #1E293B;
            outline: none;
            cursor: pointer;
            font-size: 13px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%2364748B' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: calc(100% - 3px) center;
            background-size: 8px;
        }

        .summary-container {
            background-color: #CBD5E1;
            padding: 10px;
            border-radius: 8px;
            border: 1.5px solid #94A3B8;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .summary-card {
            background-color: #F8FAFC;
            padding: 10px;
            border-radius: 6px;
            border: 1.5px solid #94A3B8;
            text-align: center;
            font-size: 12px;
            font-weight: 800;
            color: #475569;
        }

        .btn-selesai-container {
            width: 100%;
        }

        .btn-selesai {
            width: 100%;
            background-color: #94A3B8;
            color: #1E293B;
            border: 1.5px solid #64748B;
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-selesai:hover {
            background-color: #64748B;
            color: #FFFFFF;
            border-color: #475569 !important;
            transition: all 0.3s ease;
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

        #toast-container {
            position: fixed;
            top: 31px;
            right: 37px;
            z-index 10000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .toast {
            background: #ffffff;
            padding: 10px 15px;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 250px;
            max-width: fit-content;
            position: relative;
            overflow: hidden;
            animation: toastSlideIn 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .toast-content {
            display: flex;
            align-items: center;
            white-space: nowrap;
        }

        .toast-single-line {
            font-size: 12px;
            color: #334155;
            font-weight: 500;
        }

        .toast-single-line strong {
            color: #0F172A;
            text-transform: capitalize;
            font-weight: 600;
        }

        .toast-icon {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .toast-icon svg {
            width: 10px;
            height: 10px;
        }

        .toast-timer {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 2px;
            width: 100%;
            z-index: 1;
            animation: toastProgress 2.5s linear forwards;
        }

        .toast::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            height: 2px;
            width: 100%;
            background: #F1F5F9;
        }

        .toast.success .toast-icon {
            background: #10B981;
            color: #ffffff;
            border: 1.5px solid #059669;
        }

        .toast.success .toast-timer {
            background: #10B981;
        }

        .toast.error .toast-icon {
            background: #EF4444;
            color: #ffffff;
            border: 1.5px solid #B91C1C;
        }

        .toast.error .toast-timer {
            background: #EF4444;
        }

        .toast.error::after {
            background: #F1F5F9;
        }

        @keyframes toastSlideIn {
            from {
                transform: translateX(120%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes toastProgress {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }
    </style>
</head>

<body>
    <aside class="sidebar">
        <div class="header-sidebar">
            <div class="logo-box"><img src="{{ asset('images/NavMekarJaya.png') }}" alt="Logo"></div>
            <div class="title-box">
                <h1>Toko Mekar Jaya</h1>
                <p>Jl. Yos Sudarso No.184</p>
            </div>
        </div>
        <nav class="nav-menu">
            <a href="{{ route('inventori') }}" class="nav-link">
                <div class="icon-circle">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16.5 9.4 7.55 4.24"></path>
                        <path
                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                        </path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                </div>
                Inventori
            </a>
            <a href="{{ route('penjualan') }}" class="nav-link">
                <div class="icon-circle">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                </div>
                Penjualan
            </a>
            <a href="{{ route('pembelian') }}" class="nav-link">
                <div class="icon-circle">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="1" y="3" width="15" height="13"></rect>
                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                    </svg>
                </div>
                Pembelian
            </a>
            <a href="{{ route('laporan.rekap.penjualan') }}" class="nav-link">
                <div class="icon-circle">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <line x1="10" y1="9" x2="8" y2="9"></line>
                    </svg>
                </div>
                Laporan
            </a>
            <a href="{{ route('stok.opname') }}" class="nav-link active">
                <div class="icon-circle">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                        <path d="m9 14 2 2 4-4"></path>
                    </svg>
                </div>
                Stok Opname
            </a>
            <a href="{{ route('keluar') }}" class="nav-link" id="logout-btn">
                <div class="icon-circle">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                </div>
                Keluar
            </a>
        </nav>
    </aside>

    <main class="main-container">
        <div class="page-header">
            <div class="header-left">
                <div class="header-title-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                        <path d="m9 14 2 2 4-4"></path>
                    </svg>
                </div>
                <h2>STOK OPNAME</h2>
            </div>
            <div class="header-right">
                <div class="user-profile-btn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <div class="user-tooltip">
                    <span class="name">Chandra Hermawan</span>
                    <span class="role">Pemilik Toko Mekar Jaya</span>
                </div>
            </div>
        </div>
        <div class="opname-filter-wrapper">
            <div class="form-group">
                <label>LOKASI BARANG</label>
                <select id="lokasi_barang" required>
                    <option value="" disabled {{ !$lokasi ? 'selected' : '' }} hidden>Pilih</option>
                    <option value="Gudang A" {{ $lokasi == 'Gudang A' ? 'selected' : '' }}>Gudang A</option>
                    <option value="Gudang B" {{ $lokasi == 'Gudang B' ? 'selected' : '' }}>Gudang B</option>
                    <option value="Rak Depan" {{ $lokasi == 'Rak Depan' ? 'selected' : '' }}>Rak Depan</option>
                    <option value="Rak Samping" {{ $lokasi == 'Rak Samping' ? 'selected' : '' }}>Rak Samping</option>
                    <option value="Gudang Belakang" {{ $lokasi == 'Gudang Belakang' ? 'selected' : '' }}>Gudang
                        Belakang</option>
                </select>
            </div>
            <div class="form-group">
                <button type="button" class="btn-opname btn-tampilkan">Tampilkan</button>
            </div>
            <div class="form-group">
                <button type="button" class="btn-opname btn-excel" onclick="exportToExcel()">
                    Eksport Excel
                </button>
            </div>
            <div class="form-group">
                <button type="button" class="btn-opname btn-import" onclick="importExcel()">
                    Import Excel
                </button>
            </div>
        </div>
        <div class="content-wrapper">
            <table>
                <thead>
                    <tr>
                        <th class="col-no">No</th>
                        <th class="col-nama">Nama Barang</th>
                        <th class="col-merek">Merek</th>
                        <th class="col-satuan">Satuan</th>
                        <th class="col-stok-sis">Stok Sistem</th>
                        <th class="col-stok-fis">Stok Fisik</th>
                        <th class="col-selisih">Selisih</th>
                        <th class="col-status">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataBarang as $barang)
                        <tr>
                            <td style="text-align: center;">
                                {{ ($dataBarang->currentPage() - 1) * $dataBarang->perPage() + $loop->iteration }}
                            </td>
                            <td style="text-align: left;">{{ $barang->nama_barang }}</td>
                            <td style="text-align: left;">{{ $barang->merek }}</td>
                            <td style="text-align: center;">{{ $barang->satuan }}</td>
                            <td style="text-align: center;">{{ $barang->stok_sistem }}</td>
                            <td style="text-align: center;">—</td>
                            <td style="text-align: center;">—</td>
                            <td style="text-align: center;">—</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8"
                                style="padding: 50px; text-align: center; color: #94A3B8; font-style: italic; font-size: 12px;">
                                Pilih lokasi untuk menampilkan data barang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagination-wrapper">
                <div class="pagination-btns">
                    @if ($dataBarang->onFirstPage() || $dataBarang->isEmpty())
                        <button class="btn-page disabled" disabled>Sebelumnya</button>
                    @else
                        <a href="{{ $dataBarang->previousPageUrl() }}" class="btn-page">Sebelumnya</a>
                    @endif
                    @if ($dataBarang->hasMorePages())
                        <a href="{{ $dataBarang->nextPageUrl() }}" class="btn-page">Berikutnya</a>
                    @else
                        <button class="btn-page disabled" disabled>Berikutnya</button>
                    @endif
                </div>
                <div class="pagination-info-right">
                    Tampilkan
                    <select class="page-select" id="perPageSelect">
                        <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                    </select>
                    per halaman
                </div>
            </div>
        </div>
        <div class="summary-container">
            <div class="summary-card">
                Total Barang Dicek = {{ $dataBarang->isEmpty() ? '—' : $totalDicek }}
            </div>
            <div class="summary-card">
                Barang Cocok = {{ $dataBarang->isEmpty() ? '—' : $totalCocok }}
            </div>
            <div class="summary-card">
                Barang Kurang = {{ $dataBarang->isEmpty() ? '—' : $totalKurang }}
            </div>
            <div class="summary-card">
                Barang Lebih = {{ $dataBarang->isEmpty() ? '—' : $totalLebih }}
            </div>
        </div>
        <div class="btn-selesai-container">
            <button type="button" class="btn-selesai" onclick="selesaiOpname()">
                Selesai Opname
            </button>
        </div>
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
    </main>

    <div id="toast-container"></div>

    <script>
        const loadingOverlay = document.getElementById('loading-overlay');
        const lokasiSelect = document.getElementById('lokasi_barang');
        const perPageSelect = document.getElementById('perPageSelect');

        function triggerLoading(targetUrl) {
            if (!targetUrl || targetUrl === '#') return;
            loadingOverlay.style.display = 'flex';
            loadingOverlay.style.opacity = '1';
            window.location.href = targetUrl;
        }

        function showSuccessToast(message) {
            const container = document.getElementById('toast-container');
            if (!container) return;
            const toast = document.createElement('div');
            toast.className = 'toast success';
            const icon =
                `<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>`;
            toast.innerHTML = `
                <div class="toast-icon">${icon}</div>
                <div class="toast-content"><span class="toast-single-line"><strong>Success:</strong> ${message}</span></div>
                <div class="toast-timer"></div>`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.transform = "translateX(120%)";
                toast.style.opacity = "0";
                toast.style.transition = "all 0.3s ease";
                setTimeout(() => toast.remove(), 400);
            }, 2500);
        }

        function showErrorToast(message) {
            const container = document.getElementById('toast-container');
            if (!container) return;
            const toast = document.createElement('div');
            toast.className = 'toast error';
            const icon =
                `<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>`;
            toast.innerHTML = `
                <div class="toast-icon">${icon}</div>
                <div class="toast-content"><span class="toast-single-line"><strong>Error:</strong> ${message}</span></div>
                <div class="toast-timer"></div>`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.transform = "translateX(120%)";
                toast.style.opacity = "0";
                toast.style.transition = "all 0.3s ease";
                setTimeout(() => toast.remove(), 400);
            }, 2500);
        }

        if (lokasiSelect) {
            lokasiSelect.addEventListener('mousedown', function() {
                this.style.borderColor = '';
            });
            lokasiSelect.addEventListener('change', function() {
                if (this.value !== "") {
                    this.style.borderColor = '';
                    sessionStorage.removeItem('dataOpname');
                }
            });
        }

        document.querySelector('.btn-tampilkan').addEventListener('click', function() {
            const lokasiValue = lokasiSelect.value;
            if (!lokasiValue) {
                return;
            }
            const url = new URL(window.location.origin + window.location.pathname);
            url.searchParams.set('lokasi', lokasiValue);
            url.searchParams.set('tampilkan', 'true');
            if (perPageSelect) url.searchParams.set('per_page', perPageSelect.value);
            window.location.href = url.href;
        });

        if (perPageSelect) {
            perPageSelect.addEventListener('change', function() {
                const url = new URL(window.location.href);
                url.searchParams.set('per_page', this.value);
                url.searchParams.set('page', 1);
                if (lokasiSelect.value) url.searchParams.set('tampilkan', 'true');
                window.location.href = url.toString();
            });
        }

        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href && href !== '#' && !this.classList.contains('active')) {
                    sessionStorage.removeItem('dataOpname');
                    e.preventDefault();
                    triggerLoading(href);
                }
            });
        });

        async function exportToExcel() {
            const dataBarangLengkap = @json($semuaBarangExport);
            if (!dataBarangLengkap || dataBarangLengkap.length === 0) {
                return;
            }

            const data = [
                ["No", "Nama Barang", "Merek", "Stok Fisik"]
            ];
            dataBarangLengkap.forEach((barang, index) => {
                data.push([index + 1, barang.nama_barang, barang.merek, ""]);
            });

            const workbook = XLSX.utils.book_new();
            const worksheet = XLSX.utils.aoa_to_sheet(data);
            worksheet['!cols'] = [{
                wch: 5
            }, {
                wch: 35
            }, {
                wch: 20
            }, {
                wch: 15
            }];
            XLSX.utils.book_append_sheet(workbook, worksheet, "Hasil Opname");

            try {
                const excelBuffer = XLSX.write(workbook, {
                    bookType: 'xlsx',
                    type: 'array'
                });
                const blob = new Blob([excelBuffer], {
                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                });

                if ('showSaveFilePicker' in window) {
                    const handle = await window.showSaveFilePicker({
                        suggestedName: '',
                        types: [{
                            description: 'Excel file',
                            accept: {
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet': [
                                    '.xlsx'
                                ]
                            },
                        }],
                    });
                    const writable = await handle.createWritable();
                    await writable.write(blob);
                    await writable.close();
                    showSuccessToast("File disimpan.");
                } else {
                    XLSX.writeFile(workbook, "Data_Opname.xlsx");
                    showSuccessToast("File diunduh.");
                }
            } catch (err) {
                console.log("Penyimpanan dibatalkan.");
            }
        }

        async function importExcel() {
            const dataBarangLengkap = @json($semuaBarangExport);
            if (!lokasiSelect.value || dataBarangLengkap.length === 0) {
                return;
            }

            try {
                const [fileHandle] = await window.showOpenFilePicker({
                    types: [{
                        description: 'Excel Files',
                        accept: {
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet': [
                                '.xlsx'
                            ]
                        }
                    }],
                    multiple: false
                });

                const file = await fileHandle.getFile();
                if (!file.name.endsWith('.xlsx')) {
                    throw new Error("Format file tidak valid.");
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, {
                        type: 'array'
                    });

                    const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                    const excelRows = XLSX.utils.sheet_to_json(firstSheet);
                    if (excelRows.length === 0) {
                        showErrorToast("File Excel kosong.");
                        return;
                    }

                    const requiredColumns = ["No", "Nama Barang", "Merek", "Stok Fisik"];
                    const excelColumns = Object.keys(excelRows[0] || {});
                    const isFormatValid = requiredColumns.every(col => excelColumns.includes(col));
                    if (!isFormatValid) {
                        showErrorToast("Format data tidak sesuai.");
                        return;
                    }
                    if (excelRows.length !== dataBarangLengkap.length) {
                        showErrorToast("Format data tidak sesuai.");
                        return;
                    }

                    let hasilOpname = {};
                    let isOrderValid = true;
                    dataBarangLengkap.forEach((barang, index) => {
                        const excelItem = excelRows[index];
                        if (
                            excelItem["No"] != (index + 1) ||
                            excelItem["Nama Barang"] !== barang.nama_barang ||
                            excelItem["Merek"] !== barang.merek
                        ) {
                            isOrderValid = false;
                        }
                        const stokFisik = parseInt(excelItem["Stok Fisik"] || 0);
                        const stokSistem = parseInt(barang.stok_sistem);
                        const selisih = stokFisik - stokSistem;
                        let status = "COCOK";
                        if (selisih < 0) status = "KURANG";
                        if (selisih > 0) status = "LEBIH";
                        hasilOpname[barang.nama_barang] = {
                            stokFisik: stokFisik,
                            selisih: selisih,
                            status: status
                        };
                    });

                    if (!isOrderValid) {
                        showErrorToast("Format data tidak sesuai.");
                        return;
                    }
                    sessionStorage.setItem('dataOpname', JSON.stringify(hasilOpname));
                    applyOpnameToTable();
                };
                reader.readAsArrayBuffer(file);

            } catch (err) {
                if (err.name !== 'AbortError') {
                    showErrorToast(err.message || "Terjadi kesalahan saat membaca file.");
                }
            }
        }

        function cleanupLoading() {
            loadingOverlay.style.opacity = '0';
            loadingOverlay.style.display = 'none';
        }

        function applyOpnameToTable() {
            const storedData = sessionStorage.getItem('dataOpname');
            const tableRows = document.querySelectorAll("tbody tr");
            if (!storedData) {
                tableRows.forEach(row => {
                    const cells = row.querySelectorAll("td");
                    if (cells.length >= 8) {
                        cells[5].innerText = "—";
                        cells[6].innerText = "—";
                        cells[7].innerText = "—";
                    }
                });
                return;
            }

            const hasilOpname = JSON.parse(storedData);
            let countDicek = 0,
                countCocok = 0,
                countKurang = 0,
                countLebih = 0;
            Object.values(hasilOpname).forEach(data => {
                countDicek++;
                if (data.status === "COCOK") countCocok++;
                else if (data.status === "KURANG") countKurang++;
                else if (data.status === "LEBIH") countLebih++;
            });

            tableRows.forEach(row => {
                const cells = row.querySelectorAll("td");
                if (cells.length < 8) return;

                const namaBarang = cells[1].innerText.trim();
                if (hasilOpname[namaBarang]) {
                    const dataBarang = hasilOpname[namaBarang];
                    cells[5].innerText = dataBarang.stokFisik;
                    cells[6].innerText = (dataBarang.selisih > 0) ? `+${dataBarang.selisih}` : dataBarang.selisih;

                    let color = "#059669",
                        bgColor = "#D1FAE5",
                        borderColor = "#10B981";
                    if (dataBarang.status === "KURANG") {
                        color = "#DC2626";
                        bgColor = "#FEE2E2";
                        borderColor = "#F87171";
                    } else if (dataBarang.status === "LEBIH") {
                        color = "#2563EB";
                        bgColor = "#DBEAFE";
                        borderColor = "#60A5FA";
                    }

                    cells[7].innerHTML = `
                <span class="info-capsule" style="color: ${color}; background-color: ${bgColor}; border: 1.5px solid ${borderColor}; font-weight: 800;">
                    ${dataBarang.status}
                </span>`;
                }
            });

            const cards = document.querySelectorAll(".summary-card");
            if (cards.length >= 4) {
                cards[0].innerText = `Total Barang Dicek = ${countDicek}`;
                cards[1].innerText = `Barang Cocok = ${countCocok}`;
                cards[2].innerText = `Barang Kurang = ${countKurang}`;
                cards[3].innerText = `Barang Lebih = ${countLebih}`;
            }
        }

        async function selesaiOpname() {
            const storedData = sessionStorage.getItem('dataOpname');
            if (!storedData) return;

            const hasilOpname = JSON.parse(storedData);
            try {
                const response = await fetch("{{ route('stok.opname.simpan') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        hasil_opname: hasilOpname
                    })
                });

                const result = await response.json();
                if (result.success) {
                    sessionStorage.removeItem('dataOpname');
                    loadingOverlay.style.display = 'flex';
                    loadingOverlay.style.opacity = '1';
                    window.location.href = "{{ route('stok.opname') }}?status=success";
                }
            } catch (error) {
                cleanupLoading();
                console.error("Gagal menyimpan opname:", error);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            applyOpnameToTable();
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('status') === 'success') {
                showSuccessToast("Stok diperbarui.");
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        });
    </script>
</body>

</html>
