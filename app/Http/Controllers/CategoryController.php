<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories.index.index');
    }


    // 2. Fungsi Search untuk AJAX (Poin 2 di Gambar)
    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;

        $data_search = Category::query();

        // Filter berdasarkan Nama dan Kode Kategori
        if (!empty($kode)) {
            $data_search->where('kode', $kode);
        }
        if (!empty($nama)) {
            $data_search->where('nama', 'LIKE', '%' . $nama . '%');
        }

        $data_search = $data_search->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => 200,
            'data' => $data_search
        ]);
    }
    public function singleView($id)
    {
        // "with('items')" digunakan agar data barang yang terkait langsung terbawa (Eager Loading)
        $data['category'] = Category::with('items')->find($id);

        if (!$data['category']) {
            return redirect('categories')->with('error', 'Kategori tidak ditemukan');
        }

        return view('categories.single.index', $data);
    }

    public function formView($method, $id = 0)
{
    if ($method == 'new') {
        // Buat objek kosong agar tidak error saat diakses di view
        $item = (object) ['id' => 0, 'kode' => '', 'nama' => ''];
    } else {
        $item = Category::find($id);
        if (!$item) return redirect('categories')->with('error', 'Data tidak ditemukan');
    }

    return view('categories.form.index', [
        'item' => $item,
        'method' => $method
    ]);
}


 public function formSubmit(Request $request, $method, $id = 0)
{
    // Validasi sederhana agar kode dan nama tidak kosong
    $request->validate([
        'kode' => 'required',
        'nama' => 'required',
    ]);

    if ($method == 'new') {
        // Jika tambah baru, buat instansiasi model baru
        $category = new \App\Models\Category;
    } else {
        // Jika edit, cari data berdasarkan ID
        $category = \App\Models\Category::find($id);
        
        if (!$category) {
            return redirect('categories')->with('error', 'Data tidak ditemukan');
        }
    }

    // Isi data dari form ke objek model
    $category->kode = $request->kode;
    $category->nama = $request->nama;
    
    //   dd($category->getAttributes());
    // Simpan ke database
    $category->save();

    // Redirect kembali ke halaman utama kategori
    return redirect('categories')->with('success', 'Data kategori berhasil disimpan');
}

public function delete($id)
{
    $category = \App\Models\Category::find($id);
    
    if ($category) {
        // Ini akan menghapus kategori 
        // Dan karena kita pakai 'onDelete-cascade' di migration pivot, 
        // relasi di tabel jembatan juga akan terhapus otomatis.
        $category->delete();
    }

    return redirect('categories')->with('success', 'Kategori berhasil dihapus');
}
}
