<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\StokModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Stok Barang',
            'list' => ['Home','Stok']
        ];

        $page = (object)[
            'title' => 'Stok barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'stok'; //set menu yang aktif

        $user = UserModel::all(); //untuk filter

        return view('stok.index',['breadcrumb'=>$breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $stoks = StokModel::select('stok_id','barang_id','user_id','stok_tanggal','stok_jumlah')
            ->with(['barang', 'user']);

        if($request->user_id){
            $stoks->where('user_id',$request->user_id);
        }
    
        return DataTables::of($stoks)
            ->addIndexColumn()
            ->addColumn('aksi', function ($stok) {
                $btn = '<a href="' . url('/stok/' . $stok->stok_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/stok/' . $stok->stok_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/stok/'.$stok->stok_id) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Stok Barang',
            'list'  => ['Home', 'Stok', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Stok Barang'
        ];

        $barang = BarangModel::all();
        $user = UserModel::all(); 
        $activeMenu = 'stok';
        
        return view('stok.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'user'=>$user, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id'    => 'required|integer',
            'user_id'      => 'required|integer',
            'stok_tanggal' => 'required|date',
            'stok_jumlah'  => 'required|integer'
            
        ]);

        StokModel::create([
            'barang_id'    => $request->barang_id,
            'user_id'      => $request->user_id,
            'stok_tanggal' => $request->stok_tanggal,
            'stok_jumlah'  => $request->stok_jumlah,
            'created_at'   => now()
        ]);

        return redirect('/stok')->with('success', 'Data stok barang berhasil disimpan');
    }

    public function show(string $id)
    {
        $stok = StokModel::with(['barang','user'])->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Stok',
            'list'  => ['Home', 'Stok', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Stok Barang'
        ];

        $activeMenu = 'stok'; // set menu yang sedang aktif
        
        return view('stok.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id)
     {
         $stok = StokModel::find($id);
         $barang = BarangModel::all();
         $user = UserModel::all(); 
 
         $breadcrumb = (object) [
             'title' => 'Edit Stok Barang',
             'list'  => ['Home', 'Stok', 'Edit']
         ];
 
         $page = (object) [
             'title' => 'Edit Stok barang'
         ];
 
         $activeMenu = 'stok'; // set menu yang sedang aktif
         
         return view('stok.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'user'=> $user, 'stok' => $stok, 'activeMenu' => $activeMenu]);
     }

     public function update(Request $request, string $id)
     {
         $request->validate([
            'barang_id'    => 'required|integer',
            'user_id'      => 'required|integer',
            'stok_tanggal' => 'required|date',
            'stok_jumlah'  => 'required|integer'
         ]);
 
         StokModel::find($id)->update([
            'barang_id'    => $request->barang_id,
            'user_id'      => $request->user_id,
            'stok_tanggal' => $request->stok_tanggal,
            'stok_jumlah'  => $request->stok_jumlah,
            'updated_at'   => now()
         ]);
 
         return redirect('/stok')->with('success', 'Data stok barang berhasil diubah');
     }

     public function destroy(string $id)
    {
        $check = StokModel::find($id); 
        if (!$check) {
            return redirect('/stok')->with('error', 'Data stok barang tidak ditemukan');
        }

        try {
            StokModel::destroy($id);

            return redirect('/stok')->with('success', 'Data stok barang berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/stok')->with('error', 'Data stok barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
