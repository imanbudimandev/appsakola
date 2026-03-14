@extends('layouts.admin')

@section('header', 'Frontend Configuration')

@section('content')
<div class="row column1">
    <div class="col-md-12 text-left">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Hero Section -->
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="heading1 margin_0">
                        <h2><i class="fa fa-desktop text-primary mr-2"></i> Hero Section</h2>
                    </div>
                </div>
                <div class="padding_infor_info">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Hero Title (HTML Supported)</label>
                                <textarea name="hero_title" rows="3" class="form-control">{{ \App\Models\Setting::get('hero_title', 'Digital Products for <br><span class="bg-clip-text text-transparent bg-gradient-to-r from-primary via-primary to-secondary">Modern Developers</span>') }}</textarea>
                                <small class="text-muted">Gunakan &lt;br&gt; untuk baris baru dan class Tailwind untuk gradasi.</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Hero Subtitle</label>
                                <textarea name="hero_subtitle" rows="3" class="form-control">{{ \App\Models\Setting::get('hero_subtitle', 'Premium source codes, UI kits, and digital assets to accelerate your development workflow. Built with quality in mind.') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Primary Button Text</label>
                                <input type="text" name="hero_primary_btn_text" value="{{ \App\Models\Setting::get('hero_primary_btn_text', 'Browse Marketplace') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Primary Button Link</label>
                                <input type="text" name="hero_primary_btn_link" value="{{ \App\Models\Setting::get('hero_primary_btn_link', '#products') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Secondary Button Text</label>
                                <input type="text" name="hero_secondary_btn_text" value="{{ \App\Models\Setting::get('hero_secondary_btn_text', 'Become a Member') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Secondary Button Link</label>
                                <input type="text" name="hero_secondary_btn_link" value="{{ \App\Models\Setting::get('hero_secondary_btn_link', '/register') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="heading1 margin_0">
                        <h2><i class="fa fa-bar-chart text-primary mr-2"></i> Stats Section</h2>
                    </div>
                </div>
                <div class="padding_infor_info">
                    <div class="row">
                        @for($i = 1; $i <= 4; $i++)
                        <div class="col-md-3">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Stat {{ $i }} Value</label>
                                <input type="text" name="stat_{{ $i }}_value" value="{{ \App\Models\Setting::get('stat_'.$i.'_value', ($i == 1 ? '500+' : ($i == 2 ? '12K+' : ($i == 3 ? '24/7' : '100%')))) }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Stat {{ $i }} Label</label>
                                <input type="text" name="stat_{{ $i }}_label" value="{{ \App\Models\Setting::get('stat_'.$i.'_label', ($i == 1 ? 'Products' : ($i == 2 ? 'Happy Users' : ($i == 3 ? 'Support' : 'Safe')))) }}" class="form-control">
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Latest Section Info -->
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="heading1 margin_0">
                        <h2><i class="fa fa-star text-primary mr-2"></i> Products Section</h2>
                    </div>
                </div>
                <div class="padding_infor_info">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Products Title</label>
                                <input type="text" name="products_title" value="{{ \App\Models\Setting::get('products_title', 'Latest Drops') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Products Subtitle</label>
                                <input type="text" name="products_subtitle" value="{{ \App\Models\Setting::get('products_subtitle', 'Check out our newest digital assets.') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="margin_bottom_30 text-right">
                <button type="submit" class="btn btn-primary btn-lg">Update Content</button>
            </div>
        </form>
    </div>
</div>
@endsection
