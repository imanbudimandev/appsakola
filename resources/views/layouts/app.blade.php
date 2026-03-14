<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Appsakola - Digital Products')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN (Temporary for preview) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#15283c', // Dark Blue Pluto
                        secondary: '#ff5722', // Orange Pluto
                        dark: '#0e1a27',
                    }
                }
            }
        }
    </script>
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); }
    </style>
</head>
<body class="antialiased text-slate-900">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="sticky top-0 z-50 glass">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('landing') }}" class="flex items-center space-x-3 group">
                            @php $siteLogo = \App\Models\Setting::get('site_logo'); @endphp
                            @if($siteLogo)
                                <img src="{{ asset('storage/' . $siteLogo) }}" alt="Logo" class="h-8 w-auto">
                            @endif
                            <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary group-hover:from-secondary group-hover:to-primary transition duration-300">
                                {{ \App\Models\Setting::get('site_name', 'appsakola') }}
                            </span>
                        </a>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('member.dashboard') }}" class="text-sm font-medium text-slate-600 hover:text-secondary transition">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm font-medium text-slate-600 hover:text-red-500 transition">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-secondary transition">Login</a>
                            <a href="{{ route('register') }}" class="px-4 py-2 bg-secondary text-white rounded-lg text-sm font-medium hover:bg-primary transition shadow-lg shadow-secondary/20">Sign Up</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200 py-8">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <p class="text-slate-500 text-sm">{!! \App\Models\Setting::get('site_footer', 'Copyright © ' . date('Y') . ' Appsakola. All rights reserved.') !!}</p>
            </div>
        </footer>
    </div>
</body>
</html>
