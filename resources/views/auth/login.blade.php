<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TFD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .logo-circle {
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 50%;
        }
    </style>
</head>
<body class="min-h-screen flex bg-black overflow-hidden uppercase">

    <!-- LEFT SIDE: BRANDING -->
    <div class="hidden md:flex w-1/2 items-center justify-center relative bg-black border-r border-white/5">
        <div class="logo-circle w-[500px] h-[500px] absolute flex items-center justify-center">
            <div class="text-center">
                <h1 class="text-white text-[120px] font-black leading-none tracking-tighter">TFD</h1>
                <p class="text-white text-3xl font-bold tracking-tight mt-2 italic px-8">trip factory depok</p>
            </div>
        </div>
    </div>

    <!-- RIGHT SIDE: LOGIN FORM -->
    <div class="w-full md:w-1/2 flex items-center justify-center bg-[#1a1a1a] p-6 lg:p-12 relative overflow-y-auto">
        
        <div class="w-full max-w-md bg-[#222222] p-10 rounded-[30px] border border-white/5 shadow-2xl">
            <div class="mb-10 text-left normal-case">
                <h2 class="text-3xl font-bold text-white tracking-tight">Selamat datang</h2>
                <p class="text-zinc-500 mt-2 text-sm font-medium">masuk untuk mengakses koleksi pilihan anda</p>
            </div>

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 text-red-400 rounded-2xl flex items-center gap-3 text-sm font-bold normal-case">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="/login" class="space-y-6">
                @csrf
                <!-- Label: Identifikasi -->
                <div class="space-y-2">
                    <p class="text-[11px] font-bold text-zinc-600 uppercase tracking-widest ml-1">IDENTIFIKASI</p>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-zinc-500 transition-colors">
                            <i data-lucide="mail" class="w-5 h-5"></i>
                        </div>
                        <input type="email" name="email" placeholder="Alamat email" required
                               class="w-full bg-[#111111]/80 border border-white/10 rounded-2xl py-4 pl-12 pr-4 text-white placeholder-zinc-700 focus:outline-none focus:border-cyan-600 focus:bg-[#000000] transition-all font-medium normal-case">
                    </div>
                </div>

                <!-- Label: Keamanan -->
                <div class="space-y-2 text-left">
                    <p class="text-[11px] font-bold text-zinc-600 uppercase tracking-widest ml-1">KEAMANAN</p>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-zinc-500 transition-colors">
                            <i data-lucide="lock" class="w-5 h-5"></i>
                        </div>
                        <input type="password" name="password" placeholder="Kata sandi" required
                               class="w-full bg-[#111111]/80 border border-white/10 rounded-2xl py-4 pl-12 pr-4 text-white placeholder-zinc-700 focus:outline-none focus:border-cyan-600 focus:bg-[#000000] transition-all font-medium normal-case">
                    </div>
                </div>

                <div class="pt-4">
                    <button class="w-full bg-[#337a8a] text-white py-4 rounded-xl font-black tracking-[0.1em] hover:bg-[#3d8d9e] hover:scale-[1.01] active:scale-95 transition-all shadow-xl shadow-cyan-950/20 text-sm uppercase">
                        AKUN MASUK
                    </button>
                </div>

                <div class="text-center pt-4 normal-case">
                    <p class="text-zinc-500 text-sm font-semibold">
                        Sudah punya akun? 
                        <a href="{{ route('register') }}" class="text-[#337a8a] hover:text-[#45a4b8] transition hover:underline">Daftar</a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Mobile Logo -->
        <div class="md:hidden absolute top-8 left-1/2 -translate-x-1/2 text-center">
            <h1 class="text-white text-4xl font-black leading-none tracking-tighter">TFD</h1>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>