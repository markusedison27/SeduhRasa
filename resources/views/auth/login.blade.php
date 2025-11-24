@extends('layouts.guest')
@section('title', 'Masuk - SeduhRasa')

@section('content')
    <style>
        /* Coffee steam animation */
        @keyframes steam {
            0% { transform: translateY(0) scaleX(1); opacity: 0; }
            50% { opacity: 0.15; }
            100% { transform: translateY(-40px) scaleX(1.5); opacity: 0; }
        }
        .steam span {
            position: absolute;
            bottom: 100%;
            left: 50%;
            width: 8px;
            height: 20px;
            background: linear-gradient(to top, rgba(198, 124, 78, 0.4), transparent);
            border-radius: 50%;
            filter: blur(8px);
            animation: steam 3s ease-out infinite;
        }
        .steam span:nth-child(1) { animation-delay: 0s; margin-left: -6px; }
        .steam span:nth-child(2) { animation-delay: 0.7s; margin-left: 2px; }
        .steam span:nth-child(3) { animation-delay: 1.4s; margin-left: -2px; }

        /* Card entrance animation */
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .card-animate { animation: cardIn 0.6s cubic-bezier(0.16, 1, 0.3, 1); }

        /* Logo pulse */
        @keyframes logoPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .logo-pulse { animation: logoPulse 3s ease-in-out infinite; }

        /* Input focus glow */
        .input-glow:focus {
            box-shadow: 0 0 0 3px rgba(198, 124, 78, 0.1), 0 0 20px rgba(198, 124, 78, 0.15);
        }

        /* Button press effect */
        .btn-press:active {
            transform: translateY(2px);
            box-shadow: 0 2px 0 0 #5a2b00 !important;
        }

        /* Floating label enhanced */
        .float-label {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Card glow effect */
        .card-glow {
            position: relative;
        }
        .card-glow::before {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(135deg, rgba(198, 124, 78, 0.2), rgba(123, 63, 0, 0.1));
            border-radius: 14px;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
            filter: blur(10px);
        }
        .card-glow:hover::before {
            opacity: 1;
        }

        /* Coffee bean decorations */
        .bean {
            position: absolute;
            width: 8px;
            height: 10px;
            background: rgba(123, 63, 0, 0.08);
            border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
            opacity: 0;
            animation: beanFloat 20s ease-in-out infinite;
        }
        @keyframes beanFloat {
            0%, 100% { transform: translate(0, 0) rotate(0deg); opacity: 0; }
            10% { opacity: 0.6; }
            50% { transform: translate(-30px, -100px) rotate(180deg); opacity: 0.3; }
            90% { opacity: 0.6; }
        }
        .bean:nth-child(1) { top: 20%; left: 10%; animation-delay: 0s; }
        .bean:nth-child(2) { top: 60%; left: 15%; animation-delay: 5s; }
        .bean:nth-child(3) { top: 40%; right: 12%; animation-delay: 10s; }
        .bean:nth-child(4) { top: 75%; right: 18%; animation-delay: 15s; }
    </style>

    <div class="w-full max-w-sm relative">
        <!-- Floating coffee beans decoration -->
        <div class="bean"></div>
        <div class="bean"></div>
        <div class="bean"></div>
        <div class="bean"></div>

        <!-- Logo dengan gambar LOGO2.png + steam -->
        <div class="mb-8 flex items-center gap-2.5 justify-center">
            <div class="relative steam logo-pulse">
                <span></span>
                <span></span>
                <span></span>
                <img src="{{ asset('LOGO2.png') }}" class="h-16 w-16 rounded-xl object-cover shadow-lg shadow-[#7B3F00]/25" alt="SeduhRasa Logo">
            </div>
            <span class="text-xl font-bold tracking-tight bg-gradient-to-r from-[#7B3F00] to-[#C67C4E] bg-clip-text text-transparent">
                SeduhRasa
            </span>
        </div>

        <!-- Main card -->
        <div class="card-animate card-glow bg-white/90 backdrop-blur-xl rounded-2xl ring-1 ring-stone-200/50 shadow-[0_20px_50px_-12px_rgba(123,63,0,0.25)] p-8">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-stone-800 mb-1">Selamat Datang</h1>
                <p class="text-sm text-stone-500">Kelola kedai kopi Anda dengan mudah</p>
            </div>

            <!-- Error message -->
            @if ($errors->any())
                <div class="mb-5 rounded-xl bg-red-50 text-red-700 ring-1 ring-red-200/50 px-4 py-3 text-sm flex items-start gap-2 card-animate">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf

                <!-- Email input -->
                <div class="relative group">
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        autocomplete="username" 
                        required
                        value="{{ old('email') }}"
                        class="peer w-full px-4 py-3 rounded-xl border-2 border-stone-200 bg-stone-50/50 
                               focus:border-[#C67C4E] focus:bg-white focus:ring-0 
                               placeholder-transparent transition-all duration-200 input-glow"
                        placeholder="Email">
                    <label 
                        for="email"
                        class="float-label absolute left-4 top-3.5 px-1 text-stone-500 text-sm pointer-events-none
                               peer-focus:text-xs peer-focus:-top-2.5 peer-focus:left-3 peer-focus:bg-white peer-focus:text-[#7B3F00] peer-focus:font-medium
                               peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:-top-2.5 peer-[:not(:placeholder-shown)]:left-3 peer-[:not(:placeholder-shown)]:bg-white peer-[:not(:placeholder-shown)]:font-medium">
                        Alamat Email
                    </label>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none opacity-0 peer-focus:opacity-100 transition-opacity">
                        <svg class="w-5 h-5 text-[#C67C4E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>

                <!-- Password input -->
                <div class="relative group">
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        autocomplete="current-password" 
                        required
                        class="peer w-full px-4 py-3 rounded-xl border-2 border-stone-200 bg-stone-50/50 
                               focus:border-[#C67C4E] focus:bg-white focus:ring-0 
                               placeholder-transparent transition-all duration-200 input-glow"
                        placeholder="Password">
                    <label 
                        for="password"
                        class="float-label absolute left-4 top-3.5 px-1 text-stone-500 text-sm pointer-events-none
                               peer-focus:text-xs peer-focus:-top-2.5 peer-focus:left-3 peer-focus:bg-white peer-focus:text-[#7B3F00] peer-focus:font-medium
                               peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:-top-2.5 peer-[:not(:placeholder-shown)]:left-3 peer-[:not(:placeholder-shown)]:bg-white peer-[:not(:placeholder-shown)]:font-medium">
                        Kata Sandi
                    </label>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none opacity-0 peer-focus:opacity-100 transition-opacity">
                        <svg class="w-5 h-5 text-[#C67C4E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between pt-1">
                    <label class="inline-flex items-center gap-2 text-sm cursor-pointer group/check">
                        <input 
                            type="checkbox" 
                            name="remember"
                            class="w-4 h-4 rounded border-stone-300 text-[#7B3F00] focus:ring-[#C67C4E] focus:ring-offset-0 cursor-pointer transition-all">
                        <span class="text-stone-600 group-hover/check:text-stone-800 transition-colors">Ingat saya</span>
                    </label>
                    <a href="#" class="text-sm text-[#7B3F00] hover:text-[#C67C4E] font-medium transition-colors">
                        Lupa kata sandi?
                    </a>
                </div>

                <!-- Submit button -->
                <button 
                    type="submit"
                    class="btn-press w-full py-3.5 rounded-xl bg-gradient-to-r from-[#7B3F00] to-[#8B4513] text-white font-semibold
                           shadow-[0_6px_0_0_#5a2b00,0_6px_20px_rgba(123,63,0,0.3)] 
                           hover:shadow-[0_6px_0_0_#5a2b00,0_8px_25px_rgba(123,63,0,0.4)]
                           hover:translate-y-[-2px] 
                           active:translate-y-[2px] active:shadow-[0_2px_0_0_#5a2b00]
                           transition-all duration-150 
                           flex items-center justify-center gap-2 group/btn">
                    <span>Masuk ke Dashboard</span>
                    <svg class="w-5 h-5 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
            </form>

            <!-- Divider with coffee icon -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-stone-200"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="bg-white px-3 text-xs text-stone-400 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                        </svg>
                        SeduhRasa Coffee Management
                    </span>
                </div>
            </div>

            <!-- Additional info -->
            <p class="text-center text-xs text-stone-400">
                Belum punya akses? 
                <a href="#" class="text-[#7B3F00] hover:text-[#C67C4E] font-medium transition-colors">Hubungi admin</a>
            </p>
        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-stone-400 mt-6 flex items-center justify-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
            </svg>
            © {{ date('Y') }} SeduhRasa • Crafted with love & coffee
        </p>
    </div>
@endsection