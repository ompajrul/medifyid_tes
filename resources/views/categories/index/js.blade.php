@section('js')
<script>
    // Gunakan fungsi ini agar script menunggu semua library siap
    $(document).ready(function() {
        console.log("jQuery siap, memulakan DataTable...");

        var table = $('#table-category').DataTable({
            searching: false,
            order: [[0, 'asc']]
        });

        // Panggil fungsi ambil data
        getData(table);

        $('.btn-get-data').click(function() {
            getData(table);
        });
    });

    function getData(dataTableObj) {
        $.ajax({
            url: '{{ url("categories/search") }}',
            type: 'GET',
            success: function(res) {
                dataTableObj.clear();
                $.each(res.data, function(index, item) {
                    dataTableObj.row.add([
                        item.kode,
                        item.nama,
                        `<a href="{{ url('categories/view') }}/${item.id}" class="btn btn-sm btn-info">View</a>`
                    ]);
                });
                dataTableObj.draw(false);
            }
        });
    }
</script>