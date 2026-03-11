<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="UMKM Cireng Rujak Kota Serang - Pre-order Cireng Rujak Lezat untuk wilayah Kota Serang dan sekitarnya">
        <meta name="theme-color" content="#FF6B35">

        <!-- CSP: Allow inline scripts and Alpine.js -->
        <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-eval' 'unsafe-inline'; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https:; connect-src 'self' https://fonts.googleapis.com https://fonts.gstatic.com;">

        <title>@yield('title', 'Cireng Rujak Kota Serang - UMKM Penjualan Online') | UMKM Cireng Rujak</title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='50' r='45' fill='%23FF6B35'/%3E%3Ctext x='50' y='65' font-size='40' text-anchor='middle' fill='white'%3E%F0%9F%8D%93%3C/text%3E%3C/svg%3E">

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Vite Assets -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <!-- Navigation -->
        @include('components.navbar')

        <!-- Main Content -->
        <main>
            {{ $slot }}
        </main>

        <!-- Footer -->
        @include('components.footer')

        <!-- WhatsApp Float Button -->
        <a href="https://wa.me/6285183062643" target="_blank" class="whatsapp-float" title="Chat dengan kami di WhatsApp">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
        </a>

        <!-- Initialize Components -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (window.CirengApp) {
                    window.CirengApp.initFileUpload?.();
                    window.CirengApp.initPaymentTabs?.();
                    window.CirengApp.initPaymentCountdown?.();
                    window.CirengApp.initOrderQuantityControls?.();
                    window.CirengApp.initOrderFormValidation?.();
                    window.CirengApp.initDashboardTabs?.();
                    window.CirengApp.initAdminSalesChart?.();
                }
            });
        </script>

        @stack('scripts')
    </body>
</html>
