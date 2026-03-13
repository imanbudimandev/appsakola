<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Appsakola</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: { primary: '#6366f1', secondary: '#4f46e5' }
                }
            }
        }
    </script>
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; }
        .sidebar-active { background: rgba(99, 102, 241, 0.1); color: #6366f1; font-weight: 600; border-right: 4px solid #6366f1; }
    </style>
</head>
<body class="antialiased text-slate-900">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-slate-200 flex flex-col">
            <div class="p-6">
                <a href="/" class="text-2xl font-bold text-primary">appsakola</a>
            </div>
            <nav class="flex-grow space-y-1 py-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-6 py-4 {{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : 'text-slate-500 hover:bg-slate-50' }} transition">
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center space-x-3 px-6 py-4 {{ request()->routeIs('admin.categories.*') ? 'sidebar-active' : 'text-slate-500 hover:bg-slate-50' }} transition">
                    <span class="font-medium">Categories</span>
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center space-x-3 px-6 py-4 {{ request()->routeIs('admin.products.*') ? 'sidebar-active' : 'text-slate-500 hover:bg-slate-50' }} transition">
                    <span class="font-medium">Products</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center space-x-3 px-6 py-4 {{ request()->routeIs('admin.orders.*') ? 'sidebar-active' : 'text-slate-500 hover:bg-slate-50' }} transition">
                    <span class="font-medium">Orders</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 px-6 py-4 {{ request()->routeIs('admin.users.*') ? 'sidebar-active' : 'text-slate-500 hover:bg-slate-50' }} transition">
                    <span class="font-medium">Users</span>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="flex items-center space-x-3 px-6 py-4 {{ request()->routeIs('admin.settings.*') ? 'sidebar-active' : 'text-slate-500 hover:bg-slate-50' }} transition">
                    <span class="font-medium">Settings</span>
                </a>
            </nav>
            <div class="p-4 border-t border-slate-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-3 p-3 rounded-lg text-red-500 hover:bg-red-50 transition">
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow overflow-y-auto">
            <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-8">
                <h1 class="text-xl font-semibold text-slate-800">@yield('header')</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-slate-500">{{ auth()->user()->name }}</span>
                    <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </header>
            <div class="p-8">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
