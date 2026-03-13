@extends('layouts.admin')

@section('header', 'System Settings')

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
        @csrf
        
        <!-- General Settings -->
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
            <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                General Configuration
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Site Name</label>
                    <input type="text" name="site_name" value="{{ \App\Models\Setting::get('site_name', 'Appsakola') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary focus:ring-4 focus:ring-primary/10 transition outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Contact Email</label>
                    <input type="email" name="contact_email" value="{{ \App\Models\Setting::get('contact_email', 'support@appsakola.com') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary focus:ring-4 focus:ring-primary/10 transition outline-none">
                </div>
            </div>
        </div>

        <!-- Payment Settings -->
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
            <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Payment Gateway (Midtrans)
            </h3>
            <div class="space-y-6">
                <div class="p-4 bg-primary/5 rounded-xl border border-primary/10 flex items-start space-x-3">
                    <svg class="w-5 h-5 text-primary mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                    <p class="text-sm text-slate-600">
                        We recommend using <strong>Midtrans</strong> for automated payments (QRIS, VA, Credit Card). Get your keys at <a href="https://dashboard.midtrans.com" target="_blank" class="text-primary font-bold hover:underline">Midtrans Dashboard</a>.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Midtrans Client Key</label>
                        <input type="text" name="midtrans_client_key" value="{{ \App\Models\Setting::get('midtrans_client_key') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary focus:ring-4 focus:ring-primary/10 transition outline-none" placeholder="SB-Mid-client-...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Midtrans Server Key</label>
                        <input type="password" name="midtrans_server_key" value="{{ \App\Models\Setting::get('midtrans_server_key') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary focus:ring-4 focus:ring-primary/10 transition outline-none" placeholder="SB-Mid-server-...">
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <label class="flex items-center cursor-pointer">
                        <div class="relative">
                            <input type="hidden" name="midtrans_is_production" value="0">
                            <input type="checkbox" name="midtrans_is_production" value="1" {{ \App\Models\Setting::get('midtrans_is_production') == '1' ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </div>
                        <span class="ml-3 text-sm font-medium text-slate-700">Production Mode</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Manual Bank Transfer -->
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
            <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                Manual Bank Transfer
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Bank Information (Display to customer)</label>
                    <textarea name="manual_bank_info" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary focus:ring-4 focus:ring-primary/10 transition outline-none" placeholder="e.g. Bank BCA 1234567 a/n Iman">{{ \App\Models\Setting::get('manual_bank_info') }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-10 py-4 bg-primary text-white rounded-2xl font-bold hover:bg-secondary transition shadow-2xl shadow-primary/30">
                Save All Settings
            </button>
        </div>
    </form>
</div>
@endsection
