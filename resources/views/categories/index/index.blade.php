@extends('layouts.app') {{-- Sesuaikan dengan nama layout kamu --}}

@section('content')
<div class="container">
    <h3>Data Kategori Items</h3>
    
    <div class="row mb-3">
        <div class="col-md-3">
            <input type="text" id="filter-kode" class="form-control" placeholder="Filter Kode">
        </div>
        <div class="col-md-3">
            <input type="text" id="filter-nama" class="form-control" placeholder="Filter Nama">
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary btn-get-data">Filter</button>
            <a href="{{ url('categories/form/new') }}" class="btn btn-success">Tambah Kategori</a>
        </div>
    </div>

    <table id="table-category" class="table table-bordered">
        <thead>
            <tr>
                <th>Kode Kategori</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        var table = $('#table-category').DataTable({
            searching: false,
            order: [[0, 'asc']]
        });

        getData();

        $('.btn-get-data').click(function() {
            getData();
        });

        function getData() {
            var kode = $('#filter-kode').val();
            var nama = $('#filter-nama').val();
            table.clear().draw();

            $.ajax({
                url: '{{ url("categories/search") }}',
                type: 'GET',
                data: { kode: kode, nama: nama },
                success: function(res) {
                    $.each(res.data, function(index, item) {
                        var row = [
                            item.kode,
                            item.nama,
                            `<a href="{{ url('categories/view') }}/${item.id}" class="btn btn-sm btn-info">View</a>
                             <a href="{{ url('categories/form/edit') }}/${item.id}" class="btn btn-sm btn-warning">Edit</a>
                             <a href="{{ url('categories/delete') }}/${item.id}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kategori ini?')">Delete</a>`
                        ];
                        table.row.add(row);
                    });
                    table.draw(false);
                }
            });
        }
    });
</script>
@endsection