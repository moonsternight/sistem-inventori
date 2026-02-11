<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Penjualan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/MekarJaya.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            display: flex;
            height: 100vh;
            background-color: #F1F5F9;
            font-family: 'Inter', sans-serif;
            color: #1E293B;
        }

        body.sidebar-open {
            overflow: hidden;
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

        .sidebar-toggle-btn {
            display: none;
            width: 38px;
            height: 38px;
            background-color: #F8FAFC;
            border: 1.5px solid #94A3B8;
            border-radius: 8px;
            align-items: center;
            justify-content: center;
            color: #1E293B;
            cursor: pointer;
            flex-shrink: 0;
        }

        .sidebar-toggle-btn svg {
            width: 18px;
            height: 18px;
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.45);
            display: none;
            z-index: 999;
        }

        .sidebar-overlay.active {
            display: block;
        }

        .sales-table-scroll-wrapper {
            width: 100%;
            overflow-x: visible;
            overflow-y: hidden;
            margin-bottom: 15px;
            padding: 0;
            border-radius: 8px;
            border: 1.5px solid #E2E8F0;
            background-color: #FFFFFF;
            display: block;
        }

        @media (max-width: 1023.98px) {
            body {
                height: auto;
                min-height: 100vh;
                overflow-x: clip;
            }

            .main-container {
                overflow-x: clip;
                width: 100%;
                max-width: 100%;
                padding: 12px;
                overflow-y: clip;
            }

            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100dvh;
                transform: translateX(-100%);
                transition: transform 0.25s ease;
                z-index: 1000;
                box-shadow: 0 18px 40px rgba(0, 0, 0, 0.35);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-toggle-btn {
                display: inline-flex;
            }

            .page-header {
                padding: 10px 12px;
                gap: 10px;
                border-radius: 10px;
            }

            .header-left {
                min-width: 0;
            }

            .sales-container {
                padding: 12px;
            }

            .transaction-header-grid,
            .item-input-grid,
            .confirmation-box {
                gap: 12px;
                padding: 12px;
            }

            .sales-table-scroll-wrapper {
                overflow-x: auto;
            }
        }

        @media (min-width: 1024px) {
            .sales-table-scroll-wrapper {
                overflow-x: hidden;
            }
        }

        @media (max-width: 639.98px) {
            .main-container {
                padding: 20px !important;
            }

            .sales-container h3 {
                font-size: 16px !important;
            }

            .page-header {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }

            .header-left {
                gap: 10px !important;
            }

            .page-header h2 {
                font-size: 16px !important;
                white-space: nowrap !important;
            }

            .transaction-header-grid {
                grid-template-columns: 1fr !important;
            }

            .item-input-grid {
                grid-template-columns: 1fr !important;
                align-items: stretch;
            }

            .btn-add-item {
                width: 100%;
            }

            .sales-table-container {
                overflow: hidden;
            }

            .sales-table {
                min-width: 1000px;
            }

            .confirmation-box {
                flex-direction: column;
                align-items: stretch;
            }

            .confirmation-wrapper {
                justify-content: stretch;
            }

            .confirmation-box {
                width: 100%;
            }

            .confirmation-box .form-group {
                width: 100% !important;
            }

            .btn-finish {
                width: 100%;
                padding: 0 20px;
            }
        }

        @media (min-width: 640px) and (max-width: 1023.98px) {
            .main-container {
                padding: 20px;
                overflow-y: auto;
            }

            .transaction-header-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 12px;
            }

            .item-input-grid {
                grid-template-columns: 1.4fr 1.4fr 0.5fr 0.8fr 0.8fr auto;
                gap: 12px;
            }

            .confirmation-box {
                flex-direction: row;
                align-items: flex-end;
            }
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

        .sales-container {
            background-color: #FFFFFF;
            border-radius: 8px;
            border: 1.5px solid #E2E8F0;
            padding: 15px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .sales-container h3 {
            margin: 0 0 15px 0;
            font-size: 18px;
            font-weight: 800;
            color: #0F172A;
        }

        .transaction-header-grid {
            background-color: #CBD5E1;
            padding: 18px;
            border-radius: 8px;
            border: 1.5px solid #94A3B8;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 15px;
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
            transition: border-color 0.3s ease;
        }

        #tanggal_transaksi,
        #no_transaksi {
            text-align: left;
            background-color: #F1F5F9;
            cursor: default;
        }

        #metode_pembayaran {
            text-align: center;
            text-align-last: center;
            padding: 0;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: none;
            cursor: pointer;
        }

        .input-readonly {
            background-color: #F1F5F9;
            cursor: default;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #94A3B8;
            outline: none;
            box-shadow: none;
        }

        .item-input-grid {
            background-color: #CBD5E1;
            padding: 18px;
            border-radius: 8px;
            border: 1.5px solid #94A3B8;
            display: grid;
            grid-template-columns: 1.4fr 1.4fr 0.5fr 0.8fr 0.8fr auto;
            gap: 18px;
            align-items: flex-end;
        }

        .search-input {
            background-repeat: no-repeat;
            background-position: 12px center;
            background-size: 14px;
        }

        .search-input::placeholder {
            font-style: italic;
            color: #1E293B;
            opacity: 1;
        }

        .input-barang:placeholder-shown {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748B' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.3-4.3'/%3E%3C/svg%3E");
            padding-left: 35px;
        }

        .input-merek:placeholder-shown {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748B' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.3-4.3'/%3E%3C/svg%3E");
            padding-left: 35px;
        }

        .search-input:not(:placeholder-shown) {
            background-image: none;
            padding-left: 15px;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        .input-jumlah {
            text-align: left;
        }

        .input-harga,
        .input-subtotal {
            text-align: left;
            padding-left: 15px;
        }

        #subtotal_input {
            background-color: #F1F5F9;
            cursor: default;
        }

        .btn-add-item {
            background-color: #94A3B8;
            color: #1E293B;
            height: 38px;
            padding: 0 20px;
            border-radius: 6px;
            border: none;
            border: 1.5px solid #64748B;
            text-transform: uppercase;
            font-weight: 800;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-add-item:hover {
            background-color: #64748B;
            color: #FFFFFF;
            border-color: #475569;
            transition: all 0.3s ease;
        }

        .sales-table-container {
            margin-top: 15px;
            background-color: #FFFFFF;
            border-radius: 8px;
            overflow: hidden;
        }

        .sales-table {
            width: 100% !important;
            min-width: 1000px;
            border-collapse: separate;
            border-spacing: 0;
            table-layout: fixed;
        }

        .sales-table thead tr {
            width: 100%;
        }

        .sales-table thead th {
            background-color: #F8FAFC;
            color: #64748B;
            padding: 12px 8px;
            border-bottom: 1.5px solid #E2E8F0;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .sales-table tbody tr:last-child td {
            border-bottom: none !important;
        }

        .col-no {
            width: 50px;
            text-align: center;
        }

        .col-nama {
            width: 190px;
            text-align: left;
            letter-spacing: 0.3px;
        }

        .col-merek {
            width: 200px;
            text-align: left;
            letter-spacing: 0.3px;
        }

        .col-jumlah {
            width: 120px;
            text-align: center;
            letter-spacing: 0.3px;
        }

        .col-harga {
            width: 138px;
            text-align: left;
            letter-spacing: 0.3px;
        }

        .col-subtotal {
            width: 135px;
            text-align: left;
            letter-spacing: 0.3px;
        }

        .col-aksi {
            text-align: left;
        }

        .sales-table tbody td:nth-child(1),
        .sales-table tbody td:nth-child(4) {
            text-align: center;
        }

        .sales-table tbody td {
            padding: 8px !important;
            color: #1E293B;
            font-size: 12px;
            border-bottom: 1.5px solid #F1F5F9 !important;
            vertical-align: middle;
            line-height: 1 !important;
            height: 1px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .sales-table tbody tr:last-child td {
            border-bottom: none !important;
        }

        .sales-table tbody td:nth-child(1),
        .sales-table tbody td:nth-child(4) {
            text-align: center;
        }

        .sales-table tbody td:nth-child(2),
        .sales-table tbody td:nth-child(3),
        .sales-table tbody td:nth-child(5),
        .sales-table tbody td:nth-child(6) {
            text-align: left;
        }

        .sales-table tbody td:last-child {
            text-align: left;
        }

        .placeholder-text {
            padding: 50px !important;
            text-align: center;
            color: #94A3B8;
            font-style: italic;
            border-bottom: none !important;
            height: auto !important;
            line-height: normal !important;
        }

        .btn-remove-item {
            background-color: #ef4444;
            color: #FFFFFF;
            padding: 5px 15px;
            border-radius: 6px;
            border: 1.5px solid #9f1239;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-remove-item:hover {
            background-color: #dc2626;
            border-color: #881337 !important;
            transition: all 0.3s ease;
        }

        .confirmation-wrapper {
            display: flex;
            justify-content: flex-end;
        }

        .confirmation-box {
            background-color: #CBD5E1;
            padding: 18px;
            border-radius: 8px;
            border: 1.5px solid #94A3B8;
            display: flex;
            gap: 18px;
            align-items: flex-end;
        }

        .btn-finish {
            background-color: #94A3B8;
            color: #1E293B;
            height: 38px;
            padding: 0 75px;
            border-radius: 6px;
            border: 1.5px solid #64748B !important;
            text-transform: uppercase;
            font-weight: 800;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-finish:hover {
            background-color: #64748B;
            color: #FFFFFF;
            border-color: #475569 !important;
            transition: all 0.3s ease;
        }

        #total_pembayaran {
            text-align: left;
            background-color: #F8FAFC;
            cursor: default;
            border-radius: 6px;
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

        @media (max-width: 639.98px) {
            #toast-container {
                top: 31px;
                right: 30px;
            }
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

        .dropdown-suggestion {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            margin-top: 4px;
            overflow: hidden;
        }

        .suggestion-item {
            padding: 5px 15px;
            cursor: pointer;
            font-size: 10px;
            color: #0F172A;
            border-bottom: 1px solid #f1f5f9;
        }

        .suggestion-item:last-child {
            border-bottom: none;
        }

        .suggestion-item strong {
            color: #0F172A;
            font-weight: 800;
        }

        .suggestion-item:hover strong,
        .suggestion-item:hover small {
            background: #f8fafc;
            color: #10B981;
        }

        .sales-table tbody tr.placeholder-row td.placeholder-text {
            padding: 50px 0 !important;
            line-height: normal !important;
            vertical-align: middle !important;
            font-style: italic;
            color: #94A3B8;
            text-align: center;
            border-bottom: none !important;
        }
    </style>
</head>

<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <aside class="sidebar">
        <div class="header-sidebar">
            <div class="logo-box">
                <img src="{{ asset('images/NavMekarJaya.png') }}" alt="Logo Mekar Jaya">
            </div>
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
            <a href="{{ route('penjualan') }}" class="nav-link active">
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
            <a href="{{ route('stok.opname') }}" class="nav-link">
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
            <a href="{{ route('keluar') }}" class="nav-link">
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
                <button class="sidebar-toggle-btn" id="sidebarToggleBtn" type="button" aria-label="Buka navigasi">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
                <div class="header-title-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                </div>
                <h2>PENJUALAN</h2>
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
        <div class="sales-container">
            <h3 style="font-size: 18px; font-weight: 800; color: #0F172A;">Transaksi Baru</h3>
            <div class="transaction-header-grid">
                <div class="form-group">
                    <label style="display: block; font-size: 11px; font-weight: 800; color: #0F172A;">
                        Tanggal
                    </label>
                    <input type="date" id="tanggal_transaksi" value="{{ date('Y-m-d') }}" readonly>
                </div>
                <div class="form-group">
                    <label style="display: block; font-size: 11px; font-weight: 800; color: #0F172A;">
                        No. Transaksi
                    </label>
                    <input type="text" id="no_transaksi" value="{{ $no_transaksi }}" readonly>
                </div>
                <div class="form-group">
                    <label style="display: block; font-size: 11px; font-weight: 800; color: #0F172A;">
                        Metode Pembayaran
                    </label>
                    <select id="metode_pembayaran" class="form-control">
                        <option value="" disabled selected style="display: none;">Pilih</option>
                        <option value="Tunai">Tunai</option>
                        <option value="Transfer BCA">Transfer BCA</option>
                    </select>
                </div>
            </div>
            <div class="item-input-grid">
                <div class="form-group">
                    <label style="color: #0F172A; font-weight: 800; font-size: 11px;">NAMA BARANG</label>
                    <div style="position: relative;">
                        <input type="text" class="search-input input-barang" placeholder="Cari Nama Barang"
                            autocomplete="off" spellcheck="false">
                        <div id="dropdown-barang" class="dropdown-suggestion" style="display: none;"></div>
                    </div>
                </div>
                <div class="form-group" style="position: relative;">
                    <label style="color: #0F172A; font-weight: 800; font-size: 11px;">MEREK</label>
                    <input type="text" class="search-input input-merek" placeholder="Cari Merek Barang"
                        autocomplete="off" spellcheck="false">
                </div>
                <div class="form-group">
                    <label style="color: #0F172A; font-weight: 800; font-size: 11px;">JUMLAH</label>
                    <input type="text" class="input-jumlah" inputmode="numeric" pattern="[0-9]*"
                        autocomplete="off" spellcheck="false">
                </div>
                <div class="form-group">
                    <label style="color: #0F172A; font-weight: 800; font-size: 11px;">HARGA</label>
                    <input type="text" class="input-harga" inputmode="numeric" autocomplete="off"
                        spellcheck="false">
                </div>
                <div class="form-group">
                    <label style="color: #0F172A; font-weight: 800; font-size: 11px;">SUBTOTAL</label>
                    <input type="text" id="subtotal_input" class="input-subtotal" readonly>
                </div>
                <button type="button" class="btn-add-item">Tambah</button>
            </div>
            <div class="sales-table-container">
                <div class="sales-table-scroll-wrapper">
                    <table class="sales-table">
                        <thead>
                            <tr>
                                <th class="col-no">No</th>
                                <th class="col-nama">Nama Barang</th>
                                <th class="col-merek">Merek</th>
                                <th class="col-jumlah">Jumlah</th>
                                <th class="col-harga">Harga</th>
                                <th class="col-subtotal">Subtotal</th>
                                <th class="col-aksi">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="sales-items-body">
                            <tr class="placeholder-row">
                                <td colspan="7" class="placeholder-text">Keranjang masih kosong.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="confirmation-wrapper">
                <div class="confirmation-box">
                    <div class="form-group" style="width: 200px;">
                        <label style="color: #0F172A; font-weight: 800; font-size: 11px;">Total Pembayaran</label>
                        <input type="text" id="total_pembayaran" value="Rp 0" readonly>
                    </div>
                    <div class="form-group">
                        <label style="color: #0F172A; font-weight: 800; font-size: 11px;">Konfirmasi</label>
                        <button type="button" id="btn-selesai" class="btn-finish">Selesai</button>
                    </div>
                </div>
            </div>
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
        (function() {
            const sidebar = document.querySelector('.sidebar');
            const toggle = document.getElementById('sidebarToggleBtn');
            const overlay = document.getElementById('sidebarOverlay');
            const navLinks = document.querySelectorAll('.nav-link');

            function openSidebar() {
                if (!sidebar || !overlay) return;
                sidebar.classList.add('open');
                overlay.classList.add('active');
                document.body.classList.add('sidebar-open');
            }

            function closeSidebar() {
                if (!sidebar || !overlay) return;
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
                document.body.classList.remove('sidebar-open');
            }

            function toggleSidebar() {
                if (!sidebar) return;
                if (sidebar.classList.contains('open')) closeSidebar();
                else openSidebar();
            }

            if (toggle) toggle.addEventListener('click', toggleSidebar);
            if (overlay) overlay.addEventListener('click', closeSidebar);

            navLinks.forEach(function(link) {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 1024) closeSidebar();
                });
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeSidebar();
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) closeSidebar();
            });
        })();

        const loadingOverlay = document.getElementById('loading-overlay');
        const daftarBarang = @json($barang);
        const inputBarang = document.querySelector('.input-barang');
        const inputMerek = document.querySelector('.input-merek');
        const inputJumlah = document.querySelector('.input-jumlah');
        const inputHarga = document.querySelector('.input-harga');
        const inputSubtotal = document.getElementById('subtotal_input');
        const btnTambah = document.querySelector('.btn-add-item');
        const btnSelesai = document.getElementById('btn-selesai');
        const tableBody = document.getElementById('sales-items-body');

        [inputBarang, inputMerek, inputJumlah, inputHarga].forEach(input => {
            input.addEventListener('input', function() {
                let cursorPosition = this.selectionStart;
                let originalLength = this.value.length;

                if (this === inputJumlah || this === inputHarga) {
                    let val = this.value.replace(/[^0-9]/g, '');
                    if (val.startsWith('0')) {
                        val = val.replace(/^0+/, '');
                    }
                    this.value = val;
                    hitungSubtotal();
                    simpanDraftInput();
                }

                if (this === inputBarang) {
                    cariHargaOtomatis(this, 'nama');
                } else if (this === inputMerek) {
                    cariHargaOtomatis(this, 'merek');
                }

                if (this !== inputHarga && this !== inputJumlah) {
                    const namaValue = inputBarang.value.toLowerCase().trim();
                    const merekValue = inputMerek.value.toLowerCase().trim();
                    const barangCocok = daftarBarang.find(b =>
                        b.nama_barang.toLowerCase() === namaValue &&
                        b.merek.toLowerCase() === merekValue
                    );

                    if (barangCocok && namaValue !== "" && merekValue !== "") {
                        if (inputHarga.value.trim() === "") {
                            inputHarga.value = parseInt(barangCocok.harga_jual);
                        }
                    }
                }
                hitungSubtotal();
                simpanDraftInput();

                if (this === inputHarga) {
                    let newLength = this.value.length;
                    let newCursorPos = cursorPosition + (newLength - originalLength);
                    if (newCursorPos < 3) newCursorPos = 3;
                    this.setSelectionRange(newCursorPos, newCursorPos);
                }
            });

            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    if (!this.dataset.isProcessing) {
                        this.dataset.isProcessing = "true";
                        tambahBarangKeTabel();
                        setTimeout(() => {
                            delete this.dataset.isProcessing;
                        }, 500);
                    }
                }
            });
        });

        inputHarga.addEventListener('input', function() {
            if (this.value.trim() !== "") {
                this.style.borderColor = '#94A3B8';
            }
            hitungSubtotal();
            simpanDraftInput();
        });

        function triggerLoading(targetUrl) {
            if (!targetUrl || targetUrl === '#') return;
            loadingOverlay.style.display = 'flex';
            loadingOverlay.style.opacity = '1';
            window.location.href = targetUrl;
        }

        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href && href !== '#' && !this.classList.contains('active')) {
                    e.preventDefault();
                    triggerLoading(href);
                }
            });
        });

        const logoutBtn = document.querySelector('a[href="{{ route('keluar') }}"]');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function(e) {
                localStorage.clear();
                triggerLoading(this.getAttribute('href'));
            });
        }

        function cariHargaOtomatis(inputElement, tipe) {
            const value = inputElement.value.toLowerCase().trim();
            const dropdown = document.getElementById('dropdown-barang');

            if (value.length === 0) {
                dropdown.style.display = 'none';
                inputHarga.value = "";
                inputSubtotal.value = "";
                return;
            }

            const matches = daftarBarang.filter(b => {
                const target = (tipe === 'nama') ? b.nama_barang : b.merek;
                return target.toLowerCase().includes(value);
            });

            matches.sort((a, b) => {
                const valA = (tipe === 'nama') ? a.nama_barang.toLowerCase() : a.merek.toLowerCase();
                const valB = (tipe === 'nama') ? b.nama_barang.toLowerCase() : b.merek.toLowerCase();
                const startsA = valA.startsWith(value);
                const startsB = valB.startsWith(value);
                if (startsA && !startsB) return -1;
                if (!startsA && startsB) return 1;
                return 0;
            });

            const finalResults = matches.slice(0, 3);
            if (finalResults.length > 0) {
                dropdown.innerHTML = '';
                inputElement.parentNode.appendChild(dropdown);
                dropdown.style.display = 'block';
                finalResults.forEach(barang => {
                    const item = document.createElement('div');
                    item.className = 'suggestion-item';
                    if (tipe === 'nama') {
                        item.innerHTML = `<strong>${barang.nama_barang}</strong> - <small>${barang.merek}</small>`;
                    } else {
                        item.innerHTML = `<strong>${barang.merek}</strong> - <small>${barang.nama_barang}</small>`;
                    }
                    item.onclick = function() {
                        inputBarang.value = barang.nama_barang;
                        inputMerek.value = barang.merek;
                        inputHarga.value = parseInt(barang.harga_jual);
                        dropdown.style.display = 'none';
                        inputBarang.style.borderColor = '#94A3B8';
                        inputMerek.style.borderColor = '#94A3B8';
                        inputJumlah.focus();
                        hitungSubtotal();
                        simpanDraftInput();
                    };
                    dropdown.appendChild(item);
                });
            } else {
                dropdown.style.display = 'none';
            }

            const namaValue = inputBarang.value.toLowerCase().trim();
            const merekValue = inputMerek.value.toLowerCase().trim();
            const barangCocok = daftarBarang.find(b =>
                b.nama_barang.toLowerCase() === namaValue &&
                b.merek.toLowerCase() === merekValue
            );

            if (barangCocok && namaValue !== "" && merekValue !== "") {
                inputHarga.value = parseInt(barangCocok.harga_jual);
                hitungSubtotal();
            } else {
                inputHarga.value = "";
                inputSubtotal.value = "";
            }
        }

        function cariSaranDinamis(inputElement, tipe) {
            const value = inputElement.value.toLowerCase().trim();
            const dropdown = document.getElementById('dropdown-barang');

            if (value.length === 0) {
                dropdown.style.display = 'none';
                return;
            }

            const matches = daftarBarang.filter(b => {
                const target = (tipe === 'nama') ? b.nama_barang : b.merek;
                return target.toLowerCase().includes(value);
            });

            matches.sort((a, b) => {
                const valA = (tipe === 'nama') ? a.nama_barang.toLowerCase() : a.merek.toLowerCase();
                const valB = (tipe === 'nama') ? b.nama_barang.toLowerCase() : b.merek.toLowerCase();
                const startsA = valA.startsWith(value);
                const startsB = valB.startsWith(value);
                if (startsA && !startsB) return -1;
                if (!startsA && startsB) return 1;
                return 0;
            });

            const finalResults = matches.slice(0, 3);
            if (finalResults.length > 0) {
                dropdown.innerHTML = '';
                inputElement.parentNode.appendChild(dropdown);
                dropdown.style.display = 'block';
                finalResults.forEach(barang => {
                    const item = document.createElement('div');
                    item.className = 'suggestion-item';
                    item.innerHTML = `<strong>${barang.nama_barang}</strong> - <small>${barang.merek}</small>`;
                    item.onclick = function() {
                        inputBarang.value = barang.nama_barang;
                        inputMerek.value = barang.merek;
                        inputHarga.value = parseInt(barang.harga_jual);
                        dropdown.style.display = 'none';
                        inputBarang.style.borderColor = '#e2e8f0';
                        inputMerek.style.borderColor = '#e2e8f0';
                        inputJumlah.focus();
                        hitungSubtotal();
                        simpanDraftInput();
                    };
                    dropdown.appendChild(item);
                });
            } else {
                dropdown.style.display = 'none';
            }
        }

        function formatRupiahVisual(angka) {
            if (!angka || angka == 0) return "";
            return "Rp " + parseInt(angka).toLocaleString('id-ID');
        }

        function murnikanAngka(string) {
            if (!string) return "0";
            return string.toString().replace(/[^\d]/g, '');
        }

        function hitungSubtotal() {
            const hargaMurni = parseInt(murnikanAngka(inputHarga.value)) || 0;
            const jumlahMurni = parseInt(inputJumlah.value) || 0;

            if (hargaMurni > 0) {
                inputHarga.value = formatRupiahVisual(hargaMurni);
            } else {
                inputHarga.value = "";
            }

            if (hargaMurni > 0 && jumlahMurni > 0) {
                const total = hargaMurni * jumlahMurni;
                inputSubtotal.value = formatRupiahVisual(total);
            } else {
                inputSubtotal.value = "";
            }
        }

        function checkTablePlaceholder() {
            const tableBody = document.getElementById('sales-items-body');
            const rows = tableBody.querySelectorAll('tr:not(.placeholder-row)');
            const placeholder = tableBody.querySelector('.placeholder-row');

            if (rows.length === 0) {
                if (!placeholder) {
                    const placeholderHTML = `
                <tr class="placeholder-row">
                    <td colspan="7" class="placeholder-text">
                        Keranjang masih kosong.
                    </td>
                </tr>`;
                    tableBody.innerHTML = placeholderHTML;
                }
            } else {
                if (placeholder) {
                    placeholder.remove();
                }
            }
        }

        function updateGrandTotal() {
            let total = 0;
            const rows = document.querySelectorAll('#sales-items-body tr:not(.placeholder-row)');

            rows.forEach(row => {
                const subText = row.cells[5].innerText;
                const subValue = parseInt(murnikanAngka(subText)) || 0;
                total += subValue;
            });

            const inputTotal = document.getElementById('total_pembayaran');
            if (inputTotal) {
                inputTotal.value = formatRupiahVisual(total) || "Rp 0";
                inputTotal.style.cursor = 'default';
                inputTotal.style.backgroundColor = '#F8FAFC';
                inputTotal.readOnly = true;
            }
        }

        function tambahBarangKeTabel() {
            const nama = inputBarang.value.trim();
            const merek = inputMerek.value.trim();
            const jumlah = inputJumlah.value.trim();
            const hargaMurni = murnikanAngka(inputHarga.value);
            const subtotalMurni = murnikanAngka(inputSubtotal.value);
            let isValid = true;
            let firstInvalidInput = null;

            const isDataLengkap = inputBarang.value.trim() &&
                inputMerek.value.trim() &&
                inputJumlah.value.trim() &&
                hargaMurni !== "0" &&
                hargaMurni !== "" &&
                subtotalMurni !== "0";

            if (!isDataLengkap) {
                if (!inputBarang.value.trim()) {
                    inputBarang.focus();
                } else if (!inputMerek.value.trim()) {
                    inputMerek.focus();
                } else if (!inputJumlah.value.trim()) {
                    inputJumlah.focus();
                }
                return;
            }

            const dataAsli = daftarBarang.find(b =>
                b.nama_barang.toLowerCase() === nama.toLowerCase() &&
                b.merek.toLowerCase() === merek.toLowerCase()
            );

            if (!dataAsli || parseInt(jumlah) > dataAsli.stok_sistem) {
                showToast(`Sisa stok ${dataAsli ? dataAsli.stok_sistem : 0}`);
                return;
            }

            const placeholderTable = tableBody.querySelector('.placeholder-row');
            if (placeholderTable) placeholderTable.remove();

            const row = `
            <tr>
                <td class="col-no">0</td>
                <td class="col-nama">${nama}</td>
                <td class="col-merek">${merek}</td>
                <td class="col-jumlah">${jumlah}</td>
                <td class="col-harga">${formatRupiahVisual(hargaMurni)}</td>
                <td class="col-subtotal">${formatRupiahVisual(subtotalMurni)}</td>
                <td class="col-aksi">
                    <button type="button" class="btn-remove-item" 
                        onclick="
                            this.parentElement.parentElement.remove(); 
                            checkTablePlaceholder(); 
                            updateNomorUrut(); 
                            updateGrandTotal(); 
                            simpanKeranjangKeMemori(); 
                        ">Hapus</button>
                </td>
            </tr>
        `;
            tableBody.insertAdjacentHTML('beforeend', row);

            updateNomorUrut();
            simpanKeranjangKeMemori();
            localStorage.removeItem('draft_input_penjualan');

            [inputBarang, inputMerek, inputJumlah, inputHarga, inputSubtotal].forEach(el => {
                el.value = '';
                el.style.borderColor = '#94A3B8';
            });

            inputBarang.placeholder = "Cari Nama Barang";
            inputMerek.placeholder = "Cari Merek Barang";

            updateGrandTotal();
            showSuccessToast("Barang ditambahkan.");
            inputBarang.focus();
        }

        btnTambah.addEventListener('click', function() {
            tambahBarangKeTabel();
        });

        function simpanKeranjangKeMemori() {
            const baris = [];
            document.querySelectorAll('#sales-items-body tr:not(.placeholder-row)').forEach(row => {
                baris.push({
                    no: row.cells[0].innerText,
                    nama: row.cells[1].innerText,
                    merek: row.cells[2].innerText,
                    jumlah: row.cells[3].innerText,
                    harga: row.cells[4].innerText,
                    subtotal: row.cells[5].innerText
                });
            });
            localStorage.setItem('keranjang_penjualan', JSON.stringify(baris));
        }

        function simpanDraftInput() {
            const draft = {
                nama: inputBarang.value,
                merek: inputMerek.value,
                jumlah: inputJumlah.value,
                harga: inputHarga.value
            };
            localStorage.setItem('draft_input_penjualan', JSON.stringify(draft));
        }

        function muatDataDariMemori() {
            const dataTabel = JSON.parse(localStorage.getItem('keranjang_penjualan'));
            if (dataTabel && dataTabel.length > 0) {
                const tableBody = document.getElementById('sales-items-body');
                tableBody.innerHTML = '';
                dataTabel.forEach(item => {
                    const row = `
                        <tr>
                            <td class="col-no">${item.no}</td>
                            <td class="col-nama">${item.nama}</td>
                            <td class="col-merek">${item.merek}</td>
                            <td class="col-jumlah">${item.jumlah}</td>
                            <td class="col-harga">${item.harga}</td>
                            <td class="col-subtotal">${item.subtotal}</td>
                            <td class="col-aksi">
                                <button type="button" class="btn-remove-item" 
                                    onclick="
                                        this.parentElement.parentElement.remove(); 
                                        if(typeof checkTablePlaceholder === 'function') checkTablePlaceholder(); 
                                        if(typeof updateNomorUrut === 'function') updateNomorUrut(); 
                                        if(typeof updateGrandTotal === 'function') updateGrandTotal(); 
                                        simpanKeranjangKeMemori();
                                    ">Hapus</button>
                            </td>
                        </tr>`;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });
                updateGrandTotal();
            }

            const dataInput = JSON.parse(localStorage.getItem('draft_input_penjualan'));
            if (dataInput) {
                inputBarang.value = dataInput.nama || '';
                inputMerek.value = dataInput.merek || '';
                inputJumlah.value = dataInput.jumlah || '';
                if (dataInput.harga && dataInput.harga.trim() !== "") {
                    inputHarga.value = murnikanAngka(dataInput.harga);
                    hitungSubtotal();
                } else {
                    inputHarga.value = "";
                    inputSubtotal.value = "";
                }
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            muatDataDariMemori();
            checkTablePlaceholder();
            updateGrandTotal();

            const selectMetode = document.getElementById('metode_pembayaran');
            if (selectMetode) {
                const savedMetode = localStorage.getItem('pilihan_metode_pembayaran');
                if (savedMetode) {
                    selectMetode.value = savedMetode;
                }
                selectMetode.addEventListener('mousedown', function() {
                    this.style.borderColor = '';
                });

                selectMetode.addEventListener('change', function() {
                    localStorage.setItem('pilihan_metode_pembayaran', this.value);
                    if (this.value !== "") {
                        this.style.borderColor = '';
                    }
                });
            }

            document.addEventListener('click', function(e) {
                const dropdown = document.getElementById('dropdown-barang');
                const inputBarang = document.querySelector('.input-barang');
                const inputMerek = document.querySelector('.input-merek');

                if (dropdown && inputBarang && inputMerek) {
                    if (!inputBarang.contains(e.target) &&
                        !inputMerek.contains(e.target) &&
                        !dropdown.contains(e.target)) {
                        dropdown.style.display = 'none';
                    }
                }
            });
        });

        function showToast(message) {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = 'toast error';

            const icon =
                `<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>`;

            const title = "Error";

            toast.innerHTML = `
                <div class="toast-icon">${icon}</div>
                <div class="toast-content">
                    <span class="toast-single-line"><strong>${title}:</strong> ${message}</span>
                </div>
                <div class="toast-timer"></div>
            `;

            container.appendChild(toast);
            setTimeout(() => {
                toast.style.transform = "translateX(120%)";
                toast.style.opacity = "0";
                toast.style.transition = "all 0.3s ease";
                setTimeout(() => toast.remove(), 400);
            }, 2500);
        }

        function updateNomorUrut() {
            const rows = document.querySelectorAll('#sales-items-body tr:not(.placeholder-row)');
            rows.forEach((row, index) => {
                row.cells[0].innerText = index + 1;
            });
        }

        function showSuccessToast(message) {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = 'toast success';

            const icon =
                `<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>`;

            const title = "Success";

            toast.innerHTML = `
                <div class="toast-icon">${icon}</div>
                <div class="toast-content">
                    <span class="toast-single-line"><strong>${title}:</strong> ${message}</span>
                </div>
                <div class="toast-timer"></div>
            `;

            container.appendChild(toast);

            setTimeout(() => {
                toast.style.transform = "translateX(120%)";
                toast.style.opacity = "0";
                toast.style.transition = "all 0.3s ease";
                setTimeout(() => toast.remove(), 400);
            }, 2500);
        }

        if (btnSelesai) {
            btnSelesai.addEventListener('click', async function() {
                const dataKeranjang = JSON.parse(localStorage.getItem('keranjang_penjualan')) || [];
                const selectMetode = document.getElementById('metode_pembayaran');
                const metodePembayaran = selectMetode.value;
                const totalPembayaranRaw = document.getElementById('total_pembayaran').value;

                if (dataKeranjang.length === 0) {
                    return;
                }

                if (metodePembayaran === "Pilih" || !metodePembayaran) {
                    return;
                }

                btnSelesai.disabled = true;

                try {
                    const response = await fetch("{{ route('penjualan.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            keranjang: dataKeranjang,
                            metode_pembayaran: metodePembayaran,
                            total_pembayaran: totalPembayaranRaw.replace(/[^\d]/g, '')
                        })
                    });

                    const result = await response.json();

                    if (result.success) {
                        localStorage.removeItem('keranjang_penjualan');
                        localStorage.removeItem('draft_input_penjualan');
                        localStorage.removeItem('pilihan_metode_pembayaran');

                        const tableBody = document.getElementById('sales-items-body');
                        if (tableBody) {
                            tableBody.innerHTML = '';
                        }
                        if (typeof checkTablePlaceholder === "function") {
                            checkTablePlaceholder();
                        }

                        const inputsToReset = [
                            document.querySelector('.input-barang'),
                            document.querySelector('.input-merek'),
                            document.querySelector('.input-jumlah'),
                            document.querySelector('.input-harga'),
                            document.getElementById('subtotal_input')
                        ];

                        inputsToReset.forEach(el => {
                            if (el) el.value = '';
                            el.style.borderColor = '';
                        });

                        const selectMetode = document.getElementById('metode_pembayaran');
                        if (selectMetode) {
                            selectMetode.value = '';
                            localStorage.removeItem('pilihan_metode_pembayaran');
                        }

                        if (typeof updateGrandTotal === "function") {
                            updateGrandTotal();
                        }

                        if (result.next_no_transaksi) {
                            const inputNoTransaksi = document.getElementById('no_transaksi');
                            if (inputNoTransaksi) {
                                inputNoTransaksi.value = result.next_no_transaksi;
                            }
                        }

                        if (typeof showSuccessToast === "function") {
                            showSuccessToast("Transaksi tersimpan.");
                        }
                    } else {
                        showToast("Gagal: " + result.message);
                    }
                } catch (error) {
                    console.error("Error:", error);
                    showToast("Terjadi kesalahan koneksi ke server.");
                } finally {
                    btnSelesai.disabled = false;
                }
            });
        }

        @if (session('success'))
            showSuccessToast("{{ session('success') }}");
        @endif
    </script>
</body>

</html>
