<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Detail Transaksi Penjualan</title>
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
            border: 1.5px solid #64748B;
            color: #475569;
            min-width: 120px;
        }

        .report-tab.active-penjualan {
            background-color: #1e293b;
            border: 1.5px solid #0f172a;
            color: #FFFFFF;
            cursor: default;
            transition: all 0.3s ease;
        }

        .report-tab.active-pembelian {
            background-color: #1e293b;
            border: 1.5px solid #0f172a;
            color: #FFFFFF;
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
            overflow-x: visible !important;
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

        .table-header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .col-det-no {
            width: 59px;
            text-align: center;
        }

        .col-det-nama {
            width: 190px;
            text-align: left;
        }

        .col-det-merek {
            width: 100px;
            text-align: left;
        }

        .col-det-jumlah {
            width: 90px;
            text-align: center;
        }

        .col-det-harga {
            width: 110px;
            text-align: left;
        }

        .col-det-subtotal {
            width: 110px;
            text-align: left;
        }

        .col-det-profit {
            width: 110px;
            text-align: left;
        }

        .col-det-aksi {
            width: 170px;
            text-align: left;
        }

        .table-container td {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .table-header-content h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 800;
            color: #0F172A;
        }

        .transaction-info {
            display: flex;
            flex-direction: column;
        }

        .detail-actions-row {
            display: flex;
            justify-content: flex-end;
            margin: 0 0 15px 0;
        }

        .btn-add-item {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 27px;
            padding: 4.5px 15px;
            border-radius: 4px;
            background-color: #1E293B;
            color: #FFFFFF;
            border: 1.5px solid #0F172A;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            cursor: pointer;
            text-decoration: none;
            white-space: nowrap;
            transition: all 0.3s ease;
        }

        .btn-add-item:hover {
            background-color: #334155;
            border-color: #1e293b !important;
            transition: all 0.3s ease;
        }

        .aksi-btns {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .aksi-btns .btn-edit,
        .aksi-btns .btn-delete-item {
            min-width: 70px;
        }

        .btn-edit {
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
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
        }

        .btn-edit:hover {
            background-color: #1e293b;
            border-color: #0f172a !important;
            color: #FFFFFF;
            transition: all 0.3s ease;
        }

        .btn-edit-metode {
            background-color: #F8FAFC;
            color: #64748B;
            border: 1.5px solid #E2E8F0;
            border-radius: 4px;
            padding: 4px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            width: 23px;
            height: 23px;
            outline: none;
        }

        .btn-delete-item {
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
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
        }

        .btn-delete-item:hover {
            background-color: #dc2626;
            border-color: #881337 !important;
            transition: all 0.3s ease;
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
            z-index: 1100;
            padding: 20px;
            box-sizing: border-box;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-content {
            width: 100%;
            max-width: min(320px, calc(100vw - 40px));
            margin-left: auto;
            margin-right: auto;
            box-sizing: border-box;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-cancel {
            background-color: #F1F5F9;
            color: #475569;
            padding: 5px 20px;
            border-radius: 4px;
            font-weight: 800;
            cursor: pointer;
            font-size: 12px;
            border: 1.5px solid #CBD5E1;
        }

        .btn-save {
            background-color: #1e293b;
            color: #FFFFFF;
            padding: 5px 20px;
            border-radius: 4px;
            font-weight: 800;
            cursor: pointer;
            font-size: 12px;
            border: 1.5px solid #0f172a;
        }

        #btnKonfirmasiHapus {
            background-color: #EF4444 !important;
            border: 1.5px solid #9f1239 !important;
            color: #FFFFFF !important;
            padding: 12px 0;
        }

        .minimal-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.55);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1100;
            padding: 20px;
            box-sizing: border-box;
        }

        .minimal-modal-overlay.active {
            display: flex;
        }

        body.modal-open {
            overflow: hidden;
            touch-action: none;
        }

        .minimal-modal {
            width: 100%;
            max-width: 360px;
            background: #FFFFFF;
            border-radius: 8px;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        .minimal-modal-header {
            padding: 14px 16px;
            background: #F8FAFC;
            border-bottom: 1px solid #E2E8F0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .minimal-modal-title {
            margin: 0;
            font-size: 14px;
            font-weight: 900;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            color: #0F172A;
        }

        .minimal-modal-close {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            border: 1px solid #E2E8F0;
            background: #FFFFFF;
            color: #64748B;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .minimal-modal-close svg {
            width: 16px;
            height: 16px;
        }

        .minimal-modal-body {
            padding: 16px;
        }

        .minimal-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .minimal-form-grid .form-group {
            margin: 0;
        }

        .minimal-form-grid .form-group label {
            display: block;
            font-size: 11px;
            font-weight: 900;
            color: #334155;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .minimal-form-grid .form-group input {
            width: 100%;
            height: 38px;
            border-radius: 6px;
            border: 1px solid #CBD5E1;
            padding: 0 12px;
            box-sizing: border-box;
            outline: none;
            color: #0F172A;
            background: #FFFFFF;
            font-size: 12px;
        }

        .minimal-form-grid .span-2 {
            grid-column: span 2;
        }

        .minimal-readonly {
            background: #F1F5F9 !important;
            cursor: default;
        }

        .minimal-modal-footer {
            padding: 14px 16px;
            border-top: 1px solid #E2E8F0;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            background: #FFFFFF;
        }

        .minimal-btn-primary {
            background-color: #1E293B;
            color: #FFFFFF;
            height: 38px;
            padding: 0 10px;
            border-radius: 6px;
            border: 1.5px solid #0F172A;
            text-transform: uppercase;
            font-weight: 900;
            font-size: 11px;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .minimal-btn-primary:hover {
            background-color: #334155;
            border-color: #1e293b !important;
            transition: all 0.3s ease;
        }

        @media (max-width: 639.98px) {
            .minimal-modal {
                max-width: 440px;
            }

            .minimal-form-grid {
                grid-template-columns: 1fr;
            }

            .minimal-form-grid .span-2 {
                grid-column: span 1;
            }

            .minimal-modal-footer {
                justify-content: stretch;
            }

            .minimal-btn-primary {
                width: 100%;
            }

            .info-label {
                font-size: 11px !important;
                white-space: nowrap;
            }

            .info-capsule {
                font-size: 8px !important;
                padding: 2px 8px !important;
                white-space: nowrap;
            }

            .btn-edit-metode {
                width: 20px !important;
                height: 20px !important;
                padding: 1px !important;
            }

            .btn-edit-metode svg {
                width: 8px !important;
                height: 8px !important;
                stroke-width: 3 !important;
            }
        }

        @media (max-width: 1023.98px) {
            .minimal-modal-overlay {
                padding-left: 20px;
                padding-right: 20px;
            }

            .minimal-modal {
                max-width: 320px;
            }

            .detail-actions-row {
                justify-content: stretch;
            }

            #btnTambahBarang {
                width: 100%;
            }
        }

        @media (max-width: 1023.98px) {
            .btn-add-item {
                font-size: 12px;
            }
        }

        .info-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 5px;
        }

        .capsule-tunai {
            background-color: #DCFCE7 !important;
            color: #166534 !important;
            border-color: #86EFAC !important;
        }

        .capsule-transfer {
            background-color: #DBEAFE !important;
            color: #1E40AF !important;
            border-color: #93C5FD !important;
        }

        .info-label {
            margin: 0;
            font-size: 14px;
            font-weight: 800;
            color: #475569;
        }

        .info-capsule {
            margin: 0;
            background-color: #F1F5F9;
            color: #1E293B;
            padding: 2px 15px;
            border-radius: 4px;
            border: 1.5px solid #E2E8F0;
            font-size: 10px;
            font-weight: 800;
            display: inline-block;
        }

        .btn-back {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 27px;
            height: 27px;
            background-color: #F8FAFC;
            color: #64748B;
            border: 1.5px solid #E2E8F0 !important;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-back svg {
            width: 16px;
            height: 16px;
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
            border-top: 1.5px solid #E2E8F0;
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
            border-bottom: 1.5px solid #E2E8F0;
        }

        table tbody tr:last-child td:first-child {
            border-bottom-left-radius: 8px;
        }

        table tbody tr:last-child td:last-child {
            border-bottom-right-radius: 8px;
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

        .detail-table-scroll-wrapper {
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
            z-index: 10000;
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

            body.sidebar-open .sidebar-toggle-btn {
                display: none;
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
                gap: 15px;
            }

            .detail-table-scroll-wrapper {
                overflow-x: auto;
            }

            .detail-table-scroll-wrapper table thead th {
                border-top: none;
            }

            .detail-table-scroll-wrapper table tbody tr:last-child td {
                border-bottom: none;
            }

            .detail-table-scroll-wrapper table th:first-child,
            .detail-table-scroll-wrapper table td:first-child {
                border-left: none;
            }

            .detail-table-scroll-wrapper table th:last-child,
            .detail-table-scroll-wrapper table td:last-child {
                border-right: none;
            }
        }

        @media (min-width: 1024px) {
            .detail-table-scroll-wrapper {
                overflow-x: hidden;
                border: none;
                background-color: transparent;
                border-radius: 0;
                margin-bottom: 0;
            }
        }

        @media (max-width: 639.98px) {
            .page-header h2 {
                font-size: 16px !important;
                white-space: nowrap !important;
            }

            .report-filter-wrapper {
                flex-direction: column;
                align-items: stretch;
            }

            .report-tab {
                width: 100%;
            }

            .header-left {
                gap: 10px !important;
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

            .total-payment-row {
                justify-content: stretch !important;
            }

            .total-payment-box {
                width: 100% !important;
                min-width: 0 !important;
                box-sizing: border-box;
            }

            .info-label {
                margin: 0;
                font-size: 12px;
                font-weight: 800;
                color: #475569;
            }

            .info-capsule {
                margin: 0;
                background-color: #F1F5F9;
                color: #1E293B;
                padding: 2px 15px;
                border-radius: 4px;
                border: 1.5px solid #E2E8F0;
                font-size: 8px;
                font-weight: 800;
                display: inline-block;
            }
        }

        .toast {
            background: #ffffff;
            padding: 10px 15px;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(87, 58, 58, 0.1);
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


        .toast.success .toast-icon {
            background: #10B981;
            color: #ffffff;
            border: 1.5px solid #059669;
        }

        .toast.success .toast-timer {
            background: #10B981;
        }

        .placeholder-row td.placeholder-text {
            padding: 50px !important;
            text-align: center;
            color: #94A3B8;
            font-style: italic;
            border-bottom: none !important;
            height: auto !important;
            line-height: normal !important;
            border-bottom: 1.5px solid #E2E8F0 !important;
        }

        .btn-toggle-metode {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            padding: 4px;
            cursor: pointer;
            color: #64748B;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
        }

        .btn-toggle-metode:hover {
            background: #e2e8f0;
            color: #2563EB;
            transform: scale(1.1);
        }

        .btn-toggle-metode:active {
            transform: scale(0.9);
        }

        #text-metode-pembayaran {
            transition: all 0.3s ease;
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
                <div class="icon-circle"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <path d="M16.5 9.4 7.55 4.24"></path>
                        <path
                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                        </path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg></div>Inventori
            </a>
            <a href="{{ route('penjualan') }}" class="nav-link">
                <div class="icon-circle"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg></div>Penjualan
            </a>
            <a href="{{ route('pembelian') }}" class="nav-link">
                <div class="icon-circle"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <rect x="1" y="3" width="15" height="13"></rect>
                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                    </svg></div>Pembelian
            </a>
            <a href="{{ route('laporan.rekap.penjualan') }}" class="nav-link active">
                <div class="icon-circle"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <line x1="10" y1="9" x2="8" y2="9"></line>
                    </svg></div>Laporan
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
                <div class="icon-circle"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg></div>Keluar
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
            <button type="button" class="report-tab active-penjualan">Penjualan</button>
            <button type="button" class="report-tab"
                onclick="triggerLoading('{{ route('laporan.rekap.pembelian') }}')">Pembelian</button>
        </div>
        <form action="{{ route('laporan.rekap.penjualan') }}" method="GET" class="date-filter-grid"
            id="filter-form">
            <div class="form-group">
                <label>TANGGAL MULAI</label>
                <input type="date" name="tgl_mulai" id="tanggal_mulai">
            </div>
            <div class="form-group">
                <label>TANGGAL AKHIR</label>
                <input type="date" name="tgl_akhir" id="tanggal_akhir">
            </div>
            <div class="form-group">
                <button type="submit" class="btn-tampilkan">TAMPILKAN</button>
            </div>
        </form>
        <div class="table-container">
            <div class="table-header-content">
                <div class="transaction-info">
                    <h3 style="margin: 0 0 15px 0; font-size: 18px; font-weight: 800; color: #0F172A;">
                        Detail Transaksi Penjualan
                    </h3>
                    <div class="info-row">
                        <p class="info-label">No. Transaksi :</p>
                        <p class="info-capsule">{{ $penjualan->no_transaksi }}</p>
                    </div>
                    <div class="info-row">
                        <p class="info-label">Tanggal :</p>
                        <p class="info-capsule">{{ \Carbon\Carbon::parse($penjualan->tanggal)->format('d/m/Y') }}</p>
                    </div>
                    <div class="info-row" style="display: flex; align-items: center; gap: 10px;">
                        <p class="info-label">Metode Pembayaran :</p>

                        <div id="container-metode"
                            style="display: flex; align-items: center; gap: 8px; transition: all 0.3s ease;">
                            @if (strtolower($penjualan->metode_pembayaran) == 'tunai')
                                <p id="capsule-metode" class="info-capsule capsule-tunai">TUNAI</p>
                            @else
                                <p id="capsule-metode" class="info-capsule capsule-transfer">
                                    {{ strtoupper($penjualan->metode_pembayaran) }}</p>
                            @endif

                            <button type="button" onclick="ubahMetodeCepat({{ $penjualan->id_penjualan }})"
                                class="btn-edit-metode">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="info-row">
                        <p class="info-label">Keuntungan Transaksi :</p>
                        <p class="info-capsule">Rp {{ number_format($totalProfit, 0, ',', '.') }}</p>
                    </div>
                </div>
                <a href="{{ route('laporan.penjualan.transaksi', ['tanggal' => $penjualan->tanggal]) }}"
                    class="btn-back" id="btnBackToTransaksi">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </a>
            </div>
            <div class="detail-actions-row">
                <a href="#" class="btn-add-item" id="btnTambahBarang">Tambah Barang</a>
            </div>
            <div class="detail-table-scroll-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th class="col-det-no">No</th>
                            <th class="col-det-nama">Nama Barang</th>
                            <th class="col-det-merek">Merek</th>
                            <th class="col-det-jumlah">Jumlah</th>
                            <th class="col-det-harga">Harga</th>
                            <th class="col-det-subtotal">Subtotal</th>
                            <th class="col-det-profit">Profit</th>
                            <th class="col-det-aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($rincianBarang->isEmpty())
                            <tr class="placeholder-row">
                                <td colspan="8" class="placeholder-text">Tidak ada barang.</td>
                            </tr>
                        @else
                            @foreach ($rincianBarang as $index => $item)
                                <tr>
                                    <td class="col-det-no">{{ $index + 1 }}</td>
                                    <td class="col-det-nama">
                                        {{ $item->barang->nama_barang ?? 'Barang Tidak Diketahui' }}</td>
                                    <td class="col-det-merek">{{ $item->barang->merek ?? '-' }}</td>
                                    <td class="col-det-jumlah">{{ $item->jumlah }}</td>
                                    <td class="col-det-harga">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td class="col-det-subtotal">Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                    <td class="col-det-profit">Rp
                                        {{ number_format(($item->harga - $item->modal) * $item->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td class="col-det-aksi">
                                        <div class="aksi-btns">
                                            <a href="#" class="btn-edit"
                                                data-id="{{ $item->id_detail_penjualan }}">Edit</a>

                                            <a href="#" class="btn-delete-item btn-trigger-hapus"
                                                data-id="{{ $item->id_detail_penjualan }}">Hapus</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="total-payment-row" style="margin-top: 15px; display: flex; justify-content: flex-end;">
                <div class="total-payment-box"
                    style="background: #F8FAFC; border: 1.5px solid #E2E8F0; padding: 15px; border-radius: 8px; min-width: 200px;">
                    <p style="font-size: 12px; font-weight: 800; color: #64748B; text-transform: uppercase;">
                        Total Pembayaran
                    </p>
                    <p style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0;">
                        Rp {{ number_format($penjualan->total, 0, ',', '.') }}
                    </p>
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
        <div class="minimal-modal-overlay" id="minimalTambahOverlay">
            <div class="minimal-modal" role="dialog" aria-modal="true">
                <form action="{{ route('laporan.penjualan.tambah-barang') }}" method="POST">
                    @csrf

                    <input type="hidden" name="id_penjualan" value="{{ $penjualan->id_penjualan }}">

                    <div class="minimal-modal-header">
                        <h3 class="minimal-modal-title">Tambah Barang</h3>
                        <button type="button" class="minimal-modal-close" id="minimalTambahClose"
                            aria-label="Tutup">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>

                    <div class="minimal-modal-body">
                        <div class="minimal-form-grid">
                            <div class="form-group span-2" style="position: relative;">
                                <label for="minNamaBarang">Nama Barang</label>
                                <input type="text" name="nama_barang" id="minNamaBarang" autocomplete="off"
                                    spellcheck="false" required>
                            </div>
                            <div class="form-group span-2" style="position: relative;">
                                <label for="minMerek">Merek</label>
                                <input type="text" name="merek" id="minMerek" autocomplete="off"
                                    spellcheck="false" required>
                            </div>
                            <div class="form-group">
                                <label for="minJumlah">Jumlah</label>
                                <input type="text" name="jumlah" id="minJumlah" inputmode="numeric"
                                    pattern="[0-9]*" autocomplete="off" spellcheck="false" required>
                            </div>
                            <div class="form-group">
                                <label for="minHarga">Harga</label>
                                <input type="text" name="harga" id="minHarga" inputmode="numeric"
                                    autocomplete="off" spellcheck="false" required>
                            </div>
                            <div class="form-group span-2">
                                <label for="minSubtotal">Subtotal</label>
                                <input type="text" id="minSubtotal" class="minimal-readonly" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="minimal-modal-footer">
                        <button type="submit" class="minimal-btn-primary" id="minBtnTambah">Tambah</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="minimal-modal-overlay" id="minimalEditOverlay">
            <div class="minimal-modal" role="dialog" aria-modal="true">
                <form id="formEditBarang" method="POST" action="">
                    @csrf
                    @method('PUT') <div class="minimal-modal-header">
                        <h3 class="minimal-modal-title">Edit Barang</h3>
                        <button type="button" class="minimal-modal-close" id="minimalEditClose" aria-label="Tutup">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>

                    <div class="minimal-modal-body">
                        <div class="minimal-form-grid">
                            <div class="form-group span-2" style="position: relative;">
                                <label for="edNamaBarang">Nama Barang</label>
                                <input type="text" id="edNamaBarang" name="nama_barang" autocomplete="off"
                                    spellcheck="false" required>
                            </div>

                            <div class="form-group span-2" style="position: relative;">
                                <label for="edMerek">Merek</label>
                                <input type="text" id="edMerek" name="merek" autocomplete="off"
                                    spellcheck="false" required>
                            </div>

                            <div class="form-group">
                                <label for="edJumlah">Jumlah</label>
                                <input type="text" id="edJumlah" name="jumlah" inputmode="numeric"
                                    pattern="[0-9]*" autocomplete="off" spellcheck="false" required>
                            </div>

                            <div class="form-group">
                                <label for="edHarga">Harga</label>
                                <input type="text" id="edHarga" name="harga" inputmode="numeric"
                                    autocomplete="off" spellcheck="false" required>
                            </div>

                            <div class="form-group span-2">
                                <label for="edSubtotal">Subtotal</label>
                                <input type="text" id="edSubtotal" class="minimal-readonly" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="minimal-modal-footer">
                        <button type="button" class="minimal-btn-primary" id="minBtnSimpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal-overlay" id="modalHapus">
            <div class="modal-content" style="position: relative;">
                <div style="display: flex; justify-content: center; margin-bottom: 10px;">
                    <div
                        style="background-color: #FEF2F2; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 1.5px solid #EF4444;">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#EF4444"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                            </path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </div>
                </div>
                <div style="text-align: center;">
                    <h3
                        style="margin: 0; font-size: 20px; color: #0F172A; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                        HAPUS BARANG
                    </h3>
                    <p style="font-size: 14px; color: #64748B; margin-bottom: 20px; line-height: 1.5;">
                        Anda yakin ingin menghapus <strong>barang</strong> ini?
                    </p>
                    <form id="formHapusBarang" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="current_url" value="{{ request()->fullUrl() }}">
                        <div style="display: flex; justify-content: center; gap: 10px;">
                            <button type="button" class="btn-cancel" id="btnTidakHapus"
                                style="flex: 1; padding: 12px 0; border: 1.5px solid #CBD5E1; font-weight: 800;">
                                TIDAK
                            </button>
                            <button type="button" class="btn-save" id="btnKonfirmasiHapus"
                                style="flex: 1; padding: 12px 0; font-weight: 800;">
                                IYA
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <div id="toast-container"></div>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <script>
        const allBarang = @json($barang ?? []);
        const loadingOverlay = document.getElementById('loading-overlay');

        function triggerLoading(targetUrl) {
            if (!targetUrl || targetUrl === '#') return;
            loadingOverlay.style.display = 'flex';
            loadingOverlay.style.opacity = '1';
            window.location.href = targetUrl;
        }

        function murnikanAngka(string) {
            if (!string) return "0";
            return string.toString().replace(/[^\d]/g, '');
        }

        function formatRupiahVisual(angka) {
            if (!angka || angka == 0 || angka == "") return "";
            return "Rp " + parseInt(angka).toLocaleString('id-ID');
        }

        function minParseNumber(value) {
            const num = Number(murnikanAngka(value));
            return Number.isFinite(num) ? num : 0;
        }

        function minFormatRupiah(value) {
            const num = Number(value);
            if (!Number.isFinite(num)) return '';
            return num.toLocaleString('id-ID');
        }

        function minCellText(row, selectorOrIndex) {
            if (!row) return '';
            if (typeof selectorOrIndex === 'number') {
                const cells = row.querySelectorAll('td');
                return cells[selectorOrIndex]?.textContent?.trim() || '';
            }
            const el = row.querySelector(selectorOrIndex);
            return el?.textContent?.trim() || '';
        }

        (function() {
            const openBtn = document.getElementById('btnTambahBarang');
            const overlay = document.getElementById('minimalTambahOverlay');
            const closeBtn = document.getElementById('minimalTambahClose');
            const btnTambah = document.getElementById('minBtnTambah');

            const inNama = document.getElementById('minNamaBarang');
            const inMerek = document.getElementById('minMerek');
            const inJumlah = document.getElementById('minJumlah');
            const inHarga = document.getElementById('minHarga');
            const inSubtotal = document.getElementById('minSubtotal');

            if (inHarga) {
                inHarga.addEventListener('input', function() {
                    let cursorPosition = this.selectionStart;
                    let originalLength = this.value.length;

                    let val = murnikanAngka(this.value);
                    if (val.startsWith('0')) val = val.replace(/^0+/, '');

                    this.value = formatRupiahVisual(val);

                    let newLength = this.value.length;
                    let newCursorPos = cursorPosition + (newLength - originalLength);
                    if (newCursorPos < 3 && this.value.length > 0) newCursorPos = 3;

                    this.setSelectionRange(newCursorPos, newCursorPos);
                    updateSubtotal();
                });
            }

            if (inJumlah) {
                inJumlah.addEventListener('input', function() {
                    let value = this.value.replace(/[^0-9]/g, '');
                    if (value.startsWith('0')) {
                        value = value.replace(/^0+/, '');
                    }
                    this.value = value;
                    updateSubtotal();
                });
            }

            const dropdownNama = document.createElement('div');
            dropdownNama.className = 'dropdown-suggestion';
            dropdownNama.style.display = 'none';
            if (inNama) inNama.parentNode.appendChild(dropdownNama);

            const dropdownMerek = document.createElement('div');
            dropdownMerek.className = 'dropdown-suggestion';
            dropdownMerek.style.display = 'none';
            if (inMerek) inMerek.parentNode.appendChild(dropdownMerek);

            function setupSuggestion(inputEl, dropdownEl, filterField) {
                if (!inputEl) return;
                inputEl.addEventListener('input', function() {
                    const keyword = this.value.toLowerCase();
                    if (!keyword) {
                        dropdownEl.style.display = 'none';
                        if (inHarga) inHarga.value = '';
                        updateSubtotal();
                        return;
                    }

                    const matches = allBarang.filter(b =>
                        (b[filterField] || "").toLowerCase().includes(keyword)
                    ).slice(0, 3);

                    if (matches.length > 0) {
                        dropdownEl.innerHTML = '';
                        matches.forEach(barang => {
                            const item = document.createElement('div');
                            item.className = 'suggestion-item';

                            if (filterField === 'merek') {
                                item.innerHTML =
                                    `<strong>${barang.merek}</strong> - <small>${barang.nama_barang}</small>`;
                            } else {
                                item.innerHTML =
                                    `<strong>${barang.nama_barang}</strong> - <small>${barang.merek}</small>`;
                            }

                            item.onclick = function() {
                                if (inNama) inNama.value = barang.nama_barang;
                                if (inMerek) inMerek.value = barang.merek;
                                if (inHarga) inHarga.value = formatRupiahVisual(parseInt(barang
                                    .harga_jual));
                                dropdownEl.style.display = 'none';
                                if (inJumlah) inJumlah.focus();
                                updateSubtotal();
                            };
                            dropdownEl.appendChild(item);
                        });
                        dropdownEl.style.display = 'block';
                    } else {
                        dropdownEl.style.display = 'none';
                    }
                });
            }

            setupSuggestion(inNama, dropdownNama, 'nama_barang');
            setupSuggestion(inMerek, dropdownMerek, 'merek');

            document.addEventListener('click', function(e) {
                if (inNama && !inNama.contains(e.target) && !dropdownNama.contains(e.target)) {
                    dropdownNama.style.display = 'none';
                }
                if (inMerek && !inMerek.contains(e.target) && !dropdownMerek.contains(e.target)) {
                    dropdownMerek.style.display = 'none';
                }
            });

            function openModal() {
                if (!overlay) return;
                if (inNama) inNama.value = '';
                if (inMerek) inMerek.value = '';
                if (inJumlah) inJumlah.value = '';
                if (inHarga) inHarga.value = '';
                if (inSubtotal) inSubtotal.value = '';
                dropdownNama.style.display = 'none';
                dropdownMerek.style.display = 'none';
                overlay.classList.add('active');
                document.body.classList.add('modal-open');
                setTimeout(() => inNama && inNama.focus(), 0);
            }

            function closeModal() {
                if (!overlay) return;
                overlay.classList.remove('active');
                document.body.classList.remove('modal-open');
                dropdownNama.style.display = 'none';
                dropdownMerek.style.display = 'none';
            }

            function updateSubtotal() {
                const namaValid = inNama?.value.trim() !== '';
                const merekValid = inMerek?.value.trim() !== '';

                if (!namaValid || !merekValid) {
                    if (inSubtotal) inSubtotal.value = '';
                    return;
                }

                const jumlah = minParseNumber(inJumlah?.value || '');
                const harga = minParseNumber(inHarga?.value || '');
                const subtotal = jumlah * harga;
                if (inSubtotal) inSubtotal.value = subtotal ? formatRupiahVisual(subtotal) : '';
            }

            if (openBtn) {
                openBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    openModal();
                });
            }

            if (closeBtn) closeBtn.addEventListener('click', closeModal);
            if (overlay) {
                overlay.addEventListener('click', function(e) {
                    if (e.target === overlay) closeModal();
                });
            }

            if (btnTambah) {
                btnTambah.addEventListener('click', function() {
                    closeModal();
                });
            }
        })();

        (function() {
            const overlay = document.getElementById('minimalEditOverlay');
            const closeBtn = document.getElementById('minimalEditClose');
            const btnSimpan = document.getElementById('minBtnSimpan');

            const inNama = document.getElementById('edNamaBarang');
            const inMerek = document.getElementById('edMerek');
            const inJumlah = document.getElementById('edJumlah');
            const inHarga = document.getElementById('edHarga');
            const inSubtotal = document.getElementById('edSubtotal');

            const dropdownNama = document.createElement('div');
            dropdownNama.className = 'dropdown-suggestion';
            dropdownNama.style.display = 'none';
            if (inNama) inNama.parentNode.appendChild(dropdownNama);

            const dropdownMerek = document.createElement('div');
            dropdownMerek.className = 'dropdown-suggestion';
            dropdownMerek.style.display = 'none';
            if (inMerek) inMerek.parentNode.appendChild(dropdownMerek);

            if (inHarga) {
                inHarga.addEventListener('input', function() {
                    let cursorPosition = this.selectionStart;
                    let originalLength = this.value.length;
                    let val = murnikanAngka(this.value);
                    if (val.startsWith('0')) val = val.replace(/^0+/, '');
                    this.value = formatRupiahVisual(val);
                    let newCursorPos = cursorPosition + (this.value.length - originalLength);
                    if (newCursorPos < 3 && this.value.length > 0) newCursorPos = 3;
                    this.setSelectionRange(newCursorPos, newCursorPos);
                    updateSubtotal();
                });
            }

            if (inJumlah) {
                inJumlah.addEventListener('input', function() {
                    let val = this.value.replace(/[^0-9]/g, '');

                    if (val.startsWith('0')) {
                        val = val.replace(/^0+/, '');
                    }

                    this.value = val;

                    updateSubtotal();
                });
            }

            function openModalFromRow(row) {
                if (!overlay || !row) return;

                const btnEdit = row.querySelector('.btn-edit');
                const idDetail = btnEdit ? btnEdit.getAttribute('data-id') : null;
                const formEdit = document.getElementById('formEditBarang');

                if (formEdit && idDetail) {
                    formEdit.action = `/laporan/transaksi-penjualan/detail/update/${idDetail}`;
                }

                const nama = minCellText(row, '.col-det-nama') || minCellText(row, 1);
                const merek = minCellText(row, '.col-det-merek') || minCellText(row, 2);
                const jumlahText = minCellText(row, '.col-det-jumlah') || minCellText(row, 3);
                const hargaText = minCellText(row, '.col-det-harga') || minCellText(row, 4);

                if (inNama) inNama.value = nama;
                if (inMerek) inMerek.value = merek;
                if (inJumlah) inJumlah.value = String(minParseNumber(jumlahText));
                if (inHarga) inHarga.value = formatRupiahVisual(minParseNumber(hargaText));

                updateSubtotal();

                overlay.classList.add('active');
                document.body.classList.add('modal-open');
                setTimeout(() => inNama && inNama.focus(), 0);
            }

            function closeModal() {
                if (!overlay) return;
                overlay.classList.remove('active');
                document.body.classList.remove('modal-open');
                if (dropdownNama) dropdownNama.style.display = 'none';
            }

            if (inNama) {
                inNama.addEventListener('input', function() {
                    const keyword = this.value.toLowerCase();
                    if (!keyword) {
                        dropdownNama.style.display = 'none';
                        return;
                    }

                    const matches = allBarang.filter(b =>
                        (b.nama_barang || "").toLowerCase().includes(keyword)
                    ).slice(0, 3);

                    if (matches.length > 0) {
                        dropdownNama.innerHTML = '';
                        matches.forEach(barang => {
                            const item = document.createElement('div');
                            item.className = 'suggestion-item';
                            item.innerHTML =
                                `<strong>${barang.nama_barang}</strong> - <small>${barang.merek}</small>`;

                            item.onclick = function() {
                                if (inNama) inNama.value = barang.nama_barang;
                                if (inMerek) inMerek.value = barang.merek;
                                if (inHarga) inHarga.value = formatRupiahVisual(parseInt(barang
                                    .harga_jual));
                                dropdownNama.style.display = 'none';
                                if (inJumlah) inJumlah.focus();
                                updateSubtotal();
                            };
                            dropdownNama.appendChild(item);
                        });
                        dropdownNama.style.display = 'block';
                    } else {
                        dropdownNama.style.display = 'none';
                    }
                });
            }

            if (inMerek) {
                inMerek.addEventListener('input', function() {
                    const keyword = this.value.toLowerCase();
                    if (!keyword) {
                        dropdownMerek.style.display = 'none';
                        return;
                    }

                    const matches = allBarang.filter(b =>
                        (b.merek || "").toLowerCase().includes(keyword)
                    ).slice(0, 3);

                    if (matches.length > 0) {
                        dropdownMerek.innerHTML = '';
                        matches.forEach(barang => {
                            const item = document.createElement('div');
                            item.className = 'suggestion-item';
                            item.innerHTML =
                                `<strong>${barang.merek}</strong> - <small>${barang.nama_barang}</small>`;

                            item.onclick = function() {
                                if (inNama) inNama.value = barang.nama_barang;
                                if (inMerek) inMerek.value = barang.merek;
                                if (inHarga) inHarga.value = formatRupiahVisual(parseInt(barang
                                    .harga_jual));
                                dropdownMerek.style.display = 'none';
                                if (inJumlah) inJumlah.focus();
                                updateSubtotal();
                            };
                            dropdownMerek.appendChild(item);
                        });
                        dropdownMerek.style.display = 'block';
                    } else {
                        dropdownMerek.style.display = 'none';
                    }
                });
            }

            document.addEventListener('click', function(e) {
                if (inNama && !inNama.contains(e.target) && !dropdownNama.contains(e.target)) {
                    dropdownNama.style.display = 'none';
                }
                if (inMerek && !inMerek.contains(e.target) && !dropdownMerek.contains(e.target)) {
                    dropdownMerek.style.display = 'none';
                }
            });

            function updateSubtotal() {
                const namaValid = inNama?.value.trim() !== '';
                const merekValid = inMerek?.value.trim() !== '';
                if (!namaValid || !merekValid) {
                    if (inSubtotal) inSubtotal.value = '';
                    return;
                }

                const jumlah = minParseNumber(inJumlah?.value || '');
                const harga = minParseNumber(inHarga?.value || '');
                const subtotal = jumlah * harga;
                if (inSubtotal) inSubtotal.value = subtotal ? formatRupiahVisual(subtotal) : '';
            }

            document.querySelectorAll('a.btn-edit').forEach((btn) => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const row = e.currentTarget.closest('tr');
                    openModalFromRow(row);
                });
            });

            if (closeBtn) closeBtn.addEventListener('click', closeModal);
            if (overlay) {
                overlay.addEventListener('click', function(e) {
                    if (e.target === overlay) closeModal();
                });
            }

            if (btnSimpan) {
                btnSimpan.addEventListener('click', function() {
                    const formEdit = document.getElementById('formEditBarang');

                    if (formEdit) {
                        closeModal();
                        formEdit.submit();
                    }
                });
            }
        })();

        (function() {
            const overlay = document.getElementById('modalHapus');
            const btnTidak = document.getElementById('btnTidakHapus');
            const btnIya = document.getElementById('btnKonfirmasiHapus');

            function openModal() {
                if (!overlay) return;
                overlay.classList.add('active');
                document.body.classList.add('modal-open');
            }

            function closeModal() {
                if (!overlay) return;
                overlay.classList.remove('active');
                document.body.classList.remove('modal-open');
            }

            document.querySelectorAll('a.btn-delete-item').forEach((btn) => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    openModal();
                });
            });

            if (overlay) {
                overlay.addEventListener('click', function(e) {
                    if (e.target === overlay) closeModal();
                });
            }

            if (btnTidak) btnTidak.addEventListener('click', closeModal);
            if (btnIya) btnIya.addEventListener('click', closeModal);

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeModal();
            });
        })();

        document.addEventListener('DOMContentLoaded', function() {
            @if (session('error_filter'))
                showToast("{{ session('error_filter') }}");
            @endif

            @if (session('success'))
                showSuccessToast("{{ session('success') }}");
            @endif
        });

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

        const filterForm = document.getElementById('filter-form');
        if (filterForm) {
            filterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const tglMulaiInput = document.getElementById('tanggal_mulai');
                const tglAkhirInput = document.getElementById('tanggal_akhir');
                const valMulai = tglMulaiInput.value;
                const valAkhir = tglAkhirInput.value;
                if (!valMulai || !valAkhir) return;
                if (valMulai > valAkhir) return;
                const url = new URL("{{ route('laporan.rekap.penjualan') }}", window.location.origin);
                url.searchParams.set('tgl_mulai', valMulai);
                url.searchParams.set('tgl_akhir', valAkhir);
                url.searchParams.set('page', 1);
                window.location.href = url.href;
            });
        }

        document.querySelectorAll('.nav-link, .report-tab').forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href') || this.getAttribute('data-url');
                if (href && href !== '#' && !this.classList.contains('active') && !this.classList.contains(
                        'active-penjualan')) {
                    e.preventDefault();
                    triggerLoading(href);
                }
            });
        });

        const logoutBtn = document.getElementById('logout-btn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function(e) {
                e.preventDefault();
                triggerLoading(this.getAttribute('href'));
            });
        }

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

        document.addEventListener('DOMContentLoaded', function() {
            const modalHapus = document.getElementById('modalHapus');
            const formHapus = document.getElementById('formHapusBarang');
            const btnTidakHapus = document.getElementById('btnTidakHapus');
            const btnKonfirmasiHapus = document.getElementById('btnKonfirmasiHapus');

            document.querySelectorAll('.btn-trigger-hapus').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const idDetail = this.getAttribute('data-id');
                    formHapus.action = `/laporan/transaksi-penjualan/detail/hapus/${idDetail}`;
                    modalHapus.classList.add('active');
                });
            });

            btnTidakHapus.addEventListener('click', function() {
                modalHapus.classList.remove('active');
            });

            btnKonfirmasiHapus.addEventListener('click', function() {
                formHapus.submit();
            });
        });

        function ubahMetodeCepat(id) {
            const container = document.getElementById('container-metode');
            const capsule = document.getElementById('capsule-metode');

            container.style.opacity = '0.5';
            container.style.pointerEvents = 'none';

            const url = "/laporan/transaksi-penjualan/detail/toggle-metode/" + id;

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        capsule.innerText = data.new_metode;

                        if (data.new_metode === 'TUNAI') {
                            capsule.className = 'info-capsule capsule-tunai';
                        } else {
                            capsule.className = 'info-capsule capsule-transfer';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                })
                .finally(() => {
                    container.style.opacity = '1';
                    container.style.pointerEvents = 'auto';
                });
        }
    </script>
</body>

</html>
