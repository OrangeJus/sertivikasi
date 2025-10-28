@extends('layouts.app')

@section('page-title', 'Kelola User')

@section('content')
<div style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div>
            <h2 style="font-size: 28px; font-weight: 600; margin-bottom: 10px;">Kelola User</h2>
            <p style="color: #666; font-size: 14px;">Manajemen data pengguna sistem</p>
        </div>
        <a href="{{ route('admin.users.create') }}" style="padding: 12px 24px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
            <svg style="width: 20px; height: 20px; fill: white;" viewBox="0 0 24 24">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
            </svg>
            Tambah User
        </a>
    </div>
</div>

<!-- Success Message -->
@if (session('success'))
    <div class="alert alert-success" style="margin-bottom: 25px;">
        {{ session('success') }}
    </div>
@endif

<!-- Search & Filter -->
<div class="card" style="margin-bottom: 30px;">
    <form method="GET" action="{{ route('admin.users.index') }}">
        <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 250px;">
                <input 
                    type="text" 
                    name="search"
                    placeholder="Cari nama atau email..." 
                    value="{{ request('search') }}"
                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;"
                >
            </div>
            <div style="min-width: 150px;">
                <select name="role" style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; background: white; cursor: pointer;">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>
            <button type="submit" style="padding: 12px 24px; background: #667eea; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                Cari
            </button>
            @if(request('search') || request('role'))
                <a href="{{ route('admin.users.index') }}" style="padding: 12px 24px; background: #e0e0e0; color: #333; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Users Table -->
<div class="card">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa; text-align: left;">
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">No</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Nama</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Email</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Role</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Terdaftar</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                <tr style="border-bottom: 1px solid #e0e0e0;">
                    <td style="padding: 15px; color: #666; font-size: 14px;">{{ $users->firstItem() + $index }}</td>
                    <td style="padding: 15px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 16px;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <span style="color: #333; font-size: 14px; font-weight: 500;">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td style="padding: 15px; color: #666; font-size: 14px;">{{ $user->email }}</td>
                    <td style="padding: 15px;">
                        @if($user->role === 'admin')
                            <span style="background: #667eea; color: white; padding: 5px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Admin</span>
                        @else
                            <span style="background: #28a745; color: white; padding: 5px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">User</span>
                        @endif
                    </td>
                    <td style="padding: 15px; color: #666; font-size: 14px;">{{ $user->created_at->format('d M Y') }}</td>
                    <td style="padding: 15px;">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <a href="{{ route('admin.users.edit', $user->id) }}" style="padding: 8px 12px; background: #ffc107; color: white; border-radius: 5px; text-decoration: none; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                                <svg style="width: 16px; height: 16px; fill: white;" viewBox="0 0 24 24">
                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                </svg>
                                Edit
                            </a>
                            
                            @if($user->id !== Auth::id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" style="display: inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="padding: 8px 12px; background: #dc3545; color: white; border: none; border-radius: 5px; font-size: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 5px;">
                                    <svg style="width: 16px; height: 16px; fill: white;" viewBox="0 0 24 24">
                                        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                            @else
                            <span style="padding: 8px 12px; background: #ccc; color: #666; border-radius: 5px; font-size: 12px; font-weight: 600;">Akun Anda</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 40px; text-align: center; color: #999;">
                        <svg style="width: 64px; height: 64px; fill: #ddd; margin-bottom: 15px;" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                        </svg>
                        <p style="font-size: 16px; margin: 0;">Tidak ada data user</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div style="padding: 20px; border-top: 1px solid #e0e0e0;">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection