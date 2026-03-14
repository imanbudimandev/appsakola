@extends('layouts.admin')

@section('header', 'System Settings')

@section('content')
<div class="row column1">
    <div class="col-md-12 text-left">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- General Settings -->
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="heading1 margin_0">
                        <h2><i class="fa fa-cogs text-primary mr-2"></i> General Configuration</h2>
                    </div>
                </div>
                <div class="padding_infor_info">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Site Name</label>
                                <input type="text" name="site_name" value="{{ \App\Models\Setting::get('site_name', 'Appsakola') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Contact Email</label>
                                <input type="email" name="contact_email" value="{{ \App\Models\Setting::get('contact_email', 'support@appsakola.com') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Footer Text</label>
                                <input type="text" name="site_footer" value="{{ \App\Models\Setting::get('site_footer', 'Copyright © ' . date('Y') . ' Appsakola. All rights reserved.') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Site Logo (Optional)</label>
                                <div class="custom-file text-left">
                                    <input type="file" name="site_logo" accept="image/*" class="custom-file-input form-control" id="site_logo">
                                    <label class="custom-file-label" for="site_logo">Choose logo image</label>
                                </div>
                                <small class="text-muted d-block mt-2">Recommended: max 2MB.</small>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            @if(\App\Models\Setting::get('site_logo'))
                                <img src="{{ asset('storage/' . \App\Models\Setting::get('site_logo')) }}" alt="Current Logo" class="img-thumbnail mt-2" style="max-height: 80px;">
                                <p class="text-muted mt-1 small">Current Logo</p>
                            @else
                                <p class="text-muted mt-4">No custom logo uploaded.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

@push('scripts')
<script>
    // To show the name of the file in custom file input
    $('.custom-file-input').on('change',function(){
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    })
</script>
@endpush

            <!-- Payment Settings -->
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="heading1 margin_0">
                        <h2><i class="fa fa-credit-card text-primary mr-2"></i> Payment Gateway (Midtrans)</h2>
                    </div>
                </div>
                <div class="padding_infor_info">

                    {{-- Mode: Sandbox / Production --}}
                    @php $isProduction = \App\Models\Setting::get('midtrans_is_production') == '1'; @endphp
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label class="font-weight-bold d-block mb-2">Mode Midtrans</label>
                            <div class="d-flex gap-3" style="gap: 16px;">
                                <label class="border rounded-lg p-3 d-flex align-items-center" style="cursor:pointer; flex:1; border-color: {{ !$isProduction ? '#6366f1' : '#dee2e6' }} !important; background: {{ !$isProduction ? '#eef2ff' : '#fff' }};">
                                    <input type="radio" name="midtrans_is_production" value="0" {{ !$isProduction ? 'checked' : '' }} style="margin-right:10px;">
                                    <div>
                                        <span class="font-weight-bold d-block" style="color: {{ !$isProduction ? '#6366f1' : '#333' }};">🧪 Sandbox (Testing)</span>
                                        <small class="text-muted">Gunakan untuk testing. Pembayaran tidak nyata.</small>
                                    </div>
                                </label>
                                <label class="border rounded-lg p-3 d-flex align-items-center" style="cursor:pointer; flex:1; border-color: {{ $isProduction ? '#16a34a' : '#dee2e6' }} !important; background: {{ $isProduction ? '#f0fdf4' : '#fff' }};">
                                    <input type="radio" name="midtrans_is_production" value="1" {{ $isProduction ? 'checked' : '' }} style="margin-right:10px;">
                                    <div>
                                        <span class="font-weight-bold d-block" style="color: {{ $isProduction ? '#16a34a' : '#333' }};">🚀 Production (Live)</span>
                                        <small class="text-muted">Gunakan jika sudah siap menerima pembayaran nyata.</small>
                                    </div>
                                </label>
                            </div>
                            @if(!$isProduction)
                                <div class="alert alert-warning mt-3 mb-0" style="font-size:13px;">
                                    <i class="fa fa-exclamation-triangle mr-1"></i>
                                    <strong>Mode Sandbox aktif.</strong> Gunakan kartu/akun test Midtrans. Tidak ada uang nyata yang diproses.
                                    <a href="https://docs.midtrans.com/docs/testing-payment-on-sandbox" target="_blank" class="alert-link ml-2">Lihat cara test →</a>
                                </div>
                            @else
                                <div class="alert alert-success mt-3 mb-0" style="font-size:13px;">
                                    <i class="fa fa-check-circle mr-1"></i>
                                    <strong>Mode Production aktif.</strong> Pembayaran nyata dari pelanggan akan diproses.
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">
                                    {{ !$isProduction ? 'Sandbox' : 'Production' }} Client Key
                                    <small class="text-muted">(dari Midtrans Dashboard)</small>
                                </label>
                                <input type="text" name="midtrans_client_key" value="{{ \App\Models\Setting::get('midtrans_client_key') }}" class="form-control" placeholder="{{ !$isProduction ? 'SB-Mid-client-xxxxxxx' : 'Mid-client-xxxxxxx' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">
                                    {{ !$isProduction ? 'Sandbox' : 'Production' }} Server Key
                                    <small class="text-muted">(dari Midtrans Dashboard)</small>
                                </label>
                                <input type="password" name="midtrans_server_key" value="{{ \App\Models\Setting::get('midtrans_server_key') }}" class="form-control" placeholder="{{ !$isProduction ? 'SB-Mid-server-xxxxxxx' : 'Mid-server-xxxxxxx' }}">
                                <small class="text-muted">Key selalu tersimpan terenkripsi.</small>
                            </div>
                        </div>
                    </div>

                    {{-- Pilih Metode Pembayaran --}}
                    @php
                        $savedMethods = json_decode(\App\Models\Setting::get('midtrans_payment_methods', '[]'), true) ?: [];
                        $allMethods = [
                            'credit_card'   => ['label' => 'Kartu Kredit / Debit', 'icon' => 'fa-credit-card', 'color' => '#4f46e5'],
                            'bca_va'        => ['label' => 'BCA Virtual Account', 'icon' => 'fa-university', 'color' => '#0066AE'],
                            'bni_va'        => ['label' => 'BNI Virtual Account', 'icon' => 'fa-university', 'color' => '#f97316'],
                            'bri_va'        => ['label' => 'BRI Virtual Account', 'icon' => 'fa-university', 'color' => '#16a34a'],
                            'mandiri_va'    => ['label' => 'Mandiri Virtual Account', 'icon' => 'fa-university', 'color' => '#eab308'],
                            'permata_va'    => ['label' => 'Permata Virtual Account', 'icon' => 'fa-university', 'color' => '#dc2626'],
                            'gopay'         => ['label' => 'GoPay', 'icon' => 'fa-mobile', 'color' => '#00AED6'],
                            'shopeepay'     => ['label' => 'ShopeePay', 'icon' => 'fa-mobile', 'color' => '#EE4D2D'],
                            'qris'          => ['label' => 'QRIS', 'icon' => 'fa-qrcode', 'color' => '#7c3aed'],
                            'indomaret'     => ['label' => 'Indomaret', 'icon' => 'fa-store', 'color' => '#ea0001'],
                            'alfamart'      => ['label' => 'Alfamart', 'icon' => 'fa-store', 'color' => '#e51837'],
                            'akulaku'       => ['label' => 'Akulaku (Cicilan)', 'icon' => 'fa-calendar', 'color' => '#1890ff'],
                        ];
                    @endphp
                    <hr>
                    <div class="mt-4">
                        <label class="font-weight-bold d-block mb-1">Metode Pembayaran yang Ditampilkan</label>
                        <small class="text-muted d-block mb-3">Pilih metode yang akan ditawarkan ke pelanggan saat checkout. Kosongkan = semua metode otomatis tampil.</small>
                        <div class="row">
                            @foreach($allMethods as $key => $method)
                            <div class="col-md-4 col-sm-6 mb-3">
                                <label class="d-flex align-items-center p-3 border rounded" style="cursor:pointer; background: {{ in_array($key, $savedMethods) ? '#f5f3ff' : '#fff' }}; border-color: {{ in_array($key, $savedMethods) ? '#6366f1' : '#dee2e6' }} !important;">
                                    <input type="checkbox" name="midtrans_payment_methods[]" value="{{ $key }}" {{ in_array($key, $savedMethods) ? 'checked' : '' }} style="margin-right:10px; width:16px; height:16px;">
                                    <span>
                                        <i class="fa {{ $method['icon'] }} mr-1" style="color: {{ $method['color'] }};"></i>
                                        <span style="font-size:13px; font-weight:600;">{{ $method['label'] }}</span>
                                    </span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>


            <!-- Invoice & Printing Settings -->
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="heading1 margin_0">
                        <h2><i class="fa fa-print text-primary mr-2"></i> Invoice & Printing Configuration</h2>
                    </div>
                </div>
                <div class="padding_infor_info">
                    <div class="row">
                        <div class="col-md-6">
                            @php $paperSize = \App\Models\Setting::get('invoice_paper_size', 'a4'); @endphp
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Paper Size</label>
                                <select name="invoice_paper_size" class="form-control">
                                    <option value="a4" {{ $paperSize == 'a4' ? 'selected' : '' }}>Standard A4 (210mm x 297mm)</option>
                                    <option value="folio" {{ $paperSize == 'folio' ? 'selected' : '' }}>Folio / F4 (215mm x 330mm)</option>
                                    <option value="thermal_80" {{ $paperSize == 'thermal_80' ? 'selected' : '' }}>Thermal Printer 80mm</option>
                                    <option value="thermal_58" {{ $paperSize == 'thermal_58' ? 'selected' : '' }}>Thermal Printer 58mm</option>
                                </select>
                                <small class="text-muted">Pilih ukuran kertas yang sesuai dengan printer Anda untuk hasil cetak yang pas.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Invoice Note (Optional)</label>
                                <input type="text" name="invoice_note" value="{{ \App\Models\Setting::get('invoice_note', 'Terima kasih atas pembelian Anda!') }}" class="form-control" placeholder="Pesan di bawah invoice">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manual Bank Transfer -->
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="heading1 margin_0">
                        <h2><i class="fa fa-bank text-primary mr-2"></i> Manual Bank Transfer</h2>
                    </div>
                </div>
                <div class="padding_infor_info">
                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Bank Information (Display to customer)</label>
                        <textarea name="manual_bank_info" rows="3" class="form-control" placeholder="e.g. Bank BCA 1234567 a/n Iman">{{ \App\Models\Setting::get('manual_bank_info') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="margin_bottom_30 text-right">
                <button type="submit" class="btn btn-primary btn-lg">Save All Settings</button>
            </div>
        </form>
    </div>
</div>
@endsection
