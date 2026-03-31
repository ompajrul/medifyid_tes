<?php

namespace App\Http\Controllers;

use App\Models\MasterItem;
use Illuminate\Http\Request;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    // public function search(Request $request)
    // {
    //     $kode = $request->kode;
    //     $nama = $request->nama;
    //     $hargamin = $request->hargamin;
    //     $hargamax = $request->hargamax;
    //     $data_search = MasterItem::query();

    //     if (!empty($kode)) $data_search = $data_search->where('kode', $kode);
    //     if (!empty($nama)) $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');
    //     if (!empty($hargamin)) $data_search = $data_search->where('harga_beli', '>=', $hargamin);
    //     if (!empty($hargamax)) $data_search = $data_search->where('harga_beli', '<=', $hargamax);
        

    //     $data_search = $data_search->select('kode', 'nama','image','categories', 'jenis', 'harga_beli', 'laba', 'supplier')->orderBy('id')->get();


    //     return json_encode([
    //         'status' => 200,
    //         'data' => $data_search
    //     ]);
    // }

    public function search(Request $request)
{
    $kode = $request->kode;
    $nama = $request->nama;
    $hargamin = $request->hargamin;
    $hargamax = $request->hargamax;
    
    $data_search = MasterItem::query();

    if (!empty($kode)) $data_search = $data_search->where('kode', $kode);
    if (!empty($nama)) $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');
    if (!empty($hargamin)) $data_search = $data_search->where('harga_beli', '>=', $hargamin);
    if (!empty($hargamax)) $data_search = $data_search->where('harga_beli', '<=', $hargamax);

    // 1. GUNAKAN with('categories') untuk mengambil data relasi
    // 2. Tambahkan 'id' di select agar tombol edit/delete tidak error
    $data_search = $data_search->with('categories') 
        ->select('id', 'kode', 'nama', 'image', 'jenis', 'harga_beli', 'laba', 'supplier')
        ->orderBy('id')
        ->get();

    return response()->json([
        'status' => 200,
        'data' => $data_search
    ]);
}

    public function formView($method, $id = 0)
{
    $categories = \App\Models\Category::all();

    if ($method == 'new') {
        // JANGAN PAKAI $item = []; 
        // PAKAI INI:
        $item = new \App\Models\MasterItem(); 
    } else {
        $item = \App\Models\MasterItem::find($id);
    }

    return view('master_items.form.index', compact('item', 'method', 'categories'));
}

    public function singleView($kode)
    {
        $data['data'] = MasterItem::where('kode', $kode)->first();
        return view('master_items.single.index', $data);
    }

   public function formSubmit(Request $request, $method, $id = 0) 
{
    if ($method == 'new') {
        $item = new MasterItem;
        
        // --- TAMBAHKAN LOGIK KODE DI SINI ---
        $latest = MasterItem::orderBy('id', 'desc')->first();
        $newId = $latest ? $latest->id + 1 : 1;
        $item->kode = str_pad($newId, 5, '0', STR_PAD_LEFT); 
        // Hasilnya jadi: 00001, 00002, dst.
    } else {
        $item = MasterItem::find($id);
    }

    $item->nama = $request->nama;
    $item->harga_beli = $request->harga_beli;
    $item->laba = $request->laba;
    $item->supplier = $request->supplier;
    $item->jenis = $request->jenis;

    // Upload Foto
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . "_" . $file->getClientOriginalName();
        $file->move(public_path('uploads/items'), $filename);
        $item->image = $filename;
    }

    $item->save(); // Simpan Item

    // Simpan Kategori (Relasi Many-to-Many)
    if ($request->has('categories')) {
        $item->categories()->sync($request->categories);
    }

    return redirect('master-items')->with('success', 'Data Berhasil Disimpan!');
}
    public function delete($id)
    {
        MasterItem::find($id)->delete();
        return redirect('master-items');
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach($data as $item)
        {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100,1000000);
            $item->laba = rand(10,99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi','Bukulapuk','TokoBagas','E Commurz','Blublu'];
        $random = rand(0,4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat','Alkes','Matkes','Umum','ATK'];
        $random = rand(0,4);
        return $array[$random];
    }
}
