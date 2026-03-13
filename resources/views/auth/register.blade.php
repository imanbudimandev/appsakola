@extends('layouts.app')

@section('title', 'Sign Up - Appsakola')

@section('content')
<div class="max-w-md mx-auto my-16">
    <div class="bg-white p-8 rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100">
        <h2 class="text-3xl font-bold text-slate-800 mb-2">Create Account</h2>
        <p class="text-slate-500 mb-8">Join appsakola and start your journey.</p>

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary focus:ring-4 focus:ring-primary/10 transition outline-none" placeholder="John Doe">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
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
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary focus:ring-4 focus:ring-primary/10 transition outline-none" placeholder="••••••••">
            </div>

            <button type="submit" class="w-full py-3 bg-primary text-white rounded-xl font-semibold hover:bg-secondary transition shadow-lg shadow-primary/20 mt-4">
                Register
            </button>

            <p class="text-center text-sm text-slate-600 mt-6">
                Already have an account? <a href="{{ route('login') }}" class="text-primary font-medium">Sign in</a>
            </p>
        </form>
    </div>
</div>
@endsection
