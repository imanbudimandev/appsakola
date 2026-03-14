@extends('layouts.admin')

@section('header', 'Edit User')

@section('content')
<div class="row column1">
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Edit User: {{ $user->name }}</h2>
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
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Full Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-control" placeholder="Enter full name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="form-control" placeholder="Enter email address">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Password</label>
                                <input type="password" name="password" class="form-control" minlength="8" placeholder="Leave blank to keep current password">
                                <small class="form-text text-muted">Fill this only if you want to change the password.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Role</label>
                                <select name="role" required class="form-control">
                                    <option value="member" {{ old('role', $user->role) == 'member' ? 'selected' : '' }}>Member</option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="margin_bottom_30 mt-3">
                        <button type="submit" class="btn btn-primary d-inline-block px-5 mr-2">Update User</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary d-inline-block px-5">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
