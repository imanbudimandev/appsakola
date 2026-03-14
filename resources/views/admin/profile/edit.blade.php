@extends('layouts.admin')

@section('header', 'Edit Profile')

@section('content')
<div class="row column1">
    <div class="col-md-12 text-left">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2><i class="fa fa-user text-primary mr-2"></i> My Profile</h2>
                </div>
            </div>
            <div class="padding_infor_info">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <div class="mb-3">
                                <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://themewagon.github.io/pluto/images/layout_img/user_img.jpg' }}" alt="Profile Photo" class="img-fluid rounded-circle border" style="width: 150px; height: 150px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/150x150?text=User'">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Profile Photo</label>
                                <div class="custom-file text-left mt-2">
                                    <input type="file" name="profile_photo" accept="image/*" class="custom-file-input form-control" id="profile_photo">
                                    <label class="custom-file-label" for="profile_photo">Choose image</label>
                                </div>
                                <small class="text-muted d-block mt-2 text-left">Recommended: Square image, max 2MB. (Leave empty if no change)</small>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <h4 class="mb-3 font-weight-bold border-bottom pb-2">Personal Information</h4>
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Full Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" placeholder="Leave empty to keep current name">
                            </div>
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" placeholder="Leave empty to keep current email">
                            </div>
                            
                            <h4 class="mb-3 mt-5 font-weight-bold border-bottom pb-2">Change Password</h4>
                            <p class="text-muted small">Leave password fields blank if you do not want to change your current password.</p>
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">New Password</label>
                                <input type="password" name="password" class="form-control" minlength="8" placeholder="Enter new password" autocomplete="new-password">
                            </div>
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password" autocomplete="new-password">
                            </div>
                        </div>
                    </div>

                    <div class="margin_bottom_30 text-right mt-4 pt-4 border-top">
                        <button type="submit" class="btn btn-primary btn-lg px-5 font-weight-bold">Save Profile Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // To show the name of the file
    $('.custom-file-input').on('change',function(){
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    })
</script>
@endpush
@endsection
