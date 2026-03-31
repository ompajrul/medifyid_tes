@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>{{ $method == 'new' ? 'Tambah' : 'Edit' }} Kategori</h4>
        </div>
        <div class="card-body">
            <form action="{{ url('categories/submit/'.$method.'/'.$item->id) }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="kode">Kode Kategori</label>
                    <input type="text" name="kode" id="kode" class="form-control" 
                           value="{{ $method == 'edit' ? $item->kode : '' }}" required 
                           placeholder="Contoh: OBT, ALK, MAT">
                </div>

                <div class="form-group mb-3">
                    <label for="nama">Nama Kategori</label>
                    <input type="text" name="nama" id="nama" class="form-control" 
                           value="{{ $method == 'edit' ? $item->nama : '' }}" required 
                           placeholder="Contoh: Obat-obatan">
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">
                        {{ $method == 'new' ? 'Simpan Data' : 'Update Data' }}
                    </button>
                    <a href="{{ url('categories') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection