@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Detail Kategori: {{ $category->nama }}</h4>
            <a href="{{ url('categories') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <table class="table table-borderless w-50">
                <tr>
                    <th>Kode Kategori</th>
                    <td>: {{ $category->kode }}</td>
                </tr>
                <tr>
                    <th>Nama Kategori</th>
                    <td>: {{ $category->nama }}</td>
                </tr>
            </table>

            <hr>
            
            <h5>Daftar Item dalam Kategori Ini:</h5>
            <table class="table table-striped table-bordered mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode Item</th>
                        <th>Nama Item</th>
                        <th>Harga Beli</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($category->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->kode }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada item untuk kategori ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection