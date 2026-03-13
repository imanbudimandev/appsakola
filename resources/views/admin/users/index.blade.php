@extends('layouts.admin')

@section('header', 'User Management')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-medium">
                <tr>
                    <th class="px-6 py-4">Name</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Role</th>
                    <th class="px-6 py-4">Joined At</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($users as $user)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-sm font-semibold text-slate-700">{{ $user->name }}</td>
                    <td class="px-6 py-4 text-sm text-slate-500">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-slate-100 text-slate-700' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-500">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-right">
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.update-role', $user) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <select name="role" onchange="this.form.submit()" class="text-xs border-slate-200 rounded-lg focus:ring-primary focus:border-primary">
                                <option value="member" {{ $user->role == 'member' ? 'selected' : '' }}>Make Member</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Make Admin</option>
                            </select>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
