<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
    var start_date = '';
    var end_date = '';
    var data_per_fetch = 500;
    var data_fetched = 0;

    $(document).ready(function() {
        $('#table').DataTable({
            searching: false,
            order: [[0, 'desc']],
        });
        getData()
    });

    $('.btn-get-data').click(function() {
        getData()
    })

   
    function getData(){
        
        $('#loading-filter').show();
        var dataTableObj = $('#table').DataTable();
        var filter_kode = $('#filter-kode').val()
        var filter_nama = $('#filter-nama').val()
        var filter_harga_min = $('#filter-harga-min').val()
        var filter_harga_max = $('#filter-harga-max').val()
        dataTableObj.clear().draw();

        $.ajax({
            url: '{{url("master-items/search")}}',
            dataType: 'json',
            tryCount: 0,
            retryLimit: 3,
            // data: 'kode=' + filter_kode + '&nama=' + filter_nama + '&hargamin=' + filter_harga_min + '&hargamax=' + filter_harga_max,
            data:{
                kode:filter_kode,
                nama: filter_nama,
                hargamin:filter_harga_min,
                hargamax:filter_harga_max
            },
            success: function(results) {
                var data = results.data

                $.each(data, function(index, item) {
                    // array_temp = [];
                    // var harga_jual = item.harga_beli + item.harga_beli * item.laba / 100;
                    // harga_jual = Math.round(harga_jual)
                    // // array_temp.push(htmlFoto);
                    // var kode = item.kode;

                    // var fotoUrl = item.image ? `{{ asset('uploads/items') }}/${item.image}` : `{{ asset('images/no-image.png') }}`;
                    // var htmlFoto = `<img src="${fotoUrl}" style="width: 50px; height: auto;" class="img-thumbnail">`;
                    // var htmlAction = `<a href="{{url('master-items/view/')}}/` + kode + `" class="btn btn-primary">View</a>`;

                    // var html = `<a href="{{url('master-items/view/')}}/` + kode + `" class="btn btn-primary">View</a>`

                    // $.each(item, function(obj_name, obj_value) {
                    //     if (obj_name == 'laba') return false;
                    //     array_temp.push(obj_value)
                    // })
                    
                    // array_temp.push(harga_jual)
                    // array_temp.push(item.supplier)
                    // array_temp.push(html)

                    var array_temp = [];
    
                    // Hitung Harga Jual
                    var harga_jual = Math.round(item.harga_beli + (item.harga_beli * item.laba / 100));

                    // --- BAGIAN TAMPILIN GAMBAR ---
                    // Cek apakah ada nama file di database. Jika ada, arahkan ke folder uploads.
                    var fotoUrl = item.image 
                        ? `{{ asset('uploads/items') }}/${item.image}` 
                        : `{{ asset('images/no-image.png') }}`;
                    
                    // Buat tag <img> agar yang muncul adalah gambarnya, bukan teksnya
                    var htmlFoto = `<img src="${fotoUrl}" style="width: 50px; height: 50px; object-fit: cover;" class="img-thumbnail" onerror="this.src='{{ asset('uploads/items/no-image.png') }}'">`;
                    // ------------------------------

                    var htmlAction = `<a href="{{url('master-items/view/')}}/${item.kode}" class="btn btn-primary">View</a>`;

                    // MASUKKAN KE ARRAY SESUAI URUTAN <th> (Kode, Nama, Gambar, Jenis, dst)
                    array_temp.push(item.kode);       // Kolom 0: Kode
                    array_temp.push(item.nama);       // Kolom 1: Nama
                    array_temp.push(htmlFoto);        // Kolom 2: Gambar (Ini yang bikin gambar muncul)
                    array_temp.push(item.jenis);      // Kolom 3: Jenis
                    array_temp.push(item.harga_beli); // Kolom 4: Harga Beli
                    array_temp.push(harga_jual);      // Kolom 5: Harga Jual
                    array_temp.push(item.supplier);   // Kolom 6: Supplier
                    array_temp.push(htmlAction);      // Kolom 7: View

                    dataTableObj.row.add(array_temp).draw(true);
                });
                $('#loading-filter').hide();
            },
            error: function(xhr, textStatus, errorThrown) {
                this.tryCount++;
                if (this.tryCount <= this.retryLimit) {
                    $.ajax(this);
                    return;
                }
                alert('Terjadi kesalahan server, tidak dapat mengambil data')
                $('#loading-filter').hide();

                return;
            }
        })
    }
</script>