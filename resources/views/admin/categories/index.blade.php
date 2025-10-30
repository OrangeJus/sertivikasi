@extends('layouts.app')

@section('page-title', 'Kelola Kategori')

@section('content')
<div style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div>
            <h2 style="font-size: 28px; font-weight: 600; margin-bottom: 10px;">Kelola Kategori</h2>
            <p style="color: #666; font-size: 14px;">Manajemen kategori genset</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" style="padding: 12px 24px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
            <svg style="width: 20px; height: 20px; fill: white;" viewBox="0 0 24 24">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
            </svg>
            Tambah Kategori
        </a>
    </div>
</div>

<!-- Success Message -->
@if (session('success'))
    <div class="alert alert-success" style="margin-bottom: 25px;">
        {{ session('success') }}
    </div>
@endif

<!-- Statistics Card -->
<div class="card" style="margin-bottom: 30px;">
    <div style="display: flex; align-items: center; gap: 20px;">
        <div style="width: 60px; height: 60px; border-radius: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
            <svg style="width: 32px; height: 32px; fill: white;" viewBox="0 0 24 24">
                <path d="M12 2l-5.5 9h11L12 2zm0 3.84L13.93 9h-3.87L12 5.84zM17.5 13c-2.49 0-4.5 2.01-4.5 4.5s2.01 4.5 4.5 4.5 4.5-2.01 4.5-4.5-2.01-4.5-4.5-4.5zm0 7c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5zM3 21.5h8v-8H3v8zm2-6h4v4H5v-4z"/>
            </svg>
        </div>
        <div>
            <p style="color: #999; font-size: 14px; margin-bottom: 5px;">Total Kategori</p>
            <p style="color: #333; font-size: 32px; font-weight: 700; margin: 0;">{{ $categories->count() }}</p>
        </div>
    </div>
</div>

<!-- Categories Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px;">
    @forelse($categories as $category)
    <div class="card" style="position: relative; transition: all 0.3s;">
        <div style="margin-bottom: 15px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                <div style="width: 50px; height: 50px; border-radius: 10px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 28px; height: 28px; fill: white;" viewBox="0 0 24 24">
                        <path d="M12 2l-5.5 9h11L12 2zm0 3.84L13.93 9h-3.87L12 5.84zM17.5 13c-2.49 0-4.5 2.01-4.5 4.5s2.01 4.5 4.5 4.5 4.5-2.01 4.5-4.5-2.01-4.5-4.5-4.5zm0 7c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5zM3 21.5h8v-8H3v8zm2-6h4v4H5v-4z"/>
                    </svg>
                </div>
                <div style="flex: 1;">
                    <h3 style="font-size: 18px; font-weight: 600; color: #333; margin: 0;">{{ $category->nama_kategori }}</h3>
                    <p style="font-size: 12px; color: #999; margin: 5px 0 0 0;">
                        <svg style="width: 14px; height: 14px; fill: #999; display: inline-block; vertical-align: middle; margin-right: 3px;" viewBox="0 0 24 24">
                            <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
                        </svg>
                        {{ $category->gensets->count() }} Genset
                    </p>
                </div>
            </div>
        </div>

        @if($category->deskripsi)
        <p style="color: #666; font-size: 14px; line-height: 1.6; margin-bottom: 20px;">
            {{ $category->deskripsi }}
        </p>
        @else
        <p style="color: #999; font-size: 14px; font-style: italic; margin-bottom: 20px;">
            Tidak ada deskripsi
        </p>
        @endif

        <div style="display: flex; gap: 10px; padding-top: 15px; border-top: 2px solid #f0f0f0;">
            <a href="{{ route('admin.categories.edit', $category->id) }}" style="flex: 1; padding: 10px; background: #ffc107; color: white; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 5px;">
                <svg style="width: 16px; height: 16px; fill: white;" viewBox="0 0 24 24">
                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                </svg>
                Edit
            </a>
            
            <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" style="flex: 1;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Genset yang menggunakan kategori ini akan terpengaruh.');">
                @csrf
                @method('DELETE')
                <button type="submit" style="width: 100%; padding: 10px; background: #dc3545; color: white; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 5px;">
                    <svg style="width: 16px; height: 16px; fill: white;" viewBox="0 0 24 24">
                        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                    </svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>
    @empty
    <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px;">
        <svg style="width: 80px; height: 80px; fill: #ddd; margin-bottom: 20px;" viewBox="0 0 24 24">
            <path d="M12 2l-5.5 9h11L12 2zm0 3.84L13.93 9h-3.87L12 5.84zM17.5 13c-2.49 0-4.5 2.01-4.5 4.5s2.01 4.5 4.5 4.5 4.5-2.01 4.5-4.5-2.01-4.5-4.5-4.5zm0 7c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5zM3 21.5h8v-8H3v8zm2-6h4v4H5v-4z"/>
        </svg>
        <p style="font-size: 18px; color: #999; margin: 0;">Belum ada kategori</p>
        <p style="font-size: 14px; color: #bbb; margin-top: 10px;">Klik tombol "Tambah Kategori" untuk membuat kategori baru</p>
    </div>
    @endforelse
</div>
@endsection