<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Laporan Rekap Pembelian</title>
    <link rel="icon" type="image/png" href="{{ asset('images/MekarJaya.png') }}">
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
            padding: 10px 20px 10px 5px;
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

        .report-filter-wrapper {
            background-color: #CBD5E1;
            padding: 10px 18px;
            border-radius: 8px;
            border: 1.5px solid #94A3B8;
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            justify-content: flex-start;
        }

        .report-tab {
            padding: 8px 30px;
            border-radius: 6px;
            border: none;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s ease;
            background-color: #F8FAFC;
            color: #475569;
            min-width: 120px;
            border: 1.5px solid #64748B;
        }

        .report-tab.active-penjualan {
            background-color: #1e293b;
            border: 1.5px solid #0f172a;
            color: #FFFFFF;
            transition: all 0.3s ease;
        }

        .report-tab.active-pembelian {
            background-color: #1e293b;
            border: 1.5px solid #0f172a;
            color: #FFFFFF;
            cursor: default;
            transition: all 0.3s ease;
        }

        .date-filter-grid {
            background-color: #CBD5E1;
            padding: 18px;
            border-radius: 8px;
            border: 1.5px solid #94A3B8;
            display: grid;
            grid-template-columns: 1fr 1fr auto;
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
        }

        .form-group input[type="date"] {
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

        .btn-tampilkan {
            background-color: #94A3B8;
            color: #1E293B;
            height: 38px;
            padding: 0 40px;
            border-radius: 6px;
            border: 1.5px solid #64748B !important;
            text-transform: uppercase;
            font-weight: 800;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
        }

        .btn-tampilkan:hover {
            background-color: #64748B;
            color: #FFFFFF;
            border-color: #475569 !important;
            transition: all 0.3s ease;
        }

        .table-container {
            background-color: #FFFFFF;
            border-radius: 8px;
            border: 1.5px solid #E2E8F0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 15px;
            overflow-x: hidden !important;
            width: auto;
            box-sizing: border-box;
        }

        .table-container table {
            width: 100% !important;
            max-width: 100%;
            table-layout: fixed;
            border-collapse: separate;
            border-spacing: 0;
        }

        .rekap-table-scroll-wrapper {
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

        .col-pembelian-no {
            width: 50px;
            text-align: center;
        }

        .col-pembelian-tgl {
            width: 65px;
            text-align: left;
        }

        .col-pembelian-faktur {
            width: 250px;
            text-align: center;
        }

        .col-pembelian-total {
            width: 175px;
            text-align: left;
        }

        .col-pembelian-aksi {
            width: 175px;
            text-align: left;
        }

        .table-container td {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .table-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .table-header-content h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 800;
            color: #0F172A;
        }

        .btn-delete-all {
            background-color: #ef4444;
            color: #FFFFFF;
            border: 1.5px solid #9f1239 !important;
            padding: 4.5px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-delete-all:hover {
            background-color: #dc2626;
            border-color: #881337 !important;
            transition: all 0.3s ease;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 12px;
        }

        table th {
            background-color: #F8FAFC;
            color: #64748B;
            text-align: left;
            border-top: none;
            border-bottom: 1.5px solid #E2E8F0;
            padding: 12px 8px;
            text-transform: uppercase;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.3px;
            white-space: nowrap;
        }

        table td {
            padding: 8px;
            border-bottom: 1.5px solid #F1F5F9;
            color: #1E293B;
            white-space: nowrap;
        }

        table tbody tr:last-child td {
            border-bottom: none;
        }

        table tbody tr:last-child td:first-child {
            border-bottom-left-radius: 8px;
        }

        table tbody tr:last-child td:last-child {
            border-bottom-right-radius: 8px;
        }

        table th:first-child,
        table td:first-child {
            border-left: none;
        }

        table th:last-child,
        table td:last-child {
            border-right: none;
        }

        table thead tr th:first-child {
            border-top-left-radius: 8px;
        }

        table thead tr th:last-child {
            border-top-right-radius: 8px;
        }

        .btn-view {
            background-color: #F8FAFC;
            color: #475569;
            padding: 5px 15px;
            border-radius: 4px;
            border: 1.5px solid #94A3B8 !important;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-view:hover {
            background-color: #1e293b;
            border-color: #0f172a !important;
            color: #FFFFFF;
            transition: all 0.3s ease;
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
            font-size: 12px;
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
            cursor: default;
            border: 1.5px solid #E2E8F0;
        }

        .btn-page {
            background-color: #F8FAFC;
            border: 1.5px solid #E2E8F0;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
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
            font-size: 12px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%2364748B' stroke-width='3.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: calc(100% - 3px) center;
            background-size: 8px;
        }

        @media (max-width: 1023.98px) {
            body {
                height: auto;
                min-height: 100vh;
                overflow-x: hidden;
            }

            body.sidebar-open {
                overflow: hidden;
            }

            .main-container {
                overflow-x: clip;
                width: 100%;
                max-width: 100%;
                padding: 20px;
                overflow-y: visible;
                box-sizing: border-box;
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
                width: 38px;
                height: 38px;
                background-color: #F8FAFC;
                border: 1.5px solid #94A3B8;
                border-radius: 8px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                flex-shrink: 0;
                color: #1E293B;
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

            .page-header {
                padding: 10px 12px;
                gap: 10px;
                border-radius: 10px;
            }

            .header-left {
                min-width: 0;
            }

            .rekap-table-scroll-wrapper {
                overflow-x: auto;
            }
        }

        @media (min-width: 1024px) {
            .rekap-table-scroll-wrapper {
                overflow-x: hidden;
            }
        }

        @media (max-width: 639.98px) {
            .page-header h2 {
                font-size: 16px !important;
                white-space: nowrap !important;
            }

            .header-left {
                gap: 10px !important;
            }

            .report-filter-wrapper {
                flex-direction: column;
                align-items: stretch;
            }

            .report-tab {
                width: 100%;
            }

            .date-filter-grid {
                grid-template-columns: 1fr !important;
                gap: 12px;
            }

            .btn-tampilkan {
                width: 100%;
            }

            .table-container {
                padding: 15px;
            }

            .table-header-content {
                gap: 10px;
                align-items: flex-start;
                flex-direction: column;
            }

            .table-header-content h3 {
                width: 100%;
                text-align: center;
            }

            .btn-delete-all {
                width: 100%;
                text-align: center;
                padding: 4.5px 15px;
                border-radius: 4px;
                font-size: 12px !important;
            }

            #modalHapusSemua .modal-content {
                width: min(520px, calc(100vw - 40px)) !important;
                max-width: calc(100vw - 40px) !important;
                margin-left: 20px;
                margin-right: 20px;
                box-sizing: border-box;
            }

            .pagination-wrapper {
                display: flex;
                flex-direction: column;
                align-items: stretch;
                justify-content: flex-start;
                gap: 8px;
            }

            .pagination-wrapper>.pagination-info-right {
                order: 0 !important;
                position: static !important;
                right: auto !important;
                top: auto !important;
            }

            .pagination-wrapper>.pagination-btns {
                order: 1 !important;
            }

            .pagination-btns {
                display: flex;
                flex-direction: column;
                gap: 8px;
                width: 100%;
                order: 0;
            }

            .pagination-btns .btn-page {
                width: 100%;
                text-align: center;
            }

            .pagination-info-right {
                width: 100%;
                justify-content: center;
                order: 1;
            }

            th.col-pembelian-tgl,
            td.col-pembelian-tgl {
                width: 80.38px !important;
                overflow: visible !important;
                text-overflow: clip !important;
                white-space: nowrap !important;
            }
        }

        @media (min-width: 640px) and (max-width: 1023.98px) {
            .main-container {
                padding: 20px;
                overflow-y: auto;
            }

            th.col-pembelian-tgl,
            td.col-pembelian-tgl {
                width: 80.38px !important;
                overflow: visible !important;
                text-overflow: clip !important;
                white-space: nowrap !important;
            }

            th.col-pembelian-faktur,
            td.col-pembelian-faktur {
                width: 189.62px !important;
            }
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        body.modal-open {
            overflow: hidden;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .modal-content h3 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: 800;
            color: #0F172A;
        }

        .btn-modal-cancel {
            background-color: #F1F5F9;
            color: #475569;
            padding: 12px 0;
            border-radius: 4px;
            border: 1.5px solid #CBD5E1 !important;
            font-weight: 800;
            cursor: pointer;
            font-size: 12px;
            text-transform: uppercase;
            flex: 1;
            transition: all 0.3s ease;
        }

        .btn-modal-confirm {
            background-color: #EF4444;
            color: #FFFFFF;
            padding: 12px 0;
            border-radius: 4px;
            border: 1.5px solid #9f1239 !important;
            font-weight: 800;
            cursor: pointer;
            font-size: 12px;
            text-transform: uppercase;
            flex: 1;
            transition: all 0.3s ease;
        }

        @keyframes modalPop {
            from {
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
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
    </style>
</head>

<body>
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
            <a href="{{ route('laporan.rekap.penjualan') }}" class="nav-link active">
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
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <line x1="10" y1="9" x2="8" y2="9"></line>
                    </svg>
                </div>
                <h2>LAPORAN</h2>
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
        <div class="report-filter-wrapper">
            <button type="button" class="report-tab" data-url="{{ route('laporan.rekap.penjualan') }}">
                Penjualan
            </button>
            <button type="button" class="report-tab active-pembelian"
                data-url="{{ route('laporan.rekap.pembelian') }}">
                Pembelian
            </button>
        </div>
        <form id="filter-form" action="{{ route('laporan.rekap.pembelian') }}" method="GET">
            <div class="date-filter-grid">
                <div class="form-group">
                    <label>TANGGAL MULAI</label>
                    <input type="date" name="tgl_mulai" id="tanggal_mulai">
                </div>
                <div class="form-group">
                    <label>TANGGAL AKHIR</label>
                    <input type="date" name="tgl_akhir" id="tanggal_akhir">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-tampilkan">Tampilkan</button>
                </div>
            </div>
        </form>

        <div id="toast-container"></div>

        <div class="table-container">
            <div class="table-header-content">
                <h3>Rekap Pembelian</h3>
                <button type="button" class="btn-delete-all">Hapus Semua</button>
            </div>
            <div class="rekap-table-scroll-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th class="col-pembelian-no">No</th>
                            <th class="col-pembelian-tgl">Tanggal</th>
                            <th class="col-pembelian-faktur">Jumlah Faktur</th>
                            <th class="col-pembelian-total">Total Pembelian</th>
                            <th class="col-pembelian-aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rekapPembelian as $item)
                            <tr>
                                <td class="col-pembelian-no">
                                    {{ ($rekapPembelian->currentPage() - 1) * $rekapPembelian->perPage() + $loop->iteration }}
                                </td>
                                <td class="col-pembelian-tgl">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                                </td>
                                <td class="col-pembelian-faktur">
                                    {{ $item->jumlah_faktur }}
                                </td>
                                <td class="col-pembelian-total">
                                    Rp {{ number_format($item->total_nominal, 0, ',', '.') }}
                                </td>
                                <td class="col-pembelian-aksi">
                                    <button type="button" class="btn-view"
                                        onclick="window.location.href = '{{ route('laporan.pembelian.faktur', ['tanggal' => $item->tanggal]) }}&rekap_page={{ $rekapPembelian->currentPage() }}'">
                                        Lihat
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    style="padding: 50px; text-align: center; color: #94A3B8; font-style: italic; font-size: 12px;">
                                    Rekap pembelian masih kosong.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrapper">
                <div class="pagination-btns">
                    @if ($rekapPembelian->onFirstPage() || $rekapPembelian->isEmpty())
                        <button class="btn-page disabled" disabled>Sebelumnya</button>
                    @else
                        <a href="{{ $rekapPembelian->previousPageUrl() }}" class="btn-page">Sebelumnya</a>
                    @endif
                    @if ($rekapPembelian->hasMorePages())
                        <a href="{{ $rekapPembelian->nextPageUrl() }}" class="btn-page">Berikutnya</a>
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

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="modal-overlay" id="modalHapusSemua">
        <div class="modal-content" style="width: 300px; padding: 20px; position: relative;">
            <div style="display: flex; justify-content: center; margin-bottom: 10px;">
                <div
                    style="background-color: #FEF2F2; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 1.5px solid #EF4444;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#EF4444"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </div>
            </div>
            <div style="text-align: center;">
                <h3
                    style="margin: 0; font-size: 20px; color: #0F172A; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                    KOSONGKAN REKAP
                </h3>
                <p style="font-size: 14px; color: #64748B; margin-bottom: 20px; line-height: 1.5;">
                    Anda yakin ingin menghapus <strong>seluruh data rekap pembelian</strong>?
                </p>
                <form action="{{ route('laporan.rekap.pembelian.hapus-semua') }}" method="POST"
                    id="formHapusSemua">
                    @csrf
                    @method('DELETE')
                    <div style="display: flex; justify-content: center; gap: 10px;">
                        <button type="button" class="btn-modal-cancel" id="btnBatalHapus">Tidak</button>
                        <button type="submit" class="btn-modal-confirm">Iya</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const loadingOverlay = document.getElementById('loading-overlay');

        function triggerLoading(targetUrl) {
            if (!targetUrl || targetUrl === '#') return;
            loadingOverlay.style.display = 'flex';
            loadingOverlay.style.opacity = '1';
            window.location.href = targetUrl;
        }

        function showToast(message) {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = 'toast error';

            const icon =
                `<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>`;

            toast.innerHTML = `
                <div class="toast-icon">${icon}</div>
                <div class="toast-content">
                    <span class="toast-single-line"><strong>Error:</strong> ${message}</span>
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

        function showSuccessToast(message) {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = 'toast success';

            const icon =
                `<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>`;

            toast.innerHTML = `
                <div class="toast-icon">${icon}</div>
                <div class="toast-content">
                    <span class="toast-single-line"><strong>Success:</strong> ${message}</span>
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

        document.addEventListener('DOMContentLoaded', function() {
            const params = new URLSearchParams(window.location.search);
            const tglMulai = params.get('tgl_mulai');
            const tglAkhir = params.get('tgl_akhir');

            if (tglMulai) document.getElementById('tanggal_mulai').value = tglMulai;
            if (tglAkhir) document.getElementById('tanggal_akhir').value = tglAkhir;

            @if (session('error_filter'))
                showToast("{{ session('error_filter') }}");
            @endif

            @if (session('success'))
                showSuccessToast("{{ session('success') }}");
            @endif
        });

        const filterForm = document.getElementById('filter-form');
        if (filterForm) {
            filterForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const tglMulaiInput = document.getElementById('tanggal_mulai');
                const tglAkhirInput = document.getElementById('tanggal_akhir');
                const perPageSelect = document.getElementById('perPageSelect');

                const valMulai = tglMulaiInput ? tglMulaiInput.value : "";
                const valAkhir = tglAkhirInput ? tglAkhirInput.value : "";

                if (!valMulai || !valAkhir) {
                    return;
                }

                if (valMulai > valAkhir) {
                    return;
                }

                const url = new URL(window.location.origin + window.location.pathname);
                url.searchParams.set('tgl_mulai', valMulai);
                url.searchParams.set('tgl_akhir', valAkhir);

                if (perPageSelect) {
                    url.searchParams.set('per_page', perPageSelect.value);
                }
                url.searchParams.set('page', 1);

                window.location.href = url.href;
            });
        }

        const perPageSelect = document.getElementById('perPageSelect');
        if (perPageSelect) {
            perPageSelect.addEventListener('change', function() {
                const url = new URL(window.location.href);
                url.searchParams.set('per_page', this.value);
                url.searchParams.set('page', 1);
                window.location.href = url.toString();
            });
        }

        const modalHapus = document.getElementById('modalHapusSemua');
        const btnTriggerHapus = document.querySelector('.btn-delete-all');
        const btnBatal = document.getElementById('btnBatalHapus');
        const formHapus = document.getElementById('formHapusSemua');

        if (btnTriggerHapus) {
            btnTriggerHapus.addEventListener('click', () => {
                modalHapus.style.display = 'flex';
                document.body.classList.add('modal-open');
            });
        }

        if (btnBatal) {
            btnBatal.addEventListener('click', () => {
                modalHapus.style.display = 'none';
                document.body.classList.remove('modal-open');
            });
        }

        document.querySelectorAll('.nav-link, .report-tab').forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href') || this.getAttribute('data-url');

                if (href && href !== '#' && !this.classList.contains('active') && !this.classList.contains(
                        'active-pembelian')) {
                    e.preventDefault();
                    triggerLoading(href);
                }
            });
        });

        window.addEventListener('click', (e) => {
            if (e.target == modalHapus) {
                modalHapus.style.display = 'none';
                document.body.classList.remove('modal-open');
            }
        });

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
    </script>
</body>

</html>
