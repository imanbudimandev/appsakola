@extends('layouts.admin')

@section('header', 'User Management')

@section('content')
<div class="row column1">
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head d-flex justify-content-between align-items-center">
                <div class="heading1 margin_0">
                    <h2>User List</h2>
                </div>
                <div>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add User</a>
                </div>
            </div>
            <div class="table_section padding_infor_info">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Joined At</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td><strong>{{ $user->name }}</strong></td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge {{ $user->role == 'admin' ? 'badge-primary' : 'badge-secondary' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td class="text-right">
                                    <div class="d-inline-flex">
                                        @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.update-role', $user) }}" method="POST" class="mr-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" onchange="this.form.submit()" class="form-control form-control-sm d-inline-block w-auto">
                                                <option value="member" {{ $user->role == 'member' ? 'selected' : '' }}>Make Member</option>
                                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Make Admin</option>
                                            </select>
                                        </form>
                                        @endif
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm text-white mr-1" title="Edit User">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete User">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
