<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Inventori</title>
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

        body.modal-open {
            overflow: hidden;
            position: fixed;
            top: 0;
            width: 100%;
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
            display: block;
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

        @media (max-width: 1023.98px) {
            body {
                height: auto;
                min-height: 100vh;
                overflow-x: clip;
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

            .main-container {
                padding: 12px;
                overflow-y: visible;
                overflow-x: clip;
                width: 100%;
                max-width: 100%;
            }

            .summary-grid,
            .filter-wrapper,
            .table-container {
                margin-left: 0;
                margin-right: 0;
            }

            .page-header,
            .summary-grid,
            .filter-wrapper,
            .table-container {
                width: 100%;
            }

            .table-scroll-wrapper {
                max-width: 100%;
            }

            .table-scroll-wrapper table {
                max-width: none;
            }

            .page-header,
            .summary-grid,
            .filter-wrapper,
            .table-container {
                max-width: 100%;
            }

            .page-header,
            .summary-grid,
            .filter-wrapper,
            .table-container {
                margin-right: 0;
                margin-left: 0;
            }

            .page-header {
                padding: 10px 12px;
                gap: 10px;
                border-radius: 10px;
            }

            .header-left {
                gap: 10px;
                min-width: 0;
            }

            .sidebar-toggle-btn {
                display: inline-flex;
                flex-shrink: 0;
            }

            .page-header h2 {
                font-size: 16px;
            }

            .summary-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .card {
                padding: 14px;
            }

            .card-info h3 {
                font-size: 16px;
            }

            .filter-wrapper {
                grid-template-columns: 1fr;
            }

            .filter-input,
            .filter-select {
                width: 100%;
            }

            .table-container {
                padding: 12px;
            }

            .table-header-content {
                gap: 10px;
                align-items: flex-start;
                flex-direction: column;
            }

            .btn-add {
                width: 100%;
                text-align: center;
                padding: 10px 12px;
                border-radius: 8px;
                font-size: 12px;
            }
        }

        @media (min-width: 640px) and (max-width: 1023.98px) {
            .main-container {
                padding: 20px;
                overflow-y: auto;
            }

            .summary-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 12px;
            }

            .card-info h3 {
                font-size: 16px;
                white-space: normal;
                overflow: visible;
            }

            .card {
                overflow: visible;
            }

            .filter-wrapper {
                grid-template-columns: repeat(5, 1fr);
                gap: 12px;
            }

            .table-container {
                padding-bottom: 12px;
            }

            .modal-overlay {
                padding: 20px;
                box-sizing: border-box;
            }

            .table-header-content {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }

            .btn-add {
                width: auto;
                text-align: center;
                padding: 4.5px 15px;
                border-radius: 4px;
                font-size: 10px !important;
            }
        }

        @media (min-width: 1024px) {
            .table-scroll-wrapper {
                overflow-x: hidden;
            }
        }

        @media (max-width: 639.98px) {
            .main-container {
                padding: 20px !important;
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

            .summary-grid {
                grid-template-columns: 1fr !important;
                gap: 10px;
            }

            .card {
                padding: 14px;
            }

            .card-info h3 {
                white-space: normal;
            }

            .filter-wrapper {
                grid-template-columns: 1fr !important;
                gap: 10px;
            }

            .filter-input,
            .filter-select {
                width: 100%;
            }

            .modal-overlay {
                padding: 20px;
                box-sizing: border-box;
            }

            .modal-content {
                width: 100%;
                max-width: min(320px, calc(100vw - 40px));
                margin-left: auto;
                margin-right: auto;
                box-sizing: border-box;
            }

            .btn-add {
                width: 100%;
                text-align: center;
                padding: 10px 12px;
                border-radius: 8px;
                font-size: 12px !important;
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

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .card {
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1.5px solid #E2E8F0;
            box-sizing: border-box;
            min-width: 0;
            overflow: hidden;
        }

        .card-info {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .card-info p {
            margin: 0;
            font-size: 10px;
            color: #64748B;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }

        .card-info h3 {
            margin: 4px 0 0;
            font-size: 18px;
            color: #0F172A;
            font-weight: 800;
            line-height: 1;
            white-space: nowrap;
            overflow: hidden;
        }

        .card-icon {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-left: 15px;
        }

        .card-icon svg {
            width: 22px;
            height: 22px;
            stroke-width: 3;
        }

        .icon-total {
            color: #4F46E5;
            background-color: #EEF2FF;
            border: 2px solid #C7D2FE;
        }

        .icon-aman {
            color: #22c55e;
            background-color: #f0fdf4;
            border: 2px solid #bbf7d0;
        }

        .icon-kritis {
            color: #D97706;
            background-color: #FFFBEB;
            border: 2px solid #FDE68A;
        }

        .icon-habis {
            color: #ef4444;
            background-color: #fef2f2;
            border: 2px solid #fecaca;
        }

        .filter-wrapper {
            background-color: #CBD5E1;
            padding: 10px;
            border-radius: 8px;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            border: 1.5px solid #94A3B8;
            margin-bottom: 20px;
        }

        .filter-input,
        .filter-select {
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
            opacity: 1;
            display: block;
        }

        .filter-input {
            padding: 0px 15px;
            background-repeat: no-repeat;
            background-position: 12px center;
            background-size: 14px;
        }

        .filter-input:placeholder-shown {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748B' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.3-4.3'/%3E%3C/svg%3E");
            padding-left: 35px;
        }

        .filter-input:not(:placeholder-shown) {
            background-image: none;
            padding-left: 15px;
        }

        .filter-input::placeholder {
            font-style: italic;
            color: #1E293B;
            opacity: 1;
        }

        .filter-select {
            padding: 0 35px 0 15px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394A3B8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: calc(100% - 10px) center;
            background-size: 16px;
            cursor: pointer;
        }

        .filter-input:focus,
        .filter-select:focus {
            border-color: #94A3B8;
            outline: none;
            box-shadow: none;
        }

        .table-container {
            background-color: #FFFFFF;
            border-radius: 8px;
            border: 1.5px solid #E2E8F0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 15px;
            overflow: hidden;
        }

        .table-container table {
            width: 100% !important;
            max-width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .table-scroll-wrapper {
            width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
            margin-bottom: 10px;
            padding: 0;
            border-radius: 8px;
            border: 1.5px solid #E2E8F0;
            background-color: #FFFFFF;
            display: block;
        }

        table td:first-child,
        table th:first-child {
            border-left: none;
        }

        table td:last-child,
        table th:last-child {
            border-right: none;
        }

        table thead tr th:first-child {
            border-top-left-radius: 8px;
        }

        table thead tr th:last-child {
            border-top-right-radius: 8px;
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

        .btn-add {
            background-color: #1e293b;
            border: 1.5px solid #0f172a;
            color: #FFFFFF;
            padding: 4.5px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 10px;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-add:hover {
            background-color: #334155;
            border-color: #1e293b !important;
            transition: all 0.3s ease;
        }

        .form-control-select {
            width: 100%;
            height: 38px;
            padding: 0px 12px;
            font-size: 12px;
            color: #0F172A;
            border: 1px solid #CBD5E1;
            border-radius: 4px;
            outline: none;
            cursor: pointer;
            margin: 0;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394A3B8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 12px;
            padding-right: 34px;
            max-width: 100%;
            box-sizing: border-box;
        }

        .form-control-select.placeholder-style {
            color: #94A3B8;
        }

        .form-control-select {
            color: #0F172A;
        }

        .form-control-select option {
            color: #0F172A;
            background-color: #FFFFFF;
        }

        .form-control-select:focus {
            border-color: #1e293b;
        }

        table {
            min-width: 1000px;
            width: 1000px;
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
            border-bottom: none;
        }

        table th:first-child,
        table td:first-child {
            border-left: none !important;
        }

        table th:last-child,
        table td:last-child {
            border-right: none !important;
        }

        table thead tr th:first-child {
            border-top-left-radius: 8px;
            border-top: none;
        }

        table thead tr th:last-child {
            border-top-right-radius: 8px;
        }

        table thead tr th {
            background-color: #F8FAFC;
            border-top: none;
            border-bottom: 1.5px solid #E2E8F0;
        }

        table th:nth-child(1),
        table td:nth-child(1) {
            width: 50px;
            min-width: 50px;
        }

        table th:nth-child(2),
        table td:nth-child(2) {
            width: 160px;
            min-width: 160px;
        }

        table th:nth-child(3),
        table td:nth-child(3) {
            width: 100px;
            min-width: 100px;
        }

        table th:nth-child(4),
        table td:nth-child(4) {
            width: 90px;
            min-width: 90px;
        }

        table th:nth-child(5),
        table td:nth-child(5) {
            width: 70px;
            min-width: 70px;
        }

        table th:nth-child(6),
        table td:nth-child(6) {
            width: 50px;
            min-width: 50px;
        }

        table th:nth-child(7),
        table td:nth-child(7) {
            width: 80px;
            min-width: 80px;
        }

        table th:nth-child(8),
        table td:nth-child(8) {
            width: 80px;
            min-width: 80px;
        }

        table th:nth-child(9),
        table td:nth-child(9) {
            width: 90px;
            min-width: 90px;
        }

        table th:nth-child(10),
        table td:nth-child(10) {
            width: 95px;
            min-width: 95px;
        }

        table th:nth-child(11),
        table td:nth-child(11) {
            width: 115px;
            min-width: 115px;
        }

        table th:nth-child(12),
        table td:nth-child(12) {
            width: 90px;
            min-width: 90px;
        }

        table th:nth-child(13),
        table td:nth-child(13) {
            width: 80px;
            min-width: 80px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
            background-color: #F1F5F9;
            color: #475569;
            width: 58px;
            justify-content: flex-start;
            box-sizing: border-box;
            border: 1.5px solid transparent;
        }

        .badge-aman {
            background-color: #ecfdf5;
            color: #065f46;
            border-color: #10b98133;
        }

        .badge-kritis {
            background-color: #fffbeb;
            color: #92400e;
            border-color: #f59e0b33;
        }

        .badge-habis {
            background-color: #fef2f2;
            color: #991b1b;
            border-color: #ef444433;
        }

        .badge-baru {
            background-color: #eff6ff;
            color: #1e40af;
            border-color: #3b82f633;
        }

        .badge::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
            flex-shrink: 0;
        }

        .badge-aman::before {
            background-color: #22c55e;
            animation: status-pulse-soft 2s infinite ease-in-out;
        }

        .badge-kritis::before {
            background-color: #f59e0b;
            animation: status-pulse-soft 2s infinite ease-in-out;
        }

        .badge-habis::before {
            background-color: #ef4444;
            animation: status-pulse-soft 2s infinite ease-in-out;
        }

        .badge-baru::before {
            background-color: #2563EB;
            animation: status-pulse-soft 2s infinite ease-in-out;
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

        .btn-page {
            background-color: #F8FAFC;
            border: 1.5px solid #E2E8F0;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            color: #64748B;
        }

        .btn-action {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            border: 1.5px solid #E2E8F0;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background-color: #F8FAFC;
            color: #64748B;
        }

        .btn-edit:hover {
            background-color: #FFFBEB;
            color: #D97706;
            border-color: #FDE68A;
        }

        .btn-delete:hover {
            background-color: #FEF2F2;
            color: #EF4444;
            border-color: #F87171;
        }

        .btn-delete {
            background-color: #F8FAFC;
            color: #64748B;
        }

        #btnKonfirmasiHapus {
            background-color: #EF4444 !important;
            border: 1.5px solid #9f1239 !important;
            color: #FFFFFF !important;
            padding: 12px 0;
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

        table th:nth-child(1),
        table td:nth-child(1),
        table th:nth-child(6),
        table td:nth-child(6),
        table th:nth-child(7),
        table td:nth-child(7),
        table th:nth-child(8),
        table td:nth-child(8) {
            text-align: center;
        }

        table td:nth-child(1),
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
        table td:nth-child(3),
        table th:nth-child(4),
        table td:nth-child(4),
        table th:nth-child(5),
        table td:nth-child(5),
        table th:nth-child(9),
        table td:nth-child(9),
        table th:nth-child(10),
        table td:nth-child(10),
        table th:nth-child(11),
        table td:nth-child(11),
        table th:nth-child(12),
        table td:nth-child(12),
        table th:nth-child(13),
        table td:nth-child(13) {
            text-align: left;
        }

        table td:nth-child(13) {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 5px;
            padding-left: 8px;
        }

        table th:nth-child(13) {
            text-align: left;
            padding-left: 8px;
            white-space: nowrap;
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

        .modal-content input::placeholder {
            font-style: italic;
            color: #94A3B8;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 800;
            color: #64748B;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            height: 38px;
            padding: 0 12px;
            border-radius: 4px;
            color: #0F172A;
            border: 1px solid #CBD5E1;
            font-size: 12px;
            box-sizing: border-box;
            outline: none;

        }

        .form-group input:focus,
        .form-group select:focus,
        #tambahTanggal:focus,
        #editTanggal:focus {
            border: 1px solid #1e293b;
            outline: none;
            box-shadow: none;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
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

        .btn-page.disabled {
            background-color: #F1F5F9;
            color: #94A3B8;
            cursor: default;
            border: 1.5px solid #E2E8F0;
        }

        a.btn-page {
            text-decoration: none;
            display: inline-block;
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

        @keyframes status-pulse-soft {
            0% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.3;
                transform: scale(0.8);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .badge-aman::before,
        .badge-kritis::before,
        .badge-habis::before,
        .badge-baru::before {
            animation-name: status-pulse-soft;
            animation-iteration-count: infinite;
            animation-timing-function: ease-in-out;
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
            <a href="#" class="nav-link active">
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
                <button type="button" class="sidebar-toggle-btn" id="sidebarToggle" aria-label="Buka menu">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
                <div class="header-title-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16.5 9.4 7.55 4.24"></path>
                        <path
                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                        </path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                </div>
                <h2>INVENTORI</h2>
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
        <div class="summary-grid">
            <div class="card">
                <div class="card-info">
                    <p>Total Barang</p>
                    <h3><span class="counter-value" data-target="{{ $totalBarang }}">0</span> Barang</h3>
                </div>
                <div class="card-icon icon-total">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16.5 9.4 7.55 4.24"></path>
                        <path
                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                        </path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                </div>
            </div>
            <div class="card">
                <div class="card-info">
                    <p>Barang Aman</p>
                    <h3><span class="counter-value" data-target="{{ $barangAman }}">0</span> Barang</h3>
                </div>
                <div class="card-icon icon-aman">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="3">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
            </div>
            <div class="card">
                <div class="card-info">
                    <p>Barang Kritis</p>
                    <h3><span class="counter-value" data-target="{{ $barangKritis }}">0</span> Barang</h3>
                </div>
                <div class="card-icon icon-kritis">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
                        <line x1="12" y1="9" x2="12" y2="13" stroke-width="3"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17" stroke-width="3"></line>
                    </svg>
                </div>
            </div>
            <div class="card">
                <div class="card-info">
                    <p>Barang Habis</p>
                    <h3><span class="counter-value" data-target="{{ $barangHabis }}">0</span> Barang</h3>
                </div>
                <div class="card-icon icon-habis">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="3">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </div>
            </div>
        </div>
        <div class="filter-wrapper">
            <div class="filter-group">
                <input type="text" id="filterNama" class="filter-input" placeholder="Cari Nama Barang"
                    spellcheck="false" autocomplete="off">
            </div>
            <div class="filter-group">
                <input type="text" id="filterMerek" class="filter-input" placeholder="Cari Merek Barang"
                    spellcheck="false" autocomplete="off">
            </div>
            <div class="filter-group">
                <select id="filterKategori" class="filter-select">
                    <option value="">Semua Kategori</option>
                    <option value="Material" {{ request('kategori') == 'Material' ? 'selected' : '' }}>Material
                    </option>
                    <option value="Alat Listrik" {{ request('kategori') == 'Alat Listrik' ? 'selected' : '' }}>Alat
                        Listrik</option>
                    <option value="Cat" {{ request('kategori') == 'Cat' ? 'selected' : '' }}>Cat</option>
                    <option value="Alat Tukang" {{ request('kategori') == 'Alat Tukang' ? 'selected' : '' }}>Alat
                        Tukang</option>
                </select>
            </div>
            <div class="filter-group">
                <select id="filterStatus" class="filter-select">
                    <option value="">Semua Status</option>
                    <option value="aman" {{ request('status') == 'aman' ? 'selected' : '' }}>Aman</option>
                    <option value="kritis" {{ request('status') == 'kritis' ? 'selected' : '' }}>Kritis</option>
                    <option value="habis" {{ request('status') == 'habis' ? 'selected' : '' }}>Habis</option>
                    <option value="baru" {{ request('status') == 'baru' ? 'selected' : '' }}>Baru</option>
                </select>
            </div>
            <div class="filter-group">
                <select id="filterLokasi" class="filter-select">
                    <option value="">Semua Lokasi</option>
                    <option value="Gudang A" {{ request('lokasi') == 'Gudang A' ? 'selected' : '' }}>Gudang A</option>
                    <option value="Gudang B" {{ request('lokasi') == 'Gudang B' ? 'selected' : '' }}>Gudang B</option>
                    <option value="Rak Depan" {{ request('lokasi') == 'Rak Depan' ? 'selected' : '' }}>Rak Depan
                    </option>
                    <option value="Rak Samping" {{ request('lokasi') == 'Rak Samping' ? 'selected' : '' }}>Rak Samping
                    </option>
                    <option value="Gudang Belakang" {{ request('lokasi') == 'Gudang Belakang' ? 'selected' : '' }}>
                        Gudang Belakang</option>
                </select>
            </div>
        </div>
        <div class="table-container">
            <div class="table-header-content">
                <h3>Daftar Barang</h3>
                <button class="btn-add">TAMBAH BARANG</button>
            </div>
            <div class="table-scroll-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Merek</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Stok</th>
                            <th>Min. Stok</th>
                            <th>Status</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Lokasi</th>
                            <th>Tgl Masuk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data_barang as $item)
                            <tr>
                                <td>{{ ($data_barang->currentPage() - 1) * $data_barang->perPage() + $loop->iteration }}
                                </td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->merek }}</td>
                                <td>{{ $item->kategori ?? '—' }}</td>
                                <td>{{ $item->satuan }}</td>
                                <td>{{ $item->stok_sistem }}</td>
                                <td>{{ $item->min_stok }}</td>
                                <td>
                                    @if ($item->satuan == '-')
                                        <span class="badge badge-baru">Baru</span>
                                    @elseif ($item->stok_sistem == 0)
                                        <span class="badge badge-habis">Habis</span>
                                    @elseif($item->stok_sistem <= $item->min_stok)
                                        <span class="badge badge-kritis">Kritis</span>
                                    @else
                                        <span class="badge badge-aman">Aman</span>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                                <td>{{ $item->lokasi }}</td>
                                <td>{{ $item->tanggal_masuk ? date('d/m/Y', strtotime($item->tanggal_masuk)) : '—' }}
                                </td>
                                <td>
                                    <button class="btn-action btn-edit" data-id="{{ $item->id_barang }}"
                                        data-nama="{{ $item->nama_barang }}" data-merek="{{ $item->merek }}"
                                        data-kategori="{{ $item->kategori }}"
                                        data-tanggal="{{ $item->tanggal_masuk }}" data-satuan="{{ $item->satuan }}"
                                        data-stok="{{ $item->stok_sistem }}" data-minstok="{{ $item->min_stok }}"
                                        data-hargabeli="{{ $item->harga_beli }}"
                                        data-hargajual="{{ $item->harga_jual }}" data-lokasi="{{ $item->lokasi }}">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg>
                                    </button>
                                    <button class="btn-action btn-delete" data-id="{{ $item->id_barang }}">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path
                                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                            </path>
                                            <line x1="10" y1="11" x2="10" y2="17">
                                            </line>
                                            <line x1="14" y1="11" x2="14" y2="17">
                                            </line>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13"
                                    style="text-align: center; padding: 50px; color: #94a3b8; font-style: italic; font-size: 12px">
                                    @if (request('nama') || request('merek') || request('kategori') || request('status') || request('lokasis'))
                                        Data barang tidak ditemukan.
                                    @else
                                        Data inventori masih kosong.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrapper">
                <div class="pagination-btns">
                    @if ($data_barang->onFirstPage())
                        <button class="btn-page disabled" disabled>Sebelumnya</button>
                    @else
                        <a href="{{ $data_barang->appends(['per_page' => $perPage])->previousPageUrl() }}"
                            class="btn-page">Sebelumnya</a>
                    @endif
                    @if ($data_barang->hasMorePages())
                        <a href="{{ $data_barang->appends(['per_page' => $perPage])->nextPageUrl() }}"
                            class="btn-page">Berikutnya</a>
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
        <div class="modal-overlay" id="modalTambah">
            <div class="modal-content">
                <div
                    style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px; border-bottom: 1px solid #F1F5F9; padding-bottom: 10px;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#0F172A"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="12" y1="18" x2="12" y2="12"></line>
                        <line x1="9" y1="15" x2="15" y2="15"></line>
                    </svg>
                    <h3
                        style="margin: 0; font-size: 16px; color: #0F172A; font-weight: 800; text-transform: uppercase;">
                        TAMBAH BARANG
                    </h3>
                </div>
                <form action="{{ route('barang.simpan') }}" method="POST" id="formTambahBarang" autocomplete="off"
                    novalidate>
                    @csrf
                    <input type="hidden" name="current_url" value="{{ request()->fullUrl() }}">
                    <div class="form-grid">
                        <div class="form-left">
                            <div class="form-group" style="margin-bottom: 12px;">
                                <label>Nama Barang</label>
                                <input type="text" name="nama_barang" spellcheck="false"
                                    placeholder="Cth: Cat Putih 25kg" pattern="[A-Za-z0-9\s]+" required>
                            </div>
                            <div class="form-group" style="margin-bottom: 12px;">
                                <label>Merek</label>
                                <input type="text" name="merek" spellcheck="false" placeholder="Cth: Asoka"
                                    pattern="[A-Za-z0-9\s]+" required>
                            </div>
                            <div class="form-group" style="margin-bottom: 12px;">
                                <label>Kategori</label>
                                <select name="kategori" class="form-control-select placeholder-style" required
                                    onchange="this.classList.remove('placeholder-style')">
                                    <option value="" disabled selected hidden>Pilih Kategori</option>
                                    <option value="Material">Material</option>
                                    <option value="Alat Listrik">Alat Listrik</option>
                                    <option value="Cat">Cat</option>
                                    <option value="Alat Tukang">Alat Tukang</option>
                                </select>
                            </div>
                            <div class="form-group" style="margin-bottom: 12px;">
                                <label>Satuan</label>
                                <select name="satuan" class="form-control-select placeholder-style"
                                    id="satuanSelect" required onchange="this.classList.remove('placeholder-style')">
                                    <option value="" disabled selected hidden>Pilih Satuan</option>
                                    <option value="Pcs">Pcs</option>
                                    <option value="Unit">Unit</option>
                                    <option value="Set">Set</option>
                                    <option value="Buah">Buah</option>
                                    <option value="Batang">Batang</option>
                                    <option value="Lembar">Lembar</option>
                                    <option value="Zak">Zak</option>
                                    <option value="Pail">Pail</option>
                                    <option value="Galon">Galon</option>
                                    <option value="Kotak">Kotak</option>
                                    <option value="Pasang">Pasang</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Lokasi</label>
                                <select name="lokasi" class="form-control-select placeholder-style"
                                    id="lokasiSelect" required onchange="this.classList.remove('placeholder-style')">
                                    <option value="" disabled selected hidden>Pilih Lokasi</option>
                                    <option value="Gudang A">Gudang A</option>
                                    <option value="Gudang B">Gudang B</option>
                                    <option value="Rak Depan">Rak Depan</option>
                                    <option value="Rak Samping">Rak Samping</option>
                                    <option value="Gudang Belakang">Gudang Belakang</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-right">
                            <div class="form-group" style="margin-bottom: 12px;">
                                <label>Stok</label>
                                <input type="text" inputmode="numeric" name="stok_sistem" id="tambahStok"
                                    spellcheck="false" placeholder="Cth: 15" required>
                            </div>
                            <div class="form-group" style="margin-bottom: 12px;">
                                <label>Min. Stok</label>
                                <input type="text" inputmode="numeric" name="min_stok" id="tambahMinStok"
                                    spellcheck="false" placeholder="Cth: 3" required>
                            </div>
                            <div class="form-group" style="margin-bottom: 12px;">
                                <label>Harga Beli (Rp)</label>
                                <input type="text" inputmode="numeric" id="harga_beli_mask" class="price-input"
                                    spellcheck="false" placeholder="Cth: 45.000" required>
                                <input type="hidden" name="harga_beli" id="harga_beli">
                            </div>
                            <div class="form-group" style="margin-bottom: 12px;">
                                <label>Harga Jual (Rp)</label>
                                <input type="text" inputmode="numeric" id="harga_jual_mask" class="price-input"
                                    spellcheck="false" placeholder="Cth: 55.000" required>
                                <input type="hidden" name="harga_jual" id="harga_jual">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Masuk</label>
                                <input type="date" name="tanggal_masuk" id="tambahTanggal" readonly
                                    style="background-color: #ffffff; cursor: default; border: 1px solid #CBD5E1; color: #0F172A;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" id="btnBatal">BATAL</button>
                        <button type="submit" class="btn-save">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-overlay" id="modalEdit">
            <div class="modal-content">
                <div
                    style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px; border-bottom: 1px solid #F1F5F9; padding-bottom: 10px;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#0F172A"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    <h3
                        style="margin: 0; font-size: 16px; color: #0F172A; font-weight: 800; text-transform: uppercase;">
                        EDIT BARANG</h3>
                </div>
                <form action="" method="POST" id="formEditBarang" autocomplete="off" novalidate>
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="current_url" value="{{ request()->fullUrl() }}">
                    <div class="form-grid">
                        <div class="form-left">
                            <div class="form-group" style="margin-bottom: 12px;">
                                <label>Nama Barang</label>
                                <input type="text" name="nama_barang" id="editNama" style="color: #0F172A;"
                                    placeholder="Cth: Cat Putih 25kg" spellcheck="false" pattern="[A-Za-z0-9\s]+"
                                    required>
                            </div>
                            <div class="form-group" style="margin-bottom: 12px;">
                                <label>Merek</label>
                                <input type="text" name="merek" id="editMerek" style="color: #0F172A;"
                                    placeholder="Cth: Asoka" spellcheck="false" pattern="[A-Za-z0-9\s]+" required>
                            </div>
                            <div class="form-group" style="margin-bottom: 12px;">
                                <label>Kategori</label>
                                <select name="kategori" id="editKategori" class="form-control-select" required>
                                    <option value="" disabled selected hidden>Pilih Kategori</option>
                                    <option value="Material">Material</option>
                                    <option value="Alat Listrik">Alat Listrik</option>
                                    <option value="Cat">Cat</option>
                                    <option value="Alat Tukang">Alat Tukang</option>
                                </select>
                            </div>
                            <div class="form-group" style="margin-bottom: 12px;">
                                <label>Satuan</label>
                                <select name="satuan" id="editSatuan" class="form-control-select" required>
                                    <option value="" disabled selected hidden>Pilih Satuan</option>
                                    <option value="Pcs">Pcs</option>
                                    <option value="Unit">Unit</option>
                                    <option value="Set">Set</option>
                                    <option value="Buah">Buah</option>
                                    <option value="Batang">Batang</option>
                                    <option value="Lembar">Lembar</option>
                                    <option value="Zak">Zak</option>
                                    <option value="Pail">Pail</option>
                                    <option value="Galon">Galon</option>
                                    <option value="Kotak">Kotak</option>
                                    <option value="Pasang">Pasang</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Lokasi</label>
                                <select name="lokasi" id="editLokasi" class="form-control-select" required>
                                    <option value="" disabled selected hidden>Pilih Lokasi</option>
                                    <option value="Gudang A">Gudang A</option>
                                    <option value="Gudang B">Gudang B</option>
                                    <option value="Rak Depan">Rak Depan</option>
                                    <option value="Rak Samping">Rak Samping</option>
                                    <option value="Gudang Belakang">Gudang Belakang</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-right">
                            <div class="form-group" style="margin-bottom: 12px;">
                                <label>Stok</label>
                                <input type="text" inputmode="numeric" name="stok_sistem" id="editStok"
                                    style="color: #0F172A;" placeholder="Cth: 15" spellcheck="false" required>
                            </div>
                            <div class="form-group" style="margin-bottom: 12px;">
                                <label>Min. Stok</label>
                                <input type="text" inputmode="numeric" name="min_stok" id="editMinStok"
                                    style="color: #0F172A;" placeholder="Cth: 3" spellcheck="false" required>
                            </div>
                            <div class="form-group" style="margin-bottom: 12px;">
                                <label>Harga Beli (Rp)</label>
                                <input type="text" inputmode="numeric" id="editHargaBeliMask"
                                    style="color: #0F172A;" placeholder="Cth: 45.000" spellcheck="false" required>
                                <input type="hidden" name="harga_beli" id="editHargaBeli">
                            </div>
                            <div class="form-group" style="margin-bottom: 12px;">
                                <label>Harga Jual (Rp)</label>
                                <input type="text" inputmode="numeric" id="editHargaJualMask"
                                    style="color: #0F172A;" placeholder="Cth: 55.000" spellcheck="false" required>
                                <input type="hidden" name="harga_jual" id="editHargaJual">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Masuk</label>
                                <input type="date" id="editTanggal" readonly
                                    style="background-color: #ffffff; cursor: default; border: 1px solid #CBD5E1; color: #0F172A;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" id="btnBatalEdit">BATAL</button>
                        <button type="submit" class="btn-save">SIMPAN</button>
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
            const toggle = document.getElementById('sidebarToggle');
            const overlay = document.getElementById('sidebarOverlay');
            const navLinks = sidebar ? sidebar.querySelectorAll('.nav-link') : [];

            function openSidebar() {
                if (!sidebar) return;
                sidebar.classList.add('open');
                if (overlay) overlay.classList.add('active');
                document.body.classList.add('sidebar-open');
            }

            function closeSidebar() {
                if (!sidebar) return;
                sidebar.classList.remove('open');
                if (overlay) overlay.classList.remove('active');
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

        const modal = document.getElementById('modalTambah');
        const modalEdit = document.getElementById('modalEdit');
        const formEdit = document.getElementById('formEditBarang');
        const modalHapus = document.getElementById('modalHapus');
        const formHapus = document.getElementById('formHapusBarang');
        const btnTidakHapus = document.getElementById('btnTidakHapus');
        const btnTambah = document.querySelector('.btn-add');
        const btnBatal = document.getElementById('btnBatal');
        const loadingOverlay = document.getElementById('loading-overlay');
        let formTambah;

        function lockBodyScroll() {
            if (document.body.classList.contains('modal-open')) return;
            const scrollY = window.scrollY || window.pageYOffset || 0;
            document.body.dataset.scrollY = String(scrollY);
            document.body.style.top = `-${scrollY}px`;
            document.body.classList.add('modal-open');
        }

        function unlockBodyScroll() {
            if (!document.body.classList.contains('modal-open')) return;
            const scrollY = parseInt(document.body.dataset.scrollY || '0', 10) || 0;
            document.body.classList.remove('modal-open');
            document.body.style.top = '';
            delete document.body.dataset.scrollY;
            window.scrollTo(0, scrollY);
        }

        function resetDanTutupModalEdit() {
            clearValidationStyles(formEdit);
            if (formEdit) {
                formEdit.reset();
                document.getElementById('editSatuan').style.color = "#94A3B8";
                document.getElementById('editLokasi').style.color = "#94A3B8";
                const inputUrl = formEdit.querySelector('input[name="current_url"]');
                if (inputUrl) {
                    inputUrl.value = "";
                }
            }
            if (modalEdit) {
                modalEdit.style.display = 'none';
            }
            unlockBodyScroll();
        }

        function formatRupiah(angka, prefix) {
            let number_string = angka.replace(/[^0-9]/g, '').toString();
            if (number_string.startsWith('0')) {
                number_string = number_string.replace(/^0+/, '');
            }
            if (!number_string) return '';
            let sisa = number_string.length % 3;
            let rupiah = number_string.substr(0, sisa);
            let ribuan = number_string.substr(sisa).match(/\d{3}/gi);
            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
        }

        document.addEventListener('DOMContentLoaded', function() {
            formTambah = modal ? modal.querySelector('form') : null;
            const btnBatalTambah = document.getElementById('btnBatal');
            const btnBatalEditElemen = document.getElementById('btnBatalEdit');
            const fNama = document.getElementById('filterNama');
            const fMerek = document.getElementById('filterMerek');
            const fKategori = document.getElementById('filterKategori');
            const fStatus = document.getElementById('filterStatus');
            const fLokasi = document.getElementById('filterLokasi');

            const priceInputs = [{
                    displayId: 'harga_beli_mask',
                    hiddenId: 'harga_beli'
                },
                {
                    displayId: 'harga_jual_mask',
                    hiddenId: 'harga_jual'
                },
                {
                    displayId: 'editHargaBeliMask',
                    hiddenId: 'editHargaBeli'
                },
                {
                    displayId: 'editHargaJualMask',
                    hiddenId: 'editHargaJual'
                }
            ];

            priceInputs.forEach(item => {
                const displayInput = document.getElementById(item.displayId);
                const hiddenInput = document.getElementById(item.hiddenId);
                if (displayInput) {
                    displayInput.addEventListener('input', function() {
                        let cursorPosition = this.selectionStart;
                        let originalLength = this.value.length;
                        let murni = this.value.replace(/[^0-9]/g, '');
                        this.value = formatRupiah(murni, 'Rp ');
                        if (hiddenInput) {
                            hiddenInput.value = murni.startsWith('0') ? murni.replace(/^0+/, '') :
                                murni;
                        }
                        let newLength = this.value.length;
                        let newCursorPos = cursorPosition + (newLength - originalLength);
                        if (newCursorPos < 3) newCursorPos = 3;
                        this.setSelectionRange(newCursorPos, newCursorPos);
                    });
                }
            });

            const stokFields = ['editStok', 'editMinStok', 'tambahStok', 'tambahMinStok'];
            stokFields.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.addEventListener('input', function() {
                        let val = this.value.replace(/[^0-9]/g, '');
                        if (val.startsWith('0')) {
                            val = val.replace(/^0+/, '');
                            if (val === '') {
                                val = '0';
                            }
                        }
                        this.value = val;
                    });
                }
            });

            if (btnTambah) {
                btnTambah.addEventListener('click', () => {
                    const today = new Date().toISOString().split('T')[0];
                    const dateInput = document.getElementById('tambahTanggal');
                    if (dateInput) {
                        dateInput.value = today;
                        dateInput.dispatchEvent(new Event('input'));
                        dateInput.dispatchEvent(new Event('change'));
                    }
                    modal.style.display = 'flex';
                    lockBodyScroll();
                });
            }

            if (btnBatalTambah) {
                btnBatalTambah.addEventListener('click', () => {
                    if (formTambah) formTambah.reset();
                    clearValidationStyles(formTambah);
                    modal.style.display = 'none';
                    unlockBodyScroll();
                });
            }

            if (btnBatalEditElemen) {
                btnBatalEditElemen.addEventListener('click', resetDanTutupModalEdit);
            }

            if (formTambah) {
                formTambah.onsubmit = function(e) {
                    const inputs = this.querySelectorAll('[required]');
                    let isValid = true;
                    let firstInvalidInput = null;
                    inputs.forEach(input => {
                        if (!input.value.trim()) {
                            isValid = false;
                            input.style.borderColor = '#ef4444';
                            if (!firstInvalidInput) firstInvalidInput = input;
                        } else {
                            input.style.borderColor = '#CBD5E1';
                        }
                    });
                    if (!isValid) {
                        e.preventDefault();
                        if (firstInvalidInput) firstInvalidInput.focus();
                        return false;
                    }
                };
            }

            document.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', function() {
                    clearValidationStyles(formEdit);
                    const idBarang = this.dataset.id;
                    formEdit.action = `/inventori/update/${idBarang}`;
                    const inputUrl = formEdit.querySelector('input[name="current_url"]');
                    if (inputUrl) {
                        inputUrl.value = window.location.href;
                    }
                    document.getElementById('editNama').value = this.dataset.nama;
                    document.getElementById('editMerek').value = this.dataset.merek;
                    document.getElementById('editStok').value = this.dataset.stok;
                    document.getElementById('editMinStok').value = this.dataset.minstok;

                    const elKategori = document.getElementById('editKategori');
                    if (elKategori) {
                        if (this.dataset.kategori === '-' || !this.dataset.kategori) {
                            elKategori.value = "";
                            elKategori.style.color = "#94A3B8";
                            elKategori.classList.add('placeholder-style');
                        } else {
                            elKategori.value = this.dataset.kategori;
                            elKategori.style.color = "#0F172A";
                            elKategori.classList.remove('placeholder-style');
                        }
                    }

                    const elSatuan = document.getElementById('editSatuan');
                    if (this.dataset.satuan === '-' || !this.dataset.satuan) {
                        elSatuan.value = "";
                        elSatuan.style.color = "#94A3B8";
                        elSatuan.classList.add('placeholder-style');
                    } else {
                        elSatuan.value = this.dataset.satuan;
                        elSatuan.style.color = "#0F172A";
                        elSatuan.classList.remove('placeholder-style');
                    }

                    const elLokasi = document.getElementById('editLokasi');
                    if (this.dataset.lokasi === '-' || !this.dataset.lokasi) {
                        elLokasi.value = "";
                        elLokasi.style.color = "#94A3B8";
                        elLokasi.classList.add('placeholder-style');
                    } else {
                        elLokasi.value = this.dataset.lokasi;
                        elLokasi.style.color = "#0F172A";
                        elLokasi.classList.remove('placeholder-style');
                    }

                    const elTanggal = document.getElementById('editTanggal');
                    if (elTanggal) {
                        elTanggal.value = this.dataset.tanggal || "";
                    }

                    document.getElementById('editHargaBeliMask').value = formatRupiah(this.dataset
                        .hargabeli, 'Rp ');
                    document.getElementById('editHargaBeli').value = this.dataset.hargabeli;
                    document.getElementById('editHargaJualMask').value = formatRupiah(this.dataset
                        .hargajual, 'Rp ');
                    document.getElementById('editHargaJual').value = this.dataset.hargajual;

                    modalEdit.style.display = 'flex';
                    lockBodyScroll();
                });
            });

            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function() {
                    const idBarang = this.dataset.id;
                    if (idBarang) {
                        formHapus.action = `/inventori/hapus/${idBarang}`;
                        modalHapus.style.display = 'flex';
                        lockBodyScroll();
                    }
                });
            });

            const tombolIya = document.getElementById('btnKonfirmasiHapus');
            if (tombolIya) {
                tombolIya.onclick = function(e) {
                    e.preventDefault();
                    if (formHapus) formHapus.submit();
                };
            }

            if (btnTidakHapus) {
                btnTidakHapus.addEventListener('click', () => {
                    modalHapus.style.display = 'none';
                    unlockBodyScroll();
                });
            }

            if (formEdit) {
                formEdit.onsubmit = function(e) {
                    const inputs = this.querySelectorAll('[required]');
                    let isValid = true;
                    let firstInvalidInput = null;
                    inputs.forEach(input => {
                        if (!input.value.trim()) {
                            isValid = false;
                            input.style.borderColor = '#ef4444';
                            if (!firstInvalidInput) firstInvalidInput = input;
                        } else {
                            input.style.borderColor = '#CBD5E1';
                        }
                    });
                    if (!isValid) {
                        e.preventDefault();
                        if (firstInvalidInput) firstInvalidInput.focus();
                        return false;
                    }
                };
            }

            const selectPerPage = document.getElementById('perPageSelect');
            if (selectPerPage) {
                selectPerPage.addEventListener('change', function() {
                    const currentUrl = new URL(window.location.href);
                    currentUrl.searchParams.set('per_page', this.value);
                    currentUrl.searchParams.set('page', 1);
                    window.location.href = currentUrl.toString();
                });
            }

            const allForms = document.querySelectorAll('#modalTambah form, #modalEdit form');
            allForms.forEach(form => {
                const allInputs = form.querySelectorAll('input, select, textarea');
                allInputs.forEach(input => {
                    ['input', 'change'].forEach(evt => {
                        input.addEventListener(evt, function() {
                            this.style.borderColor = '';
                            this.classList.remove('border-danger');
                        });
                    });
                });
            });

            if (fNama) {
                fNama.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') jalankanFilter();
                });
            }
            if (fMerek) {
                fMerek.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') jalankanFilter();
                });
            }
            if (fKategori) fKategori.addEventListener('change', jalankanFilter);
            if (fStatus) fStatus.addEventListener('change', jalankanFilter);
            if (fLokasi) fLokasi.addEventListener('change', jalankanFilter);

            document.querySelectorAll('#editKategori, #editSatuan, #editLokasi').forEach(select => {
                select.addEventListener('change', function() {
                    if (this.value !== "") {
                        this.style.color = "#0F172A";
                        this.classList.remove('placeholder-style');
                    } else {
                        this.style.color = "#94A3B8";
                        this.classList.add('placeholder-style');
                    }
                });
            });

            @if (session('success'))
                showSuccessToast("{{ session('success') }}");
            @endif

            const counters = document.querySelectorAll('.counter-value');
            counters.forEach(counter => {
                const animate = () => {
                    const target = +counter.getAttribute('data-target');
                    const count = +counter.innerText;
                    const speed = target / 40;
                    if (count < target) {
                        counter.innerText = Math.ceil(count + speed);
                        setTimeout(animate, 25);
                    } else {
                        counter.innerText = target;
                    }
                };
                animate();
            });

            const dots = document.querySelectorAll('.badge::before');
            dots.forEach(dot => {
                const randomDelay = (Math.random() * 3).toFixed(2);
                const randomDuration = (1.5 + Math.random() * 1.5).toFixed(2);
                dot.style.animationDelay = `${randomDelay}s`;
                dot.style.animationDuration = `${randomDuration}s`;
            });
        });

        window.addEventListener('click', (e) => {
            if (e.target == modal) {
                const formTambahElemen = modal.querySelector('form');
                if (formTambahElemen) {
                    formTambahElemen.reset();
                    clearValidationStyles(formTambahElemen);
                }
                modal.style.display = 'none';
                unlockBodyScroll();
            }
            if (e.target == modalEdit) {
                resetDanTutupModalEdit();
            }
            if (e.target == modalHapus) {
                modalHapus.style.display = 'none';
                unlockBodyScroll();
            }
        });

        function triggerLoading(targetUrl) {
            if (!targetUrl || targetUrl === '#') return;
            loadingOverlay.style.display = 'flex';
            loadingOverlay.style.opacity = '1';
            window.location.href = targetUrl;
        }

        document.getElementById('logout-btn').addEventListener('click', function(e) {
            e.preventDefault();
            const logoutUrl = this.getAttribute('href');
            triggerLoading(logoutUrl);
        });

        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href && href !== '#' && !this.classList.contains('active')) {
                    e.preventDefault();
                    triggerLoading(href);
                }
            });
        });

        function clearValidationStyles(form) {
            if (form) {
                form.querySelectorAll('input').forEach(input => {
                    input.style.borderColor = '';
                });
                form.querySelectorAll('select').forEach(select => {
                    select.style.borderColor = '';
                    if (!select.value || select.value === "") {
                        select.classList.add('placeholder-style');
                    } else {
                        select.classList.remove('placeholder-style');
                    }
                });
            }
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

        function jalankanFilter() {
            const fNama = document.getElementById('filterNama');
            const fMerek = document.getElementById('filterMerek');
            const fKategori = document.getElementById('filterKategori');
            const fStatus = document.getElementById('filterStatus');
            const fLokasi = document.getElementById('filterLokasi');
            const perPageSelect = document.getElementById('perPageSelect');
            const url = new URL(window.location.origin + window.location.pathname);
            const valNama = fNama ? fNama.value.trim() : "";
            const valMerek = fMerek ? fMerek.value.trim() : "";
            if (valNama) url.searchParams.set('nama', valNama);
            if (valMerek) url.searchParams.set('merek', valMerek);
            if (fKategori && fKategori.value) url.searchParams.set('kategori', fKategori.value);
            if (fStatus && fStatus.value) url.searchParams.set('status', fStatus.value);
            if (fLokasi && fLokasi.value) url.searchParams.set('lokasi', fLokasi.value);
            if (perPageSelect) url.searchParams.set('per_page', perPageSelect.value);
            url.searchParams.set('page', 1);
            if (fNama) {
                fNama.value = "";
                fNama.blur();
            }
            if (fMerek) {
                fMerek.value = "";
                fMerek.blur();
            }
            window.location.href = url.href;
        }
    </script>
</body>

</html>
