@extends('layouts.app')

@section('page-title', 'Kelola Genset')

@section('content')
<div style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div>
            <h2 style="font-size: 28px; font-weight: 600; margin-bottom: 10px;">Kelola Genset</h2>
            <p style="color: #666; font-size: 14px;">Manajemen data genset untuk disewakan</p>
        </div>
        <a href="{{ route('admin.gensets.create') }}" style="padding: 12px 24px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
            <svg style="width: 20px; height: 20px; fill: white;" viewBox="0 0 24 24">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
            </svg>
            Tambah Genset
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
    <form method="GET" action="{{ route('admin.gensets.index') }}">
        <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 250px;">
                <input 
                    type="text" 
                    name="q"
                    placeholder="Cari nama genset ..." 
                    value="{{ request('q') }}"
                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;"
                >
            </div>
            <div style="min-width: 150px;">
                <select name="status" style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; background: white; cursor: pointer;">
                    <option value="">Semua Status</option>
                    <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="disewa" {{ request('status') == 'disewa' ? 'selected' : '' }}>Disewa</option>
                    <option value="rusak" {{ request('status') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                </select>
            </div>
            <button type="submit" style="padding: 12px 24px; background: #667eea; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                Cari
            </button>
            @if(request('q') || request('status'))
                <a href="{{ route('admin.gensets.index') }}" style="padding: 12px 24px; background: #e0e0e0; color: #333; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Gensets Table -->
<div class="card">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa; text-align: left;">
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">No</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Foto</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Nama Genset</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Kategori</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Kapasitas</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Harga Sewa</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px;">Status</th>
                    <th style="padding: 15px; font-weight: 600; color: #333; font-size: 14px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($gensets as $index => $genset)
                <tr style="border-bottom: 1px solid #e0e0e0;">
                    <td style="padding: 15px; color: #666; font-size: 14px;">{{ $gensets->firstItem() + $index }}</td>
                    
                    {{--  --}}
                    <td style="padding: 15px;">
                        @if ($genset->image)
                            <img src="{{ asset('storage/' . $genset->image) }}" alt="Foto Genset" width="80" style="width: 80px; height: 80px; background-image: url('{{ asset('storage/' . $genset->image) }}'); background-size: cover; background-position: center; background-repeat: no-repeat; border-radius: 8px;">
                        @else
                            <span class="text-muted">Tidak ada foto</span>
                        @endif
                    </td>
                    {{--  --}}

                    <td style="padding: 15px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 45px; height: 45px; border-radius: 8px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 28px; height: 28px; fill: white;" viewBox="0 0 24 24">
                                    <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                                </svg>
                            </div>
                            <span style="color: #333; font-size: 14px; font-weight: 600;">{{ $genset->nama_genset }}</span>
                        </div>
                    </td>
                    <td style="padding: 15px;">
                        <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                            @forelse($genset->categories as $cat)
                                <span style="background: #e3f2fd; color: #1976d2; padding: 4px 10px; border-radius: 5px; font-size: 11px; font-weight: 600;">
                                    {{ $cat->nama_kategori }}
                                </span>
                            @empty
                                <span style="color: #999; font-size: 12px;">-</span>
                            @endforelse
                        </div>
                    </td>
                    <td style="padding: 15px; color: #333; font-size: 14px; font-weight: 600;">
                        {{ $genset->kapasitas ?? '-' }}
                    </td>
                    <td style="padding: 15px; color: #333; font-size: 14px; font-weight: 600;">
                        Rp {{ number_format($genset->harga_sewa, 0, ',', '.') }}
                        <small style="color: #999; font-weight: 400; display: block; font-size: 12px;">/hari</small>
                    </td>
                    <td style="padding: 15px;">
                        @if($genset->status === 'tersedia')
                            <span style="background: #d4edda; color: #155724; padding: 5px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Tersedia</span>
                        @elseif($genset->status === 'disewa')
                            <span style="background: #fff3cd; color: #856404; padding: 5px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Disewa</span>
                        @else
                            <span style="background: #f8d7da; color: #721c24; padding: 5px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">Rusak</span>
                        @endif
                    </td>
                    <td style="padding: 15px;">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <a href="{{ route('admin.gensets.edit', $genset->id) }}" style="padding: 8px 12px; background: #ffc107; color: white; border-radius: 5px; text-decoration: none; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                                <svg style="width: 16px; height: 16px; fill: white;" viewBox="0 0 24 24">
                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                </svg>
                                Edit
                            </a>
                            
                            <form method="POST" action="{{ route('admin.gensets.destroy', $genset->id) }}" style="display: inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus genset ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="padding: 8px 12px; background: #dc3545; color: white; border: none; border-radius: 5px; font-size: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 5px;">
                                    <svg style="width: 16px; height: 16px; fill: white;" viewBox="0 0 24 24">
                                        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding: 40px; text-align: center; color: #999;">
                        <svg style="width: 64px; height: 64px; fill: #ddd; margin-bottom: 15px;" viewBox="0 0 24 24">
                            <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                        </svg>
                        <p style="font-size: 16px; margin: 0;">Tidak ada data genset</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    

    <!-- Pagination -->
    @if($gensets->hasPages())
    <div style="padding: 20px; border-top: 1px solid #e0e0e0;">
        {{ $gensets->links() }}
    </div>
    @endif
</div>
@endsection