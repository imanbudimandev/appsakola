@extends('layouts.app')

@section('title', 'Login - Appsakola')

@section('content')
<div class="max-w-md mx-auto my-20">
    <div class="bg-white p-8 rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100">
        <h2 class="text-3xl font-bold text-slate-800 mb-2">Welcome Back</h2>
        <p class="text-slate-500 mb-8">Login to manage your digital products.</p>

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary focus:ring-4 focus:ring-primary/10 transition outline-none" placeholder="name@example.com">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary focus:ring-4 focus:ring-primary/10 transition outline-none" placeholder="••••••••">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-primary border-slate-300 rounded focus:ring-primary">
                    <span class="ml-2 text-sm text-slate-600">Remember me</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3 bg-primary text-white rounded-xl font-semibold hover:bg-secondary transition shadow-lg shadow-primary/20">
                Sign In
            </button>

            <p class="text-center text-sm text-slate-600">
                Don't have an account? <a href="{{ route('register') }}" class="text-primary font-medium">Create one</a>
            </p>
        </form>
    </div>
</div>
@endsection
