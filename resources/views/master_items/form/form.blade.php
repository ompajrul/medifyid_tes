{{-- Ganti URL sesuai route kamu --}}
<form action="{{ url('master-items/submit/'.$method.'/'.($item->id ?? 0)) }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    @if($method == 'edit')
    <div class="form-group mb-2">
        <label>Kode Barang</label>
        <input type="text" class="form-control" name="kode_barang" readonly value="{{$item->kode ?? ''}}">
    </div>
    @endif

    <div class="form-group mb-2">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama" required value="{{$item->nama ?? ''}}">
    </div>

    <div class="form-group mb-2">
        <label>Foto</label>
        {{-- Required hanya saat tambah baru (new) --}}
        <input type="file" class="form-control" name="image" accept="image/*" {{ $method == 'new' ? 'required' : '' }}>
        @if($method == 'edit' && $item->image)
            <small class="text-muted">File saat ini: {{ $item->image }}</small>
        @endif
    </div>

    <div class="form-group mb-2">
        <label>Kategori (Tahan Ctrl untuk pilih banyak)</label>
        <select name="categories[]" class="form-control" multiple>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" 
                    {{ (isset($item) && $item->categories->contains($cat->id)) ? 'selected' : '' }}>
                    {{ $cat->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-2">
        <label>Harga Beli</label>
        <input type="number" class="form-control" name="harga_beli" required value="{{$item->harga_beli ?? ''}}">
    </div>

    <div class="form-group mb-2">
        <label>Laba (%)</label>
        <input type="number" class="form-control" name="laba" required value="{{$item->laba ?? ''}}">
    </div>

    <div class="form-group mb-2">
        <label>Supplier</label>
        <select class="form-control" required name="supplier">
            <option value="" {{ ($item->supplier ?? '') == '' ? 'selected' : '' }}>--Pilih--</option>
            @foreach(['Tokopaedi', 'Bukulapuk', 'TokoBagas', 'E Commurz', 'Blublu'] as $sup)
                <option value="{{ $sup }}" {{ ($item->supplier ?? '') == $sup ? 'selected' : '' }}>{{ $sup }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-2">
        <label>Jenis</label>
        <select class="form-control" required name="jenis">
            <option value="" {{ ($item->jenis ?? '') == '' ? 'selected' : '' }}>--Pilih--</option>
            @foreach(['Obat', 'Alkes', 'Matkes', 'Umum', 'ATK'] as $jen)
                <option value="{{ $jen }}" {{ ($item->jenis ?? '') == $jen ? 'selected' : '' }}>{{ $jen }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Submit Data</button>
</form>