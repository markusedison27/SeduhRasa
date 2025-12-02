{{-- resources/views/order.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembeli • SeduhRasa</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Reset and Override Tailwind */
        * {
            margin: 0 !important;
            padding: 0 !important;
            box-sizing: border-box !important;
        }

        body {
            font-family: 'Poppins', 'Segoe UI', sans-serif !important;
            background: #2c1810 !important;
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(101, 67, 33, 0.4) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(62, 39, 35, 0.4) 0%, transparent 50%),
                linear-gradient(135deg, #1a0f0a 0%, #2c1810 25%, #3d2317 50%, #2c1810 75%, #1a0f0a 100%) !important;
            min-height: 100vh !important;
            position: relative !important;
            overflow-x: hidden !important;
        }

        /* Animated coffee beans background */
        body::before {
            content: '' !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background-image: 
                radial-gradient(ellipse at 10% 20%, rgba(139, 90, 43, 0.15) 0%, transparent 30%),
                radial-gradient(ellipse at 90% 80%, rgba(101, 67, 33, 0.15) 0%, transparent 30%),
                radial-gradient(circle at 50% 50%, rgba(120, 80, 50, 0.08) 0%, transparent 50%) !important;
            pointer-events: none !important;
            z-index: 0 !important;
            animation: breathe 8s ease-in-out infinite !important;
        }

        @keyframes breathe {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        /* Header */
        header {
            background: linear-gradient(135deg, rgba(26, 15, 10, 0.98) 0%, rgba(44, 24, 16, 0.98) 100%) !important;
            backdrop-filter: blur(15px) !important;
            box-shadow: 
                0 4px 30px rgba(0, 0, 0, 0.5),
                0 2px 10px rgba(139, 90, 43, 0.2),
                inset 0 -1px 0 rgba(139, 90, 43, 0.3) !important;
            border-bottom: 1px solid rgba(139, 90, 43, 0.2) !important;
            position: relative !important;
            z-index: 1000 !important;
            padding: 1rem 0 !important;
        }

        .header-container {
            max-width: 1200px !important;
            margin: 0 auto !important;
            padding: 0 2rem !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
        }

        .logo-link {
            display: flex !important;
            align-items: center !important;
            gap: 0.75rem !important;
            text-decoration: none !important;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .logo-img {
            height: 2.5rem !important;
            width: auto !important;
            filter: drop-shadow(0 0 12px rgba(212, 163, 115, 0.6)) !important;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .logo-link:hover .logo-img {
            filter: drop-shadow(0 0 18px rgba(212, 163, 115, 0.8)) !important;
            transform: scale(1.08) rotate(5deg) !important;
        }

        .brand-text {
            font-weight: 800 !important;
            font-size: 1.5rem !important;
            letter-spacing: -0.5px !important;
        }

        .brand-seduh {
            color: #f5f5f5 !important;
            text-shadow: 0 2px 10px rgba(255, 255, 255, 0.3) !important;
        }

        .brand-rasa {
            background: linear-gradient(135deg, #d4a373 0%, #b8956a 50%, #9d7f5c 100%) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
        }

        .back-btn {
            color: #d4a373 !important;
            text-decoration: none !important;
            padding: 0.65rem 1.5rem !important;
            border: 2px solid rgba(212, 163, 115, 0.5) !important;
            border-radius: 30px !important;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
            font-weight: 600 !important;
            font-size: 0.9rem !important;
            letter-spacing: 0.3px !important;
            position: relative !important;
            overflow: hidden !important;
            display: inline-block !important;
        }

        .back-btn::before {
            content: '' !important;
            position: absolute !important;
            top: 50% !important;
            left: 50% !important;
            width: 0 !important;
            height: 0 !important;
            border-radius: 50% !important;
            background: rgba(212, 163, 115, 0.2) !important;
            transform: translate(-50%, -50%) !important;
            transition: width 0.5s ease, height 0.5s ease !important;
        }

        .back-btn:hover::before {
            width: 300px !important;
            height: 300px !important;
        }

        .back-btn:hover {
            border-color: #d4a373 !important;
            color: #fff !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 5px 20px rgba(212, 163, 115, 0.4) !important;
        }

        /* Main Container */
        main {
            max-width: 1200px !important;
            margin: 3rem auto !important;
            padding: 0 2rem !important;
            position: relative !important;
            z-index: 10 !important;
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Card Container */
        .card-wrapper {
            background: linear-gradient(135deg, 
                rgba(255, 251, 245, 0.98) 0%, 
                rgba(252, 243, 232, 0.98) 25%,
                rgba(255, 248, 240, 0.98) 50%,
                rgba(252, 243, 232, 0.98) 75%,
                rgba(255, 251, 245, 0.98) 100%
            ) !important;
            backdrop-filter: blur(20px) !important;
            border-radius: 32px !important;
            padding: 3.5rem 3rem !important;
            box-shadow: 
                0 30px 70px rgba(0, 0, 0, 0.5),
                0 15px 40px rgba(44, 24, 16, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.6),
                inset 0 -1px 0 rgba(139, 90, 43, 0.1) !important;
            border: 2px solid rgba(212, 163, 115, 0.3) !important;
            position: relative !important;
            overflow: hidden !important;
        }

        /* Decorative elements */
        .card-wrapper::before {
            content: '☕' !important;
            position: absolute !important;
            top: -60px !important;
            right: -60px !important;
            font-size: 280px !important;
            opacity: 0.04 !important;
            transform: rotate(-20deg) !important;
            animation: float 8s ease-in-out infinite !important;
            pointer-events: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .card-wrapper::after {
            content: '' !important;
            position: absolute !important;
            bottom: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 8px !important;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(212, 163, 115, 0.4) 30%,
                rgba(139, 90, 43, 0.4) 50%,
                rgba(212, 163, 115, 0.4) 70%,
                transparent 100%
            ) !important;
            animation: shimmer 3s linear infinite !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        @keyframes float {
            0%, 100% { transform: rotate(-20deg) translateY(0px); }
            50% { transform: rotate(-15deg) translateY(-25px); }
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        /* Title Section */
        .title-section {
            text-align: center !important;
            margin-bottom: 3rem !important;
            position: relative !important;
        }

        .main-title {
            font-size: 3rem !important;
            font-weight: 800 !important;
            background: linear-gradient(135deg, #3d2317 0%, #5c3a1f 30%, #6d4c2d 60%, #4a2f1a 100%) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
            margin-bottom: 1rem !important;
            letter-spacing: -1px !important;
            position: relative !important;
            display: inline-block !important;
        }

        .main-title::after {
            content: '' !important;
            position: absolute !important;
            bottom: -10px !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            width: 80px !important;
            height: 4px !important;
            background: linear-gradient(90deg, transparent, #b8956a, transparent) !important;
            border-radius: 2px !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .subtitle {
            color: #5c3a1f !important;
            font-size: 1.15rem !important;
            line-height: 1.7 !important;
            max-width: 600px !important;
            margin: 0 auto !important;
            font-weight: 500 !important;
        }

        /* Form Card */
        .form-container {
            background: linear-gradient(135deg, #ffffff 0%, #fefefe 50%, #fcfcfc 100%) !important;
            border-radius: 24px !important;
            padding: 2.5rem !important;
            box-shadow: 
                0 15px 50px rgba(44, 24, 16, 0.15),
                0 8px 25px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.9) !important;
            border: 1px solid rgba(212, 163, 115, 0.15) !important;
            position: relative !important;
        }

        .form-container::before {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            height: 3px !important;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(212, 163, 115, 0.5) 50%, 
                transparent 100%
            ) !important;
            border-radius: 24px 24px 0 0 !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Form */
        .form-wrapper {
            margin: 0 !important;
            padding: 0 !important;
        }

        .form-grid {
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 2rem !important;
            margin-bottom: 2rem !important;
        }

        /* Form Fields */
        .form-group {
            margin: 0 !important;
            padding: 0 !important;
        }

        .form-label {
            display: block !important;
            font-weight: 700 !important;
            color: #3d2317 !important;
            margin-bottom: 0.6rem !important;
            font-size: 0.85rem !important;
            letter-spacing: 0.3px !important;
            text-transform: uppercase !important;
        }

        .form-input {
            width: 100% !important;
            padding: 1rem 1.25rem !important;
            border: 2.5px solid #e5d4c1 !important;
            border-radius: 16px !important;
            font-size: 1rem !important;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
            background: linear-gradient(135deg, #fafafa 0%, #ffffff 100%) !important;
            color: #3d2317 !important;
            font-weight: 500 !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03) !important;
            font-family: 'Poppins', sans-serif !important;
            margin: 0 !important;
        }

        .form-input::placeholder {
            color: #b8956a !important;
            font-weight: 400 !important;
        }

        .form-input:hover {
            border-color: #d4a373 !important;
            box-shadow: 0 4px 15px rgba(212, 163, 115, 0.15) !important;
        }

        .form-input:focus {
            outline: none !important;
            border-color: #8b5a2b !important;
            background: #ffffff !important;
            box-shadow: 
                0 0 0 5px rgba(139, 90, 43, 0.12),
                0 8px 25px rgba(139, 90, 43, 0.2) !important;
            transform: translateY(-2px) !important;
        }

        .form-hint {
            display: block !important;
            font-size: 0.8rem !important;
            color: #6d4c2d !important;
            margin-top: 0.5rem !important;
            font-weight: 500 !important;
            line-height: 1.4 !important;
        }

        /* Submit Button Container */
        .btn-container {
            text-align: center !important;
            padding-top: 1rem !important;
            margin: 0 !important;
        }

        /* Submit Button */
        .btn-submit {
            background: linear-gradient(135deg, #8b5a2b 0%, #654321 50%, #4a2f1a 100%) !important;
            color: #ffffff !important;
            padding: 1.1rem 3.5rem !important;
            border: 2px solid rgba(212, 163, 115, 0.3) !important;
            border-radius: 50px !important;
            font-size: 1.05rem !important;
            font-weight: 800 !important;
            letter-spacing: 1.5px !important;
            text-transform: uppercase !important;
            cursor: pointer !important;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
            box-shadow: 
                0 10px 30px rgba(74, 47, 26, 0.4),
                0 5px 15px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.15),
                inset 0 -1px 0 rgba(0, 0, 0, 0.2) !important;
            position: relative !important;
            overflow: hidden !important;
            display: inline-block !important;
            margin: 0 !important;
        }

        .btn-submit::before {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            left: -100% !important;
            width: 100% !important;
            height: 100% !important;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(255, 255, 255, 0.25) 50%, 
                transparent 100%
            ) !important;
            transition: left 0.6s ease !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .btn-submit:hover::before {
            left: 100% !important;
        }

        .btn-submit:hover {
            transform: translateY(-4px) !important;
            box-shadow: 
                0 15px 40px rgba(74, 47, 26, 0.5),
                0 8px 20px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.25) !important;
            background: linear-gradient(135deg, #9d6b33 0%, #72532c 50%, #543921 100%) !important;
        }

        .btn-submit:active {
            transform: translateY(-1px) !important;
            box-shadow: 
                0 8px 25px rgba(74, 47, 26, 0.4),
                0 4px 12px rgba(0, 0, 0, 0.2) !important;
        }

        /* Error Alert */
        .error-box {
            background: linear-gradient(135deg, #fef3f2 0%, #ffe8e6 100%) !important;
            border: 2.5px solid #ef4444 !important;
            border-radius: 16px !important;
            padding: 1rem 1.25rem !important;
            margin-bottom: 1.5rem !important;
            box-shadow: 0 4px 20px rgba(239, 68, 68, 0.15) !important;
        }

        .error-box strong {
            color: #dc2626 !important;
            font-weight: 700 !important;
            display: block !important;
            margin-bottom: 0.25rem !important;
        }

        .error-box p {
            color: #991b1b !important;
            margin: 0 !important;
        }

        .error-text {
            color: #dc2626 !important;
            font-size: 0.8rem !important;
            font-weight: 600 !important;
            margin-top: 0.4rem !important;
            display: block !important;
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, #4a2f1a 0%, #654321 50%, #8b5a2b 100%) !important;
            color: #f5f5f5 !important;
            text-align: center !important;
            padding: 1.5rem !important;
            margin-top: 4rem !important;
            box-shadow: 
                0 -4px 30px rgba(0, 0, 0, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.1) !important;
            border-top: 2px solid rgba(212, 163, 115, 0.3) !important;
            font-weight: 500 !important;
            letter-spacing: 0.3px !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr !important;
                gap: 1.5rem !important;
            }

            .card-wrapper {
                padding: 2rem 1.5rem !important;
                border-radius: 24px !important;
            }

            .main-title {
                font-size: 2rem !important;
            }

            .subtitle {
                font-size: 1rem !important;
            }

            .form-container {
                padding: 1.5rem !important;
            }

            .card-wrapper::before {
                font-size: 150px !important;
                top: -30px !important;
                right: -30px !important;
            }

            .btn-submit {
                padding: 1rem 2.5rem !important;
                font-size: 0.95rem !important;
            }

            .brand-text {
                font-size: 1.25rem !important;
            }

            main {
                padding: 0 1rem !important;
            }

            .header-container {
                padding: 0 1rem !important;
            }
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <header>
        <div class="header-container">
            <a href="{{ route('home') }}" class="logo-link">
                <img src="{{ asset('LOGO2.png') }}" class="logo-img" alt="SeduhRasa Coffee Logo">
                <span class="brand-text">
                    <span class="brand-seduh">Seduh</span><span class="brand-rasa">Rasa</span>
                </span>
            </a>

            <a href="{{ route('home') }}" class="back-btn">
                Kembali ke Beranda
            </a>
        </div>
    </header>

    {{-- MAIN --}}
    <main>
        <section class="card-wrapper">
            <div class="title-section">
                <h2 class="main-title">Data Pembeli</h2>
                <p class="subtitle">
                    Lengkapi informasi di bawah ini untuk melanjutkan ke halaman pilih menu.
                </p>
            </div>

            <div class="form-container">
                {{-- Error Alert --}}
                @if ($errors->any())
                    <div class="error-box">
                        <strong>Ada data yang belum benar.</strong>
                        <p>Silakan cek kembali form di bawah.</p>
                    </div>
                @endif

                {{-- FORM --}}
                <form action="{{ route('order.storeInfo') }}" method="POST" class="form-wrapper">
                    @csrf

                    <div class="form-grid">
                        {{-- NAMA --}}
                        <div class="form-group">
                            <label class="form-label" for="nama_pelanggan">
                                Nama Lengkap
                            </label>
                            <input
                                type="text"
                                id="nama_pelanggan"
                                name="name"
                                value="{{ old('name', $customer['name'] ?? '') }}"
                                placeholder="Masukkan nama lengkap"
                                class="form-input"
                                required
                            >
                            @error('name')
                                <span class="error-text">{{ $message }}</span>
                            @else
                                <small class="form-hint">
                                    Sesuai dengan identitas atau nama akunmu
                                </small>
                            @enderror
                        </div>

                        {{-- EMAIL --}}
                        <div class="form-group">
                            <label class="form-label" for="email">
                                Email
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $customer['email'] ?? '') }}"
                                placeholder="nama@email.com"
                                class="form-input"
                            >
                            @error('email')
                                <span class="error-text">{{ $message }}</span>
                            @else
                                <small class="form-hint">
                                    Digunakan untuk konfirmasi pesanan (opsional)
                                </small>
                            @enderror
                        </div>

                        {{-- TELEPON --}}
                        <div class="form-group">
                            <label class="form-label" for="telepon">
                                No. Telepon
                            </label>
                            <input
                                type="tel"
                                id="telepon"
                                name="phone"
                                value="{{ old('phone', $customer['phone'] ?? '') }}"
                                placeholder="08xxxxxxxxxx"
                                class="form-input"
                                required
                            >
                            @error('phone')
                                <span class="error-text">{{ $message }}</span>
                            @else
                                <small class="form-hint">
                                    Pastikan nomor aktif untuk kontak pengiriman
                                </small>
                            @enderror
                        </div>
                    </div>

                    <div class="btn-container">
                        <button type="submit" class="btn-submit">
                            Lanjut ke Pilih Menu
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </main>

    {{-- FOOTER --}}
    <footer>
        © {{ date('Y') }} SeduhRasa Coffee. All rights reserved.
    </footer>

</body>
</html>