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
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Site Name</label>
                                <input type="text" name="site_name" value="{{ \App\Models\Setting::get('site_name', 'Appsakola') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Contact Email</label>
                                <input type="email" name="contact_email" value="{{ \App\Models\Setting::get('contact_email', 'support@appsakola.com') }}" class="form-control">
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
                    <div class="alert alert-info" role="alert">
                        <i class="fa fa-info-circle mr-2"></i>
                        We recommend using <strong>Midtrans</strong> for automated payments (QRIS, VA, Credit Card). Get your keys at <a href="https://dashboard.midtrans.com" target="_blank" class="alert-link">Midtrans Dashboard</a>.
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Midtrans Client Key</label>
                                <input type="text" name="midtrans_client_key" value="{{ \App\Models\Setting::get('midtrans_client_key') }}" class="form-control" placeholder="SB-Mid-client-...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Midtrans Server Key</label>
                                <input type="password" name="midtrans_server_key" value="{{ \App\Models\Setting::get('midtrans_server_key') }}" class="form-control" placeholder="SB-Mid-server-...">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <div class="custom-control custom-switch">
                            <input type="hidden" name="midtrans_is_production" value="0">
                            <input type="checkbox" class="custom-control-input" id="midtrans_is_production" name="midtrans_is_production" value="1" {{ \App\Models\Setting::get('midtrans_is_production') == '1' ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold" for="midtrans_is_production">Production Mode</label>
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
