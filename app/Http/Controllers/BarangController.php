<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Daftar Barang',
            'list' => ['Home','Barang']
        ];

        $page = (object)[
            'title' => 'Daftar barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'barang'; //set menu yang aktif

        $kategori = KategoriModel::all(); //untuk filter kategori

        return view('barang.index',['breadcrumb'=>$breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $barangs = BarangModel::select('barang_id', 'kategori_id','barang_kode', 'barang_nama', 'harga_beli','harga_jual','image')
            ->with('barang');

        //filter data user berdasarkan kategori_id
        if($request->kategori_id){
            $barangs->where('kategori_id',$request->kategori_id);
        }
    
        return DataTables::of($barangs)
            ->addIndexColumn()
            ->addColumn('aksi', function ($barang) {
                $btn = '<a href="' . url('/barang/' . $barang->barang_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/barang/' . $barang->barang_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/barang/'.$barang->barang_id) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Barang',
            'list'  => ['Home', 'Barang', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Barang baru'
        ];

        $kategori = KategoriModel::all(); 
        $activeMenu = 'barang';
        
        return view('barang.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_kode'      => 'required|string|max:10|min:2',
            'barang_nama'      => 'required|string|max:100|',
            'kategori_id'      => 'required|integer',
            'harga_beli'      => 'required|integer',
            'harga_jual'      => 'required|integer',
            'gambar'            => 'required|file|image|max:1000'
        ]);

        $extFile = $request->gambar->getClientOriginalExtension();
        $namaFile = $request->barang_kode."_".$request->barang_nama.".$extFile";
        $request->gambar->storeAs('public/barang', $namaFile);
        $path = 'barang/'.$namaFile;

        BarangModel::create([
            'barang_kode'  => $request->barang_kode,
            'barang_nama'  => $request->barang_nama,
            'kategori_id'      => $request->kategori_id,
            'harga_beli'      => $request->harga_beli,
            'harga_jual'      => $request->harga_jual,
            'image'     => $path
        ]);

        return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
    }

    public function show(string $id)
    {
        $barang = BarangModel::with('barang')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Barang',
            'list'  => ['Home', 'Barang', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Barang'
        ];

        $activeMenu = 'barang'; // set menu yang sedang aktif
        
        return view('barang.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id)
     {
         $barang = BarangModel::find($id);
         $kategori = KategoriModel::all();
 
         $breadcrumb = (object) [
             'title' => 'Edit Barang',
             'list'  => ['Home', 'Barang', 'Edit']
         ];
 
         $page = (object) [
             'title' => 'Edit barang'
         ];
 
         $activeMenu = 'barang'; // set menu yang sedang aktif
         
         return view('barang.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
     }

     public function update(Request $request, string $id)
     {
         $request->validate([
            'barang_kode'      => 'required|string|max:10|min:2',
            'barang_nama'      => 'required|string|max:100|',
            'kategori_id'      => 'required|integer',
            'harga_beli'      => 'required|integer',
            'harga_jual'      => 'required|integer',
            'gambar'            => 'nullable|image|max:1000'
         ]);

         if($request->gambar){
            $extFile = $request->gambar->getClientOriginalExtension();
            $namaFile = $request->level_id."_".$request->username.".$extFile";
            $request->gambar->storeAs('public/barang', $namaFile);
            $path = 'barang/'.$namaFile;            
         }
 
         BarangModel::find($id)->update([
            'barang_kode'  => $request->barang_kode,
            'barang_nama'  => $request->barang_nama,
            'kategori_id'      => $request->kategori_id,
            'harga_beli'      => $request->harga_beli,
            'harga_jual'      => $request->harga_jual,
            'image'    => $request->gambar ? $path : BarangModel::find($id)->image
         ]);
 
         return redirect('/barang')->with('success', 'Data barang berhasil diubah');
     }

     public function destroy(string $id)
    {
        $check = BarangModel::find($id); 
        if (!$check) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }

        try {
            BarangModel::destroy($id);

            return redirect('/barang')->with('success', 'Data barang berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/barang')->with('error', 'Data barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
